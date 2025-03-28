<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SelectComponent extends Component
{
    public $selectedValue = '';

    public function mount()
    {
        $this->selectedValue = session('selectedValue', '');
    }

    public function updatedSelectedValue($value)
    {
        session()->put('selectedValue', $value);

        $this->emit('valueUpdated', $value);
    }


    public function render()
    {
        return view('livewire.select-component');
    }
}
