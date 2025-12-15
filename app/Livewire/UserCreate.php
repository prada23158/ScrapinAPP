<?php

namespace App\Livewire;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;

use Livewire\Component;

class UserCreate extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function createUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        // dd($this->name, $this->email, $this->password, $this->password_confirmation);

        // Create the user
        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Reset the form
        $this->resetForm();

        // Close the modal
        Flux::modal('create-user')->close();
        // Flash pour le toast après reload
        // $this->dispatch(
        //     'show-toast',
        //     variant: 'success',
        //     text: 'Utilisateur créé avec succès.',
        //     duration: 5000
        // );
        // Notify the Users component to reload the user list
        $this->dispatch(event:"reloadUsers");

        
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function render()
    {
        return view('livewire.user-create');
    }

    public function mount()
    {
        $this->resetForm();
    }
}
