<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProductBidWinnerNotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $bid_amount;
    public $product_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$bid_amount,$product_name)
    {
        $this->name = $name;
        $this->bid_amount = $bid_amount;
        $this->product_name = $product_name;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Congratulations! You have won a bid',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.product-bid-winner-notify-template',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
