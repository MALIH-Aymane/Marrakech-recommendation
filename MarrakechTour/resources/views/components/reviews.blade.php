<div>
    {{-- ── Header ───────────────────────────────────── --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="fw-bold mb-0" style="color:#8B4513;">
            <i class="bi bi-chat-dots-fill text-warning me-2"></i>
            Reviews ({{ $attraction->reviews_count ?? 0 }})
        </h5>

        @auth
            {{-- "Rate this place" trigger — just the stars, no form --}}
            <div class="d-flex align-items-center gap-1" id="rateStarsTrigger" style="cursor:pointer;" title="Rate this place">
                @for($s = 1; $s <= 5; $s++)
                    <span class="trigger-star" data-value="{{ $s }}"
                          style="font-size:1.6rem;color:#d1c3b8;transition:color .15s;line-height:1;">★</span>
                @endfor
                <span class="text-muted ms-1" style="font-size:.8rem;">Rate</span>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                <i class="bi bi-pencil me-1"></i>Write a review
            </a>
        @endauth
    </div>

    {{-- ── Review Modal (Google-Maps style) ────────── --}}
    @auth
    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
            <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">

                {{-- Modal Header --}}
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <p class="text-muted mb-0" style="font-size:.8rem;">{{ $attraction->attraction }}</p>
                        <h6 class="fw-bold mb-0" id="reviewModalLabel">How was your experience?</h6>
                    </div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
                </div>

                {{-- Star Rating inside Modal --}}
                <div class="px-4 py-3 text-center border-bottom">
                    <div id="modalStarDisplay" class="d-flex justify-content-center gap-2 mb-1">
                        @for($s = 1; $s <= 5; $s++)
                            <span class="modal-star" data-value="{{ $s }}"
                                  style="font-size:2.8rem;color:#d1c3b8;cursor:pointer;line-height:1;transition:color .15s,transform .15s;">★</span>
                        @endfor
                    </div>
                    <p id="ratingLabel" class="text-muted mb-0" style="font-size:.8rem;height:1rem;"></p>
                </div>

                {{-- Form --}}
                <form action="{{ route('reviews.store', $attraction) }}" method="POST" id="reviewForm">
                    @csrf
                    <input type="hidden" name="rating" id="modalRatingInput" value="">

                    <div class="modal-body px-4 pt-3 pb-2">
                        <textarea name="comment" id="reviewComment"
                                  class="form-control border-0 bg-light rounded-3"
                                  rows="4" required
                                  placeholder="Share details of your experience…"
                                  style="font-size:.9rem;resize:none;"></textarea>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 pt-2 d-flex justify-content-between">
                        <button type="button" class="btn btn-link text-muted text-decoration-none px-0"
                                data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient rounded-pill px-4 fw-semibold"
                                id="submitReviewBtn" style="font-size:.9rem;" disabled>
                            <i class="bi bi-send-fill me-1"></i> Post
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- JS moved to @push('scripts') below --}}
    @endauth

    {{-- ── Reviews List ──────────────────────────── --}}
    <div class="reviews-list mt-3">
        @forelse($attraction->userReviews as $review)
            <div class="review-card p-3 mb-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                    {{-- Avatar initial --}}
                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                         style="width:38px;height:38px;background:#C96A2B;font-size:.9rem;">
                        {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-semibold" style="font-size:.9rem;line-height:1.2;">
                            {{ $review->user->name ?? 'User' }}
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="color:#f5a623;font-size:.85rem;letter-spacing:1px;">
                                @for($i=1;$i<=5;$i++){{ $i<=$review->rating ? '★' : '☆' }}@endfor
                            </span>
                            <span class="text-muted" style="font-size:.75rem;">· {{ $review->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <p class="text-muted mb-2" style="font-size:.88rem;line-height:1.6;">{{ $review->comment }}</p>

                <div class="d-flex align-items-center gap-3" style="font-size:.8rem;">
                    {{-- Like --}}
                    @auth
                        <form action="{{ route('reviews.react', $review) }}" method="POST" class="d-inline m-0">
                            @csrf
                            @php $hasLiked = $review->reactions->where('user_id', Auth::id())->count() > 0; @endphp
                            <button type="submit"
                                    class="btn btn-sm btn-link text-decoration-none p-0 {{ $hasLiked ? 'text-primary' : 'text-muted' }}"
                                    style="font-size:.8rem;">
                                <i class="bi bi-hand-thumbs-up{{ $hasLiked ? '-fill' : '' }} me-1"></i>{{ $review->reactions->count() }}
                            </button>
                        </form>
                    @else
                        <span class="text-muted"><i class="bi bi-hand-thumbs-up me-1"></i>{{ $review->reactions->count() }}</span>
                    @endauth

                    {{-- Reply toggle --}}
                    @auth
                        <button class="btn btn-sm btn-link text-decoration-none p-0 text-muted"
                                style="font-size:.8rem;"
                                type="button" data-bs-toggle="collapse"
                                data-bs-target="#replyForm{{ $review->id }}">
                            <i class="bi bi-reply me-1"></i>Reply
                        </button>
                    @endauth
                </div>

                {{-- Reply Form --}}
                @auth
                    <div class="collapse mt-2" id="replyForm{{ $review->id }}">
                        <form action="{{ route('reviews.reply', $review) }}" method="POST">
                            @csrf
                            <div class="input-group input-group-sm">
                                <input type="text" name="comment"
                                       class="form-control rounded-start-pill border-0 bg-light"
                                       placeholder="Write a reply…" required>
                                <button class="btn btn-sm btn-gradient rounded-end-pill px-3" type="submit">Reply</button>
                            </div>
                        </form>
                    </div>
                @endauth

                {{-- Replies --}}
                @if($review->replies->count() > 0)
                    <div class="mt-3 ps-3 border-start border-2" style="border-color:#f0e8e0!important;">
                        @foreach($review->replies as $reply)
                            <div class="mb-2">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0"
                                         style="width:26px;height:26px;background:#A0522D;font-size:.7rem;">
                                        {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <strong style="font-size:.8rem;">{{ $reply->user->name ?? 'User' }}</strong>
                                    <span class="text-muted" style="font-size:.72rem;">· {{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="mb-1 text-muted ps-4" style="font-size:.82rem;">{{ $reply->comment }}</p>
                                @auth
                                    <div class="ps-4">
                                        <form action="{{ route('reviews.react', $reply) }}" method="POST" class="d-inline m-0">
                                            @csrf
                                            @php $hasLikedReply = $reply->reactions->where('user_id', Auth::id())->count() > 0; @endphp
                                            <button type="submit"
                                                    class="btn btn-sm btn-link text-decoration-none p-0 {{ $hasLikedReply ? 'text-primary' : 'text-muted' }}"
                                                    style="font-size:.75rem;">
                                                <i class="bi bi-hand-thumbs-up{{ $hasLikedReply ? '-fill' : '' }} me-1"></i>{{ $reply->reactions->count() }}
                                            </button>
                                        </form>
                                    </div>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-5 text-muted">
                <i class="bi bi-chat-left-text" style="font-size:2.5rem;opacity:.3;"></i>
                <p class="mt-3 mb-0" style="font-size:.9rem;">No reviews yet. Be the first to share your experience!</p>
            </div>
        @endforelse
    </div>
</div>

@auth
@push('scripts')
<script>
(function () {
    const labels = ['', 'Terrible', 'Poor', 'Average', 'Good', 'Excellent'];
    let selectedRating = 0;

    const triggerStars = document.querySelectorAll('#rateStarsTrigger .trigger-star');
    const modalEl      = document.getElementById('reviewModal');
    if (!modalEl || !triggerStars.length) return;

    const modal = new bootstrap.Modal(modalEl);

    // Hover & click on the trigger stars (next to "Reviews" title)
    triggerStars.forEach(star => {
        const val = +star.dataset.value;
        star.addEventListener('mouseenter', () => {
            triggerStars.forEach(s => s.style.color = +s.dataset.value <= val ? '#f5a623' : '#d1c3b8');
        });
        star.addEventListener('mouseleave', () => {
            triggerStars.forEach(s => s.style.color = '#d1c3b8');
        });
        star.addEventListener('click', () => {
            setModalRating(val);
            modal.show();
        });
    });

    // Stars inside the modal
    const modalStars  = document.querySelectorAll('#modalStarDisplay .modal-star');
    const ratingInput = document.getElementById('modalRatingInput');
    const ratingLabel = document.getElementById('ratingLabel');
    const submitBtn   = document.getElementById('submitReviewBtn');

    function setModalRating(val) {
        selectedRating    = val;
        ratingInput.value = val;
        ratingLabel.textContent = labels[val] || '';
        renderModalStars(val);
        submitBtn.disabled = val === 0;
    }

    function renderModalStars(highlighted) {
        modalStars.forEach(s => {
            const sv = +s.dataset.value;
            s.style.color     = sv <= highlighted ? '#f5a623' : '#d1c3b8';
            s.style.transform = sv <= highlighted ? 'scale(1.15)' : 'scale(1)';
        });
    }

    modalStars.forEach(star => {
        const val = +star.dataset.value;
        star.addEventListener('mouseenter', () => renderModalStars(val));
        star.addEventListener('mouseleave', () => renderModalStars(selectedRating));
        star.addEventListener('click',      () => setModalRating(val));
    });

    // Reset form when modal closes
    modalEl.addEventListener('hidden.bs.modal', () => {
        selectedRating = 0;
        ratingInput.value = '';
        ratingLabel.textContent = '';
        renderModalStars(0);
        submitBtn.disabled = true;
        document.getElementById('reviewComment').value = '';
    });
})();
</script>
@endpush
@endauth
