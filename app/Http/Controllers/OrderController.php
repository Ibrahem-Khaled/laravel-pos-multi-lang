<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = new Order();
        if ($request->start_date) {
            $orders = $orders->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $orders = $orders->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        if ($request->order_id) {
            $orders = $orders->where('id', $request->order_id);
        }
        $orders = $orders->with(['items', 'payments', 'customer'])->latest()->paginate(10);

        $total = $orders->map(function ($i) {
            return $i->total();
        })->sum();
        $receivedAmount = $orders->map(function ($i) {
            return $i->receivedAmount();
        })->sum();

        return view('orders.index', compact('orders', 'total', 'receivedAmount'));
    }

    public function store(OrderStoreRequest $request)
    {
        $order = Order::create([
            'customer_id' => $request->customer_id,
            'user_id' => $request->user()->id,
        ]);

        $cart = $request->user()->cart()->get();
        foreach ($cart as $item) {
            $order->items()->create([
                'price' => $item->price * $item->pivot->quantity,
                'quantity' => $item->pivot->quantity,
                'product_id' => $item->id,
            ]);
            $item->quantity = $item->quantity - $item->pivot->quantity;
            $item->save();
        }
        $request->user()->cart()->detach();
        $order->payments()->create([
            'amount' => $request->amount,
            'user_id' => $request->user()->id,
        ]);
        return 'success';
    }


    public function returnAndDelete($order)
    {
        $orderItem = OrderItem::findOrFail($order);
        $product = Product::findOrFail($orderItem->product_id);
        $mainOrder = Order::findOrFail($orderItem->order_id);
        $payment = Payment::where('order_id', $orderItem->order_id)->first();


        $payment->amount = $payment->amount - $orderItem->price;
        $payment->save();

        $product->quantity = $product->quantity + $orderItem->quantity;
        $product->save();

        $orderItem->is_refunded = true;
        $orderItem->price = 0;
        $orderItem->save();



        return redirect()->back()->with('success', 'Product returned successfully');
    }

}
