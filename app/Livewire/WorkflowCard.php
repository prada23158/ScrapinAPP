<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class WorkflowCard extends Component
{
    public $workflow;
    public bool $done= false;
    public bool $error= false;
    public bool $showModal = false;

    public function mount($workflow)
    {
        $this->workflow = $workflow;
    }
    public function openModal()
    {
        $this ->showModal = true;
    }
    public function closeModal()
    {
        $this ->showModal = false;
        $this -> done = false;
        $this -> error = false;
    }

    public function activate()
    {
        try {
            // Lancer l'URL du workflow
            Http::post($this->workflow['url']);
            
            $this->done = true;
            $this->error = false;
        } catch (\Exception $e) {
            $this->done = false;
            $this->error = true;
        }
    }

}
