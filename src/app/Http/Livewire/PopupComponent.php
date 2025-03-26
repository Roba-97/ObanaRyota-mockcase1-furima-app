<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PopupComponent extends Component
{
    public $showPopup = false;
    public $item;

    public function render()
    {
        return view('livewire.popup-component');
    }

    public function openPopup()
    {
        $this->showPopup = true;
    }

    public function closePopup()
    {
        $this->showPopup = false;
    }
}
