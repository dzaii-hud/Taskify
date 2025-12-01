<?php

namespace App\Livewire\Layout;

use Livewire\Volt\Component;
use App\Livewire\Actions\Logout;

class Navigation extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function render(): mixed
    {
        return view('livewire.layout.navigation');
    }
}
