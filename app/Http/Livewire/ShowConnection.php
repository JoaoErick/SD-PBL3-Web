<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Connection;

class ShowConnection extends Component
{
    public $teste;

    public function mount()
    {
        $this->teste = Connection::get()->first();
    }

    public function soma(){
        $this->teste += 1;
    }

    public function render()
    {
        return view('livewire.show-connection');
    }
}
