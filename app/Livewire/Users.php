<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;
use Flux\Flux;

class Users extends Component
{
    public $users, $userId;

    public function mount()
    {
        $this->users = User::all();
    }
    public function render()
    {
        return view('livewire.users', ['users' => $this->users]);
    }

    // Recharge automatiquement la page avec la liste des utilisateurs
    // après la création d'un nouvel utilisateur
    #[On('reloadUsers')]
    public function reloadUsers()
    {
        $this->users = User::all();
    }

    public function edit($id)
    {
        // dd($id);
        $this->dispatch('editUser', $id);

    }

    public function delete($id)
    {
        $this->userId = $id;
        Flux::modal('delete-user')->show();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }

        $this->dispatch(event:"reloadUsers");

        Flux::modal('delete-user')->close();

    }
}