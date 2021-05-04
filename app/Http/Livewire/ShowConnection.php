<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShowConnection extends Component
{
    public $teste = 0;

    public function soma(){
        $this->teste += 1;
    }

    public function render()
    {
        return view('livewire.show-connection');
    }
}
