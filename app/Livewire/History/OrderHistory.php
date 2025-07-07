<?php

namespace App\Livewire\History;

use Livewire\Component;
use App\Models\Order;

class OrderHistory extends Component
{
    public $searchTerm = '';
    public ?Order $foundOrder = null;
    public $picklists = [];

    // --- PESAN ERROR BARU ---
    protected $messages = [
        'searchTerm.required' => 'The Sales Order number field cannot be empty.',
    ];
    // --- AKHIR PERUBAHAN ---

    public function search()
    {
        $this->validate(['searchTerm' => 'required|string']);
        $this->reset(['foundOrder', 'picklists']);

        $term = trim($this->searchTerm);

        $order = Order::with(['details.product', 'picklists.items'])
                      ->whereRaw('LOWER(order_number) = ?', [strtolower($term)])
                      ->first();

        if ($order) {
            $this->foundOrder = $order;
            $this->picklists = $order->picklists;
        } else {
            $this->addError('searchTerm', 'Sales Order with this number was not found.');
        }
    }

    public function resetSearch()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.history.order-history')->layout('layouts.app');
    }
}