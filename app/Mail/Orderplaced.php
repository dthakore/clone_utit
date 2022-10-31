<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Orderplaced extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $orderLineItems, $orderPayment,$orderTotal,$net_total)
    {
        $this->order = $order;
        $this->orderLineItems = $orderLineItems;
        $this->orderPayment = $orderPayment;
        $this->orderTotal = $orderTotal;
        $this->net_total = $net_total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Order Confirmation')->markdown('frontend.orders.mail', ['order' => $this->order,'orderLineItems' => $this->orderLineItems,'orderPayment' => $this->orderPayment,'orderTotal' => $this->orderTotal,'net_total' => $this->net_total]);
    }

}
