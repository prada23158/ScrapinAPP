<?php

namespace App\Livewire;
use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserEdit extends Component
{
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function render()
    {
        return view('livewire.user-edit');
    }

    // $this->user = User::where('id', $id)->get();


    #[On('editUser')]
    public function editUser($id)
    {
        $user = User::find($id);
        
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        
        Flux::modal('edit-user' , $id)->show();
        // dd("edit user id");
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'password' => 'required|nullable|string|min:8|confirmed',
        ]);

        $user = User::find($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Fermer le modal après la mise à jour
        Flux::modal('edit-user')->close();

        // Émettre un événement pour recharger la liste des utilisateurs
        // $this->emit('reloadUsers');
        $this->dispatch(event:"reloadUsers");
    }
}
