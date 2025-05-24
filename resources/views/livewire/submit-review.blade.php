<div>
    @if (session()->has('error'))
        <div class="text-red-600 mb-4">{{ session('error') }}</div>
    @endif
    @if (session()->has('success'))
        <div class="text-green-600 mb-4">{{ session('success') }}</div>
    @endif

    @auth
        <form wire:submit.prevent="submit" class="mt-8">
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                <select wire:model="rating" id="rating" class="border p-2 rounded-md w-full">
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
                @error('rating') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="review_text" class="block text-sm font-medium text-gray-700">Review</label>
                <textarea wire:model="reviewText" id="review_text" rows="4" class="border p-2 rounded-md w-full"></textarea>
                @error('reviewText') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-black text-white py-2 px-6 rounded-md hover:bg-gray-800 button-pulse">
                Submit Review
            </button>
        </form>
    @else
        <p class="text-gray-600 mt-4">Please <a href="{{ url('/login') }}" class="text-blue-500 hover:underline">log in</a> to write a review.</p>
    @endauth
</div>