<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectComponent extends Component
{
    public $selectedValue = '';

    public function updated($propertyName)
    {
        if ($propertyName === 'selectedValue') {
            $this->emit('valueUpdated', $this->selectedValue);
        }
    }
    
    public function render()
    {
        return view('livewire.select-component');
    }
}
