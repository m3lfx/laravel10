<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;

use App\Models\Order;

class SendOrderStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@larashop.test', 'your name here'),
            subject: 'Send Order Status',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // $total = number_format($this->order->map(function ($item) {
        //             return $item->quantity * $item->sell_price;
        //         })->sum(), 2);
        // dd($total);
        $total = $this->order->map(function ($item) {
            return $item->quantity * $item->sell_price;
        });
        // dd(number_format($order->sum(),2));
        return new Content(
            view: 'email.order_status',
            with : [
                'order' => $this->order,
                
                'orderTotal' => $total->sum(),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // dd(storage_path('/pdf/test.pdf'));
        return [ Attachment::fromPath(public_path('storage/pdf/test.pdf')) ];
        // return [ Attachment::fromStorage(storage_path('pdf/test.pdf')) ];
        // return [];
    }
}
