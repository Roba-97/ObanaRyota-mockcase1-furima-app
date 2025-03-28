<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileImagePreviewComponent extends Component
{
    use WithFileUploads;

    public $image;

    public function render()
    {
        return view('livewire.profile-image-preview-component');
    }
}
