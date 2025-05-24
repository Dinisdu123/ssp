<div class="space-y-4">
    @forelse ($reviews as $review)
        <div class="border p-4 rounded-md bg-gray-50">
            <h3 class="font-semibold">{{ e($review->user->name) }}</h3>
            <p class="text-gray-600">Rating: {{ str_repeat('⭐', $review->rating) }}</p>
            <p>{{ nl2br(e($review->review_text)) }}</p>
            <span class="text-sm text-gray-500">{{ $review->review_date->format('Y-m-d H:i:s') }}</span>
        </div>
    @empty
        <p class="text-gray-600">No reviews yet. Be the first to review!</p>
    @endforelse
</div>