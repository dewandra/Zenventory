<?php

namespace App\Livewire\Order;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class Index extends Component
{
    use WithPagination;

    // Properti untuk Form
    public $orderId, $order_number, $customer_name, $status, $notes;
    public $details = [];
    public $searchProduct = '';
    public $products = [];

    protected $rules = [
        'order_number' => 'required|string|unique:orders,order_number',
        'customer_name' => 'required|string|max:255',
        'status' => 'required|string',
        'notes' => 'nullable|string',
        'details' => 'required|array|min:1',
        'details.*.product_id' => 'required|exists:products,id',
        'details.*.quantity_requested' => 'required|integer|min:1',
    ];

    protected $messages = [
        'details.required' => 'Pesanan harus memiliki setidaknya satu produk.',
        'details.*.product_id.required' => 'Silakan pilih produk.',
        'details.*.quantity_requested.required' => 'Jumlah harus diisi.',
        'details.*.quantity_requested.min' => 'Jumlah minimal 1.',
    ];

    public function mount()
    {
        $this->addDetail(); // Mulai dengan satu baris detail produk
    }

    public function render()
    {
        $orders = Order::with('details.product')->latest()->paginate(10);
        return view('livewire.order.index', [
            'orders' => $orders
        ])->layout('layouts.app');
    }

    // Fungsi untuk Form
    public function addDetail()
    {
        $this->details[] = ['product_id' => '', 'quantity_requested' => 1, 'product_name' => ''];
    }

    public function removeDetail($index)
    {
        unset($this->details[$index]);
        $this->details = array_values($this->details); // Re-index array
    }

    public function updated($name, $value)
    {
        // Jika mengubah kolom pencarian produk di dalam detail
        if (preg_match('/details\.(\d+)\.product_name/', $name, $matches)) {
            $index = $matches[1];
            if (strlen($value) > 2) {
                $this->products = Product::where('name', 'like', '%' . $value . '%')
                    ->orWhere('sku', 'like', '%' . $value . '%')
                    ->limit(5)
                    ->get();
            } else {
                $this->products = [];
            }
        }
    }

    public function selectProduct($index, $productId, $productName)
    {
        $this->details[$index]['product_id'] = $productId;
        $this->details[$index]['product_name'] = $productName;
        $this->products = []; // Sembunyikan dropdown setelah memilih
    }

    public function create()
    {
        $this->resetForm();
        $this->addDetail();
        $this->dispatch('open-modal', 'order-form');
    }

    public function store()
    {
        // Update rule untuk 'edit'
        $this->rules['order_number'] = 'required|string|unique:orders,order_number,' . $this->orderId;
        $this->validate();

        $order = Order::updateOrCreate(['id' => $this->orderId], [
            'order_number' => $this->order_number,
            'customer_name' => $this->customer_name,
            'status' => $this->status,
            'notes' => $this->notes,
            'user_id' => auth()->id(),
        ]);

        // Hapus detail lama sebelum menyimpan yang baru (untuk mode edit)
        $order->details()->delete();

        foreach ($this->details as $detail) {
            $order->details()->create([
                'product_id' => $detail['product_id'],
                'quantity_requested' => $detail['quantity_requested'],
            ]);
        }

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => $this->orderId ? 'Pesanan berhasil diperbarui.' : 'Pesanan berhasil dibuat.'
        ]);

        $this->dispatch('close-modal', 'order-form');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['orderId', 'order_number', 'customer_name', 'status', 'notes', 'details']);
    }
}