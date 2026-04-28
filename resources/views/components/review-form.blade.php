@props(['reviewableType', 'reviewableId', 'reviewableName'])

<div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6 mb-6" id="write-review">
    <h3 class="text-lg font-heading font-bold text-white mb-4">✍️ Write a Review for {{ $reviewableName }}</h3>

    @auth
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf
            <input type="hidden" name="reviewable_type" value="{{ $reviewableType }}">
            <input type="hidden" name="reviewable_id" value="{{ $reviewableId }}">

            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Your Rating</label>
                <div class="flex gap-1" id="star-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" onclick="setRating({{ $i }})" class="star-btn text-3xl text-gray-600 hover:text-yellow-500 transition" data-rating="{{ $i }}">★</button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="0" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-gray-400 mb-2">Your Review</label>
                <textarea name="review_text_en" rows="4" required minlength="10" maxlength="1000"
                    class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-fitar-accent"
                    placeholder="Share your experience... (minimum 10 characters)"></textarea>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-fitar-accent hover:bg-fitar-accent-hover text-white rounded-lg font-medium transition">
                Submit Review
            </button>
        </form>
    @else
        <p class="text-gray-400">Please <a href="/login" class="text-fitar-accent hover:underline">login</a> to write a review.</p>
    @endauth
</div>

@if(session('success'))
<div class="bg-green-500/20 border border-green-500/30 rounded-xl p-4 mb-6">
    <p class="text-green-400">{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div class="bg-red-500/20 border border-red-500/30 rounded-xl p-4 mb-6">
    <p class="text-red-400">{{ session('error') }}</p>
</div>
@endif

<script>
    function setRating(rating) {
        document.getElementById('rating-input').value = rating;
        document.querySelectorAll('.star-btn').forEach((btn, index) => {
            btn.classList.toggle('text-yellow-500', index < rating);
            btn.classList.toggle('text-gray-600', index >= rating);
        });
    }
</script>