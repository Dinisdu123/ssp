<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;

class ProductReviews extends Component
{
    public $productId;

    protected $listeners = ['reviewSubmitted' => '$refresh'];

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function render()
    {
        $reviews = Review::with('user')
            ->where('product_id', $this->productId)
            ->orderBy('review_date', 'desc')
            ->get();

        return view('livewire.product-reviews', compact('reviews'));
    }
}