@props(['reviewableType', 'reviewableId', 'reviewableName'])

<div class="bg-fitar-surface/50 border border-white/10 rounded-xl p-6" id="write-review">
    <h2 class="text-xl font-heading font-bold text-white mb-4">✍️ {{ __('Write a Review for') }} {{ $reviewableName }}</h2>
    
    @auth
        @if(Auth::user()->role === 'user')
            @if(session('success'))
                <div class="bg-green-500/20 border border-green-500 rounded-lg p-3 mb-4">
                    <p class="text-green-400 text-sm">{{ session('success') }}</p>
                </div>
            @endif
            
            @if($errors->any())
                <div class="bg-red-500/20 border border-red-500 rounded-lg p-3 mb-4">
                    @foreach($errors->all() as $error)
                        <p class="text-red-400 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="reviewable_type" value="{{ $reviewableType }}">
                <input type="hidden" name="reviewable_id" value="{{ $reviewableId }}">
                
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">{{ __('Rating') }}</label>
                    <div class="flex gap-1">
                        <button type="button" onclick="setRating(1)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="1">☆</button>
                        <button type="button" onclick="setRating(2)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="2">☆</button>
                        <button type="button" onclick="setRating(3)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="3">☆</button>
                        <button type="button" onclick="setRating(4)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="4">☆</button>
                        <button type="button" onclick="setRating(5)" class="rating-star text-3xl text-gray-500 hover:text-yellow-400 transition" data-rating="5">☆</button>
                    </div>
                    <input type="hidden" name="rating" id="ratingValue" required>
                    <div id="ratingText" class="text-yellow-400 text-sm mt-1"></div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-300 text-sm font-medium mb-2">{{ __('Your Review') }}</label>
                    <textarea name="review_text" rows="4" required class="w-full px-4 py-2 bg-fitar-card border border-white/10 rounded-lg text-white focus:border-fitar-accent focus:outline-none" placeholder="{{ __('Share your experience with') }} {{ $reviewableName }}..."></textarea>
                </div>
                
                <button type="submit" class="bg-fitar-accent hover:bg-fitar-accent-hover text-white px-6 py-2 rounded-lg transition">
                    {{ __('Submit Review') }}
                </button>
            </form>
        @else
            <p class="text-gray-400">{{ __('Only users can write reviews.') }}</p>
        @endif
    @else
        <p class="text-gray-400">{{ __('Please') }} <a href="{{ route('login') }}" class="text-fitar-accent hover:underline">{{ __('login') }}</a> {{ __('to write a review.') }}</p>
    @endauth
</div>

<script>
    let currentRating = 0;
    const stars = document.querySelectorAll('.rating-star');
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.innerHTML = '★';
                star.classList.remove('text-gray-500');
                star.classList.add('text-yellow-400');
            } else {
                star.innerHTML = '☆';
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-500');
            }
        });
        
        const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        document.getElementById('ratingText').innerHTML = ratingTexts[rating] + ' - ' + rating + ' out of 5';
    }
    
    function setRating(rating) {
        currentRating = rating;
        document.getElementById('ratingValue').value = rating;
        updateStars(rating);
    }
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-rating'));
            updateStars(rating);
        });
        
        star.addEventListener('mouseleave', function() {
            updateStars(currentRating);
        });
    });
</script>