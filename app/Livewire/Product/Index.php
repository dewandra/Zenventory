<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $search = '';
    public $productId;
    public $sku, $name, $description;

    protected $rules = [
        'sku' => 'required|string',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function render()
    {
        $products = Product::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('sku', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.product.index', [
            'products' => $products,
        ])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
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
        // Menambahkan validasi unik secara manual di sini
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
        $this->openModal();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Produk berhasil dihapus.']);
    }
}