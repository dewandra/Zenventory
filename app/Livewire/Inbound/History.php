<?php

namespace App\Livewire\Inbound;

use App\Models\InventoryBatch;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class History extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $batches = InventoryBatch::with(['product', 'location']) // Eager loading untuk performa
            ->where(function ($query) {
                $query->where('lpn', 'like', '%' . $this->search . '%')
                    ->orWhereHas('product', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%')
                                 ->orWhere('sku', 'like', '%' . $this->search . '%');
                    });
            })
            ->latest() // Tampilkan yang terbaru di atas
            ->paginate(15);

        return view('livewire.inbound.history', [
            'batches' => $batches,
        ])->layout('layouts.app');
    }
}