<?php

namespace App\Livewire;

use Livewire\Component;

class Agents extends Component
{
    public string $webhookUrl;
    public array $payload = [];

    public bool $done = false;
    public bool $error = false;

    public function mount(string $webhookUrl = '')
    {
        $this->webhookUrl = $webhookUrl;
    }

    public function activateAgents()
    {
        try {
            // Simulate agent activation and payload preparation
            $this->payload = [
                'status' => 'Agents activated successfully',
                'timestamp' => now()->toDateTimeString(),
            ];

            // Send payload to the webhook URL if provided
            if (!empty($this->webhookUrl)) {
                // Here you would typically use an HTTP client to send the payload
                // For example, using Guzzle or Laravel's HTTP client
                // Http::post($this->webhookUrl, $this->payload);
            }

            $this->done = true;
        } catch (\Exception $e) {
            $this->error = true;
        }
    }

    public function render()
    {
        return view('livewire.agents');
    }
}
