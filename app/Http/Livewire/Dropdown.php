<?php
namespace App\Http\Livewire;

use Livewire\Component;

class Dropdown extends Component
{
    public $items; // Holds categories or tags
    public $selectedItems = []; // Holds selected categories or tags
    public $name; // Name of the dropdown (e.g., categories[] or tags[])

    public function mount($items, $selectedItems = [], $name)
    {
        $this->items = $items;
        $this->selectedItems = $selectedItems;
        $this->name = $name;

        // Debugging
        \Log::info('Dropdown component mounted', [
            'items' => $items,
            'selectedItems' => $selectedItems,
            'name' => $name,
        ]);
    }

    public function render()
    {
        return view('livewire.dropdown');
    }
}
