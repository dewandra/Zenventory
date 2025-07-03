<?php

namespace App\Livewire\Location;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Properti untuk mengontrol modal
    public $isOpen = false;

    // Properti lain
    public $search = '';
    public $locationId;
    public $name, $zone, $aisle, $rack, $bin;

    // Aturan validasi
    protected $rules = [
        'name' => 'required|string|max:255',
        'zone' => 'nullable|string',
        'aisle' => 'nullable|string',
        'rack' => 'nullable|string',
        'bin' => 'nullable|string',
    ];

    public function render()
    {
        $locations = Location::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.location.index', [
            'locations' => $locations,
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
        $this->locationId = null;
        $this->name = '';
        $this->zone = '';
        $this->aisle = '';
        $this->rack = '';
        $this->bin = '';
        $this->resetErrorBag();
    }

    public function store()
    {
        // Menambahkan validasi unik secara manual
        $this->validate(array_merge($this->rules, [
            'name' => 'required|string|max:255|unique:locations,name,' . $this->locationId
        ]));

        Location::updateOrCreate(['id' => $this->locationId], [
            'name' => $this->name,
            'zone' => $this->zone,
            'aisle' => $this->aisle,
            'rack' => $this->rack,
            'bin' => $this->bin,
        ]);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => $this->locationId ? 'Lokasi berhasil diperbarui.' : 'Lokasi berhasil dibuat.'
        ]);

        $this->closeModal();
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        $this->locationId = $id;
        $this->name = $location->name;
        $this->zone = $location->zone;
        $this->aisle = $location->aisle;
        $this->rack = $location->rack;
        $this->bin = $location->bin;
        $this->openModal();
    }

    public function delete($id)
    {
        Location::find($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Lokasi berhasil dihapus.']);
    }
}