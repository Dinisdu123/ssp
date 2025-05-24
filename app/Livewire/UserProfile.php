<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class UserProfile extends Component
{
    public $user;
    public $orders;

    public function mount()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to view your profile.');
            return redirect()->route('login');
        }

        $this->user = Auth::user();
        $this->orders = Order::with('items.product')
            ->where('user_id', $this->user->_id)
            ->orderBy('ordered_date', 'desc')
            ->get();
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('success', 'You have been logged out.');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}