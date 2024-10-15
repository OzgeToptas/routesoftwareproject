<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Orders;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ImportCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $csvFilePath;

    public function __construct($csvFilePath)
    {
        $this->csvFilePath = $csvFilePath;
    }

    public function handle()
    {
        Log::info("message");
        $filePath = Storage::path($this->csvFilePath);
        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle);
            $columnIndexes = array_flip($header);

            $requiredColumns = [
              'order_id',
              'first_name',
              'last_name',
              'email',
              'shipping_address',
              'billing_address',
              'fulfillment_status',
              'payment_status',
              'SKU',
              'item_name',
              'item_parts',
              'item_parts_quantity',
              'item_part_prices',
              'grand_total'
            ];

            foreach ($requiredColumns as $column) {
                if (!isset($columnIndexes[$column])) {
                    throw new \Exception("Required column $column is missing.");
                }
            }

            while (($data = fgetcsv($handle)) !== false) {
                $orderData = [];
                foreach ($requiredColumns as $column) {
                    $orderData[$column] = $data[$columnIndexes[$column]] ?? null;
                }
                $order = Orders::updateOrCreate(
                    ['id' => $orderData['order_id']],
                    [
                        'first_name'            => $orderData['first_name'],
                        'last_name'             => $orderData['last_name'],
                        'email'                 => $orderData['email'],
                        'shipping_address'      => $orderData['shipping_address'],
                        'billing_address'       => $orderData['billing_address'],
                        'fulfillment_status'    => $orderData['fulfillment_status'],
                        'payment_status'        => $orderData['payment_status'],
                    ]
                );

                $order->cart()->updateOrCreate(
                    ['order_id' => $orderData['order_id']],
                    [
                        'sku'                   => $orderData['item_name'],
                        'item_name'             => $orderData['item_name'],
                        'item_parts'            => $orderData['item_parts'],
                        'item_parts_quantity'   => $orderData['item_parts_quantity'],
                        'item_part_prices'      => $orderData['item_part_prices'],
                        'grand_total'           => $orderData['grand_total'],
                    ]
                );
                Http::fake([
                    'https://test.myshopify.com/*' => Http::response($orderData, 200)
                ]);
            }

            fclose($handle);
        }
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
    }
}
