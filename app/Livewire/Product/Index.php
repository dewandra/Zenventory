<?php

namespace App\Livewire\Product;

use App\Helpers\LogActivity;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;

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

    // --- PERUBAHAN DI SINI ---
    // Menambahkan pesan error kustom dalam Bahasa Inggris
    protected $messages = [
        'sku.required' => 'The SKU field cannot be empty.',
        'sku.unique' => 'This SKU has already been taken.',
        'name.required' => 'The Product Name field cannot be empty.',
    ];
    // --- AKHIR PERUBAHAN ---


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

        $product = Product::updateOrCreate(['id' => $this->productId], [
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        // --- LOGGING ---
        $action = $this->productId ? 'updated_product' : 'created_product';
        $description = "User " . auth()->user()->name . " {$action} with name '{$product->name}'";
        LogActivity::add($action, $description);
        // --- END LOGGING ---        

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => $this->productId ? 'Product successfully updated.' : 'Product successfully created.'
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
        $product = Product::find($id);
        if ($product) {
            // --- LOGGING ---
            $description = "User " . auth()->user()->name . " deleted product '{$product->name}' (SKU: {$product->sku})";
            LogActivity::add('deleted_product', $description);
            // --- END LOGGING ---

            $product->delete();
            $this->dispatch('alert', ['type' => 'success', 'message' => 'Product successfully deleted.']);
        }
    }
}