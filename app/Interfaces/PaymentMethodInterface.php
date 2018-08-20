<?php 

namespace App\Interfaces;

interface PaymentMethodInterface
{
    public function sendPayment();
}