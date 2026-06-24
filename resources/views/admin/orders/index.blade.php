<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>【テスト用】注文管理一覧 - 管理画面</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">注文管理一覧（ショップID: 1 の注文）</h2>
        <a href="{{ route('admin.products.index') }}" class="text-sm bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600 transition">
            商品一覧へ
        </a>
    </div>

    @if (session('status'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('admin.orders.index') }}" method="GET" class="mb-6 p-4 bg-gray-50 rounded-md border flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">配送ステータス</label>
            <select name="delivery_status" class="rounded border-gray-300 p-2 text-sm bg-white border min-w-[150px]">
                <option value="">すべて表示</option>
                <option value="preparing" {{ $request->delivery_status == 'preparing' ? 'selected' : '' }}>出荷準備中</option>
                <option value="shipped" {{ $request->delivery_status == 'shipped' ? 'selected' : '' }}>出荷済</option>
                <option value="delivered" {{ $request->delivery_status == 'delivered' ? 'selected' : '' }}>配達完了</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">並べ替え</label>
            <select name="sort" class="rounded border-gray-300 p-2 text-sm bg-white border min-w-[150px]">
                <option value="desc" {{ $request->sort == 'desc' ? 'selected' : '' }}>注文の新しい順</option>
                <option value="asc" {{ $request->sort == 'asc' ? 'selected' : '' }}>注文の古い順</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-blue-700 transition">
                条件を適用
            </button>
            @if($request->filled('delivery_status') || $request->input('sort') === 'asc')
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300 transition">
                    クリア
                </a>
            @endif
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">注文日 / 注文ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">購入者情報</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">商品名 / 単価</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">数量 / 小計</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">配送ステータス</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @forelse($orderDetails as $detail)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900 font-medium">{{ $detail->created_at ? $detail->created_at->format('Y-m-d H:i') : 'N/A' }}</div>
                            <div class="text-gray-500 text-xs">注文ID: #{{ $detail->order_id }}</div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="text-gray-900 font-bold">{{ $detail->order->shipping_name ?? $detail->order->user->name }}</div>
                            <div class="text-gray-500 text-xs">
                                〒{{ $detail->order->shipping_address ?? $detail->order->user->address }}<br>
                                TEL: {{ $detail->order->shipping_phone ?? $detail->order->user->user_phone }}
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900 font-medium">{{ $detail->product->name ?? '削除された商品' }}</div>
                            <div class="text-gray-500">¥{{ number_format($detail->price) }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-gray-900">{{ $detail->quantity }} 個</div>
                            <div class="text-gray-700 font-bold">¥{{ number_format($detail->price * $detail->quantity) }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.orders.updateStatus', $detail->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PATCH')
                                
                                <input type="hidden" name="current_delivery_status" value="{{ $request->delivery_status }}">
                                <input type="hidden" name="current_sort" value="{{ $request->sort }}">

                                <select name="delivery_status" class="rounded border-gray-300 p-1 text-sm bg-gray-50 border">
                                    <option value="preparing" {{ $detail->delivery_status == 'preparing' ? 'selected' : '' }}>出荷準備中</option>
                                    <option value="shipped" {{ $detail->delivery_status == 'shipped' ? 'selected' : '' }}>出荷済</option>
                                    <option value="delivered" {{ $detail->delivery_status == 'delivered' ? 'selected' : '' }}>配達完了</option>
                                </select>
                                <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700 transition">
                                    更新
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            該当する注文は見つかりませんでした。
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>