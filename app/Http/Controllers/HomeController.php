<?php

namespace App\Http\Controllers;

use App\Jobs\ImportCsv;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      request()->flush();
      $query = Orders::query();

      if ($request->has('search')) {
          $search = $request->input('search');
          $query->where(function($q) use ($search) {
              $q->where('first_name', 'LIKE', "%{$search}%")
                ->orWhere('last_name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('shipping_address', 'LIKE', "%{$search}%")
                ->orWhere('billing_address', 'LIKE', "%{$search}%")
                ->orWhere('fulfillment_status', 'LIKE', "%{$search}%")
                ->orWhere('payment_status', 'LIKE', "%{$search}%")
                ->orWhereHas('cart', function($q) use ($search) {
                    $q->where('SKU', 'LIKE', "%{$search}%")
                      ->orWhere('item_name', 'LIKE', "%{$search}%")
                      ->orWhere('item_parts', 'LIKE', "%{$search}%")
                      ->orWhere('item_parts_quantity', 'LIKE', "%{$search}%")
                      ->orWhere('item_part_prices', 'LIKE', "%{$search}%")
                      ->orWhere('grand_total', 'LIKE', "%{$search}%");
                });
          });
      }

      $orders = $query->paginate(10);

      return view('home', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'file' => 'required|mimes:csv',
      ]);
      if ($validator->fails()) {
          return back()
            ->withErrors($validator)
            ->withInput();
      }

      $handle = fopen($request->file('file'), "r");
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
          return back()->withErrors([
            'err' => "Required column $column is missing.",
          ])->withInput();
        }
      }
      $path = $request->file('file')->store('uploads');
      ImportCsv::dispatch($path);
      sleep(5);
      return back()->with('message', 'File uploaded successfully');
    }

}
