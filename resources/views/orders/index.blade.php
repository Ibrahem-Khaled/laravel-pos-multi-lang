@extends('layouts.admin')

@section('title', __('order.Orders_List'))
@section('content-header', __('order.Orders_List'))
@section('content-actions')
    <a href="{{ route('cart.index') }}" class="btn btn-primary">{{ __('cart.title') }}</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-8">
                    <form action="{{ route('orders.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}" />
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}" />
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="order_id" class="form-control" value="{{ request('order_id') }}"
                                    placeholder="{{ __('order.Order_ID') }}" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-primary" type="submit">{{ __('order.submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('order.ID') }}</th>
                        <th>{{ __('order.Customer_Name') }}</th>
                        <th>{{ __('order.Total') }}</th>
                        <th>{{ __('order.Received_Amount') }}</th>
                        <th>{{ __('order.Status') }}</th>
                        <th>{{ __('order.To_Pay') }}</th>
                        <th>{{ __('order.Created_At') }}</th>
                        <th>{{ __('order.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->getCustomerName() }}</td>
                            <td>{{ config('settings.currency_symbol') }} {{ $order->formattedTotal() }}</td>
                            <td>{{ config('settings.currency_symbol') }} {{ $order->formattedReceivedAmount() }}</td>
                            <td>
                                @if ($order->payments()->count() == 0)
                                    <span class="badge badge-info">{{ __('order.Refund') }}</span>
                                @elseif($order->receivedAmount() < $order->total())
                                    <span class="badge badge-warning">{{ __('order.Partial') }}</span>
                                @elseif($order->receivedAmount() == $order->total())
                                    <span class="badge badge-success">{{ __('order.Paid') }}</span>
                                @elseif($order->receivedAmount() > $order->total())
                                    <span class="badge badge-info">{{ __('order.Change') }}</span>
                                @elseif($order->receivedAmount() == 0)
                                    <span class="badge badge-danger">{{ __('order.Not_Paid') }}</span>
                                @endif
                            </td>
                            <td>{{ config('settings.currency_symbol') }}
                                {{ number_format($order->total() - $order->receivedAmount(), 2) }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <button class="btn btn-info text-white" data-toggle="modal"
                                    data-target="#productsModal-{{ $order->id }}">
                                    {{ __('order.View_Products') }}
                                </button>
                                <div class="modal fade" id="productsModal-{{ $order->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="productsModalLabel-{{ $order->id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="productsModalLabel-{{ $order->id }}">
                                                    {{ __('order.Products_List') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($order->items && $order->items->count() > 0)
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ __('product.Name') }}</th>
                                                                <th>{{ __('product.Barcode') }}</th>
                                                                <th>{{ __('product.Quantity') }}</th>
                                                                <th>{{ __('product.Price') }}</th>
                                                                <th>{{ __('order.Status') }}</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order->items as $product)
                                                                <tr>
                                                                    <td>{{ $product->product->name }}</td>
                                                                    <td>{{ $product->product->barcode }}</td>
                                                                    <td>{{ $product->quantity }}</td>
                                                                    <td>{{ number_format($product->price, 2) }}</td>
                                                                    <td>
                                                                        @if ($product->is_refunded)
                                                                            <span
                                                                                class="badge badge-danger">{{ __('order.Returned') }}</span>
                                                                        @else
                                                                            <form
                                                                                action="{{ route('returnAndDelete', $product->id) }}"
                                                                                method="POST" style="display: inline;">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <button
                                                                                    class="btn btn-danger btn-delete btn-sm"
                                                                                    type="submit">
                                                                                    {{ __('order.Not_Returned') }}
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <p>{{ __('order.No_Products') }}</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">{{ __('order.Close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <form action="{{ route('returnAndDelete', $order) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-danger btn-delete" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                        <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            {{ $orders->render() }}
        </div>
    </div>
@endsection
