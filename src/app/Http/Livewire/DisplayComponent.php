<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DisplayComponent extends Component
{
    public $selectedValue = '';

    protected $listeners = ['valueUpdated' => 'updateValue'];

    public function mount()
    {
        $this->selectedValue = session('selectedValue', '');
    }

    public function updateValue($value)
    {
        $this->selectedValue = $value;
    }

    public function render()
    {
        return view('livewire.display-component');
    }
}
