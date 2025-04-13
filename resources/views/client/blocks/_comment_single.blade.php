{{-- Single Comment Display --}}
{{-- Calculate margin based on nesting level --}}
@php $marginLeft = $level * 40; @endphp

<div class="d-flex mb-4"
    style="margin-left: {{ $marginLeft }}px; border-left: {{ $level > 0 ? '2px solid #eee' : 'none' }}; padding-left: {{ $level > 0 ? '15px' : '0' }};">
    {{-- User Avatar --}}
    <div class="flex-shrink-0 me-3">
        <img src="{{ $comment->user->avatar ? Storage::url($comment->user->avatar) : asset('site/images/person_1.jpg') }}"
            alt="{{ $comment->user->name }}" class="rounded-circle" width="50" height="50"
            onerror="this.onerror=null;this.src='{{ asset('site/images/person_1.jpg') }}';">
    </div>
    {{-- Comment Content --}}
    <div class="flex-grow-1">
        <h5 class="mt-0 mb-1">{{ $comment->user->name }} <small class="text-muted">-
                {{ $comment->created_at->diffForHumans() }}</small></h5>
        <p style="white-space: pre-wrap;">{{ $comment->content }}</p>

        {{-- Like/Unlike Button and Count --}}
        <div class="d-flex align-items-center mb-2">
            @auth
                <form action="{{ route('comments.like', $comment->id) }}" method="POST" class="me-2">
                    @csrf
                    {{-- Check if comment ID exists in the pre-fetched liked IDs array --}}
                    @php $isLiked = isset($likedCommentIds) && in_array($comment->id, $likedCommentIds); @endphp
                    <button type="submit"
                        class="btn btn-sm p-0 border-0 {{ $isLiked ? 'text-primary' : 'text-secondary' }}">
                        <i class="fa fa-thumbs-up"></i> {{ $isLiked ? 'Bỏ thích' : 'Thích' }}
                    </button>
                </form>
            @else
                {{-- Show disabled like button for guests --}}
                <button type="button" class="btn btn-sm p-0 border-0 text-secondary me-2" disabled>
                    <i class="fa fa-thumbs-up"></i> Thích
                </button>
            @endauth
            {{-- Like Count --}}
            {{-- Use withCount in controller for efficiency if displaying counts for many comments --}}
            <span class="text-muted small">{{ $comment->likers()->count() }} lượt thích</span>

            {{-- Reply Button (Show if user is logged in and level < max depth, e.g., 2) --}} @auth @if($level < 2) {{--
                Limit reply depth --}}
                <button class="btn btn-sm btn-outline-secondary reply-btn ms-3" data-comment-id="{{ $comment->id }}">Trả
                    lời</button>
            @endif
            @endauth
        </div>

        {{-- Reply Form (Hidden by default) --}}
        @auth
            @if($level < 2)
                <form action="{{ route('comments.store') }}" method="POST" class="reply-form mb-3" style="display: none;">
                    @csrf
                    <input type="hidden" name="news_id" value="{{ $comment->news_id }}">
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <div class="mb-2">
                        <textarea name="content"
                            class="form-control form-control-sm @if($errors->has('content') && old('parent_id') == $comment->id) is-invalid @endif"
                            rows="2" placeholder="Viết trả lời..." required></textarea>
                        @if($errors->has('content') && old('parent_id') == $comment->id)
                            <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">Gửi</button>
                    <button type="button" class="btn btn-sm btn-secondary cancel-reply-btn">Hủy</button>
                </form>
            @endif
        @endauth

        {{-- Recursively include replies --}}
        @if ($comment->replies->count() > 0)
            <div class="mt-4">
                @foreach ($comment->replies as $reply)
                    @include('client.blocks._comment_single', ['comment' => $reply, 'level' => $level + 1])
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- Add script only once per page load --}}
@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Show reply form
                document.querySelectorAll('.reply-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        // Hide all other open reply forms first
                        document.querySelectorAll('.reply-form').forEach(form => form.style.display = 'none');
                        // Show the target reply form (which is the next sibling form)
                        let replyForm = this.closest('.flex-grow-1').querySelector('.reply-form');
                        if (replyForm) {
                            replyForm.style.display = 'block';
                            replyForm.querySelector('textarea').focus();
                        }
                    });
                });

                // Hide reply form on cancel
                document.querySelectorAll('.cancel-reply-btn').forEach(button => {
                    button.addEventListener('click', function () {
                        this.closest('.reply-form').style.display = 'none';
                    });
                });
            });
        </script>
    @endpush
@endonce