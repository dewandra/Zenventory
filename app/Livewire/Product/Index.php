<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination; // <-- PASTIKAN INI ADA LAGI
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination; // <-- PASTIKAN INI ADA LAGI

    #[Url(except: '')]
    public $search = '';
    public $productId;
    public $sku, $name, $description;

    protected $rules = [
        'sku' => 'required|string',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];
    

    // Method ini akan mereset pagination saat ada pencarian baru
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::query()
            ->where(function ($query) {
                if (!empty($this->search)) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                          ->orWhere('sku', 'like', '%' . $this->search . '%');
                }
            })
            ->latest()
            ->paginate(10); // <-- Gunakan paginate() lagi

        return view('livewire.product.index', [
            'products' => $products,
        ])->layout('layouts.app');
    }

    private function resetInputFields()
    {
        $this->productId = null;
        $this->sku = '';
        $this->name = '';
        $this->description = '';
        $this->resetErrorBag();
    }
    
    public function closeModal()
    {
        $this->resetInputFields(); 
        $this->dispatch('close-modal', 'product-form');
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
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $id;
        $this->sku = $product->sku;
        $this->name = $product->name;
        $this->description = $product->description;

        $this->dispatch('open-modal', 'product-form');
    }
    
    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', $id);
    }
    
    #[On('delete-confirmed')]
    public function delete($id)
    {
        Product::find($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Produk berhasil dihapus.']);
    }
}