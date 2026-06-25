<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $shopId = session('shopId');

        $query = OrderDetail::with(['order.user', 'product'])
            ->whereHas('product', function ($q) use ($shopId) {
                $q->where('shop_id', $shopId);
            });

        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }

        $sort = $request->input('sort', 'desc');
        if ($sort === 'asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $orderDetails = $query->get();

        return view('admin.orders.index', compact('orderDetails', 'request'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'delivery_status' => 'required|string|in:preparing,shipped,delivered',
        ]);

        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->update([
            'delivery_status' => $request->delivery_status,
        ]);

        return redirect()
            ->route('admin.orders.index', $request->only(['delivery_status', 'sort']))
            ->with('status', '注文ID: ' . $orderDetail->order_id . ' の配送ステータスを更新しました');
    }
}