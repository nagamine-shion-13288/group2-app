<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCompleteMail extends Mailable
{
    use Queueable, SerializesModels;

    // 💡 渡す変数を4つに増やします
    public $userName;
    public $totalPrice;
    public $cartItems;
    public $address;

    // 💡 コンストラクタでも4つ受け取るように修正
    public function __construct($userName, $totalPrice, $cartItems, $address)
    {
        $this->userName = $userName;
        $this->totalPrice = $totalPrice;
        $this->cartItems = $cartItems;
        $this->address = $address;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【JUNGLIA】ご購入手続き完了のお知らせ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order_complete',
        );
    }
}