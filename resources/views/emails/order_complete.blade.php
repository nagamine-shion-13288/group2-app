<p>{{ $userName }} 様</p>

<p>この度はJUNGLIAをご利用いただき、誠にありがとうございます。<br>
ご注文の手続きが完了いたしました。</p>

<hr>
<h3>■ ご注文内容</h3>
<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2; text-align: left;">
            <th style="padding: 8px; border-bottom: 1px solid #ddd;">商品名</th>
            <th style="padding: 8px; border-bottom: 1px solid #ddd; text-align: center;">数量</th>
            <th style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right;">小計</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cartItems as $item)
        <tr>
            <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $item->name }}</td>
            <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: center;">{{ $item->quantity }}</td>
            <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right;">¥{{ number_format($item->price * $item->quantity) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p style="text-align: right; font-size: 16px; font-weight: bold; margin-top: 15px;">
    合計金額：¥{{ number_format($totalPrice) }}（税込）
</p>
<hr>

<h3>■ お届け先情報</h3>
<p>
    【ご住所】 {{ $address }}<br>
    【お名前】 {{ $userName }} 様
</p>
<hr>

<p>商品の発送まで今しばらくお待ちください。</p>