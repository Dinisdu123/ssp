<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class SubmitReview extends Component
{
    public $productId;
    public $rating = 1;
    public $reviewText = '';

    protected $rules = [
        'rating' => 'required|integer|between:1,5',
        'reviewText' => 'required|string|max:1000',
    ];

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function submit()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to submit a review.');
            return redirect()->route('login');
        }

        $this->validate();

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $this->productId,
            'rating' => $this->rating,
            'review_text' => $this->reviewText,
            'review_date' => now(),
        ]);

        $this->reset(['rating', 'reviewText']);
        session()->flash('success', 'Review submitted successfully.');
        $this->dispatch('reviewSubmitted'); // Updated from emit to dispatch
    }

    public function render()
    {
        return view('livewire.submit-review');
    }
}