<?php

namespace App\Livewire\Location;

use App\Models\Location;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $locationId;
    public $name, $zone, $aisle, $rack, $bin;

    protected $rules = [
        'name' => 'required|string|max:255',
        'zone' => 'nullable|string',
        'aisle' => 'nullable|string',
        'rack' => 'nullable|string',
        'bin' => 'nullable|string',
    ];

    // --- PESAN ERROR BARU ---
    protected $messages = [
        'name.required' => 'The location name field is required.',
        'name.unique' => 'The location name has already been taken.',
    ];
    // --- AKHIR PERUBAHAN ---
    
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $locations = Location::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.location.index', [
            'locations' => $locations,
        ])->layout('layouts.app');
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

    public function closeModal()
    {
        $this->resetInputFields();
        $this->dispatch('close-modal', 'location-form');
    }

    public function store()
    {
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
            'message' => $this->locationId ? 'Location successfully updated.' : 'Location successfully created.'
        ]);

        $this->closeModal();
        $this->resetInputFields();
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

        $this->dispatch('open-modal', 'location-form');
    }

    public function confirmDelete($id)
    {
        $this->dispatch('show-delete-confirmation', $id);
    }
    
    #[On('delete-confirmed')]
    public function delete($id)
    {
        Location::find($id)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Location successfully deleted.']);
    }
}