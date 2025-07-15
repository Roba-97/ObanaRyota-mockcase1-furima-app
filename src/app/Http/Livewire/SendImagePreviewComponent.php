<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class SendImagePreviewComponent extends Component
{
    use WithFileUploads;

    public $image;

    public function render()
    {
        return view('livewire.send-image-preview-component');
    }
}
