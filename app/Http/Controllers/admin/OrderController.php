<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * 自分のショップの注文一覧を表示（絞り込み・並べ替え機能付き）
     */
    public function index(Request $request)
    {
        // 【先行実装用モック】テスト用のショップID（1）を固定
        $mockShopId = 1;

        // クエリビルダの開始（リレーションも一緒にロード）
        $query = OrderDetail::with(['order.user', 'product'])
            ->whereHas('product', function ($q) use ($mockShopId) {
                $q->where('shop_id', $mockShopId);
            });

        // 🔍 1. 配送ステータスでの絞り込み
        if ($request->filled('delivery_status')) {
            $query->where('delivery_status', $request->delivery_status);
        }

        // 🔃 2. 並べ替え（デフォルトは新しい順）
        $sort = $request->input('sort', 'desc'); // 指定がなければ 'desc' (新しい順)
        if ($sort === 'asc') {
            $query->orderBy('created_at', 'asc');  // 古い順
        } else {
            $query->orderBy('created_at', 'desc'); // 新しい順
        }

        // データの取得
        $orderDetails = $query->get();

        // 画面に「現在選択されている条件」も一緒に渡す
        return view('admin.orders.index', compact('orderDetails', 'request'));
    }

    /**
     * 配送ステータスの更新
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'delivery_status' => 'required|string|in:preparing,shipped,delivered',
        ]);

        $orderDetail = OrderDetail::findOrFail($id);
        $orderDetail->update([
            'delivery_status' => $request->delivery_status,
        ]);

        // 更新後も、現在かかっている検索フィルターを維持してリダイレクト
        return redirect()
            ->route('admin.orders.index', $request->only(['delivery_status', 'sort']))
            ->with('status', '注文ID: ' . $orderDetail->order_id . ' の配送ステータスを更新しました。');
    }
}