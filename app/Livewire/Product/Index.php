<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    #[Url(except: '')]
    public $search = '';
    public $productId;
    public $sku, $name, $description;

    protected $rules = [
        'sku' => 'required|string',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

        public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        // Query ini sudah benar dan robust
        $products = Product::query()
            ->where(function ($query) {
                // Pastikan $this->search tidak kosong sebelum menjalankan query
                if (!empty($this->search)) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('sku', 'like', '%' . $this->search . '%');
                }
            })
            ->latest()
            ->paginate(10);

        return view('livewire.product.index', [
            'products' => $products,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        // Kirim event untuk membuka modal
        $this->dispatch('open-modal', 'product-form');
    }

    public function closeModal()
    {
        // Kirim event untuk menutup modal
        $this->dispatch('close-modal', 'product-form');
    }
    private function resetInputFields()
    {
        $this->productId = null;
        $this->sku = '';
        $this->name = '';
        $this->description = '';
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate(array_merge($this->rules, [
            'sku' => 'required|unique:products,sku,' . $this->productId
        ]));

        Product::updateOrCreate(['id' => $this->productId], [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => $this->productId ? 'Produk berhasil diperbarui.' : 'Produk berhasil dibuat.'
        ]);

        $this->closeModal();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->sku = $product->sku;
        $this->name = $product->name;
        $this->description = $product->description;

        // Kirim event untuk membuka modal
        $this->dispatch('open-modal', 'product-form');
    }

    public function confirmDelete($id)
    {
        // Kirim event dengan ID sebagai parameter tunggal, bukan array
        $this->dispatch('show-delete-confirmation', $id);
    }
    
    #[On('delete-confirmed')]
    public function delete($id)
    {
        Product::find($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Produk berhasil dihapus.']);
    }
}
