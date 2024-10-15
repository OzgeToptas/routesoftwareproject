@extends('layouts.master')
@section('title','Home Page')
@section('content')
<div class="home-container mt-5">
  @if(strlen(session('message'))>0)
  <div class="alert alert-success">{{ session('message') }}</div>
  @endif
  @if ($errors->any())
      <div class="alert alert-warning">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
  <form class="row g-3" action="{{ route('upload-file') }}" method="POST" enctype="multipart/form-data">
    <div class="col-auto">
      <input class="form-control" type="file" name="file" id="formFile">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary mb-3">Upload File</button>
    </div>
    @csrf
  </form>
  <form action="{{ route('home') }}" method="GET">
  <div class="row g-3 align-items-center" style="float:right">
    <div class="col-auto">
      <label for="search" class="col-form-label">Search</label>
    </div>
    <div class="col-auto">
      <input type="text" id="search" name="search" value="{{ old('search') }}" class="form-control" aria-describedby="passwordHelpInline">
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-secondary">Search</button>
    </div>
  </div>
  </form>
  <table class="table table-hover table-responsive table-sm">
    <thead>
      <tr>
        <th scope="col">Order ID</th>
        <th scope="col">First Name</th>
        <th scope="col">Last Name</th>
        <th scope="col">Email</th>
        <th scope="col">Shipping Address</th>
        <th scope="col">Billing Address</th>
        <th scope="col">Fulfillment Status</th>
        <th scope="col">Payment Status</th>
        <th scope="col">SKU</th>
        <th scope="col">Item Name</th>
        <th scope="col">Item Parts</th>
        <th scope="col">Item Parts Quantity</th>
        <th scope="col">Item Part Prices</th>
        <th scope="col">Grand Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
        <tr>
          <th scope="row">{{ $order->id }}</th>
          <td>{{ $order->first_name }}</td>
          <td>{{ $order->last_name }}</td>
          <td>{{ $order->email }}</td>
          <td>{{ $order->shipping_address }}</td>
          <td>{{ $order->billing_address }}</td>
          <td>{{ $order->fulfillment_status }}</td>
          <td>{{ $order->payment_status }}</td>
          <td>{{ $order->cart->sku }}</td>
          <td>{{ $order->cart->item_name }}</td>
          <td>{{ $order->cart->item_parts }}</td>
          <td>{{ $order->cart->item_parts_quantity }}</td>
          <td>{{ $order->cart->item_part_prices }}</td>
          <td>{{ $order->cart->grand_total }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $orders->links() }}
</div>
@endsection
