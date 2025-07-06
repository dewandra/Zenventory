<?php

namespace App\Livewire\History;

use Livewire\Component;
use App\Models\Order;

class OrderHistory extends Component
{
    public $searchTerm = '';
    public ?Order $foundOrder = null;
    public $picklists = [];

    public function search()
    {
        $this->validate(['searchTerm' => 'required|string']);
        $this->reset(['foundOrder', 'picklists']);

        $term = trim($this->searchTerm);

        // Cari pesanan berdasarkan nomornya, tanpa filter status
        $order = Order::with(['details.product', 'picklists.items'])
                      ->whereRaw('LOWER(order_number) = ?', [strtolower($term)])
                      ->first();

        if ($order) {
            $this->foundOrder = $order;
            $this->picklists = $order->picklists; // Ambil picklist dari relasi
        } else {
            $this->addError('searchTerm', 'Sales Order dengan nomor ini tidak ditemukan.');
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