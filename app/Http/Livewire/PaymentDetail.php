<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PaymentDetail extends Component
{
    public $payment_detail;
    public function mount($payment_detail)
    {
        $this->payment_detail = $payment_detail;
    }
    
    public function render()
    {
        return view('livewire.payment-detail');
    }
}
