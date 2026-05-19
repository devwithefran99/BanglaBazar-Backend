<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public string $mailType;

    public function __construct(Order $order, string $mailType = 'placed')
    {
        $this->order    = $order;
        $this->mailType = $mailType;
    }

    public function envelope(): Envelope
    {
        $subjects = [
            'placed'    => '✅ Order #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT) . ' Confirmed!',
            'confirmed' => '🎉 Your Order is Confirmed — #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT),
            'shipped'   => '🚚 Your Order Has Been Shipped — #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT),
            'delivered' => '📦 Order Delivered Successfully — #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT),
            'cancelled' => '❌ Order Cancelled — #' . str_pad($this->order->id, 4, '0', STR_PAD_LEFT),
        ];

        return new Envelope(
            subject: $subjects[$this->mailType] ?? 'Order Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order',
            with: [
                'order'    => $this->order,
                'mailType' => $this->mailType,
            ],
        );
    }
}