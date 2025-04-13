{{-- Comment Section --}}
<div class="container-fluid fh5co_fh5co_bg_contcat pt-5 pb-5">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-12">
                <h3 class="mb-4">Bình luận ({{ $newsItem->comments->count() }})</h3> {{-- Display comment count --}}

                {{-- Comment Form (Only show if user is logged in) --}}
                @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-5">
                        @csrf
                        <input type="hidden" name="news_id" value="{{ $newsItem->id }}">
                        <div class="mb-3">
                            <textarea name="content" class="form-control @if($errors->has('content')) is-invalid @endif"
                                rows="4" placeholder="Viết bình luận của bạn..." required></textarea>
                            @if($errors->has('content'))
                                <div class="invalid-feedback">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                @else
                    <p class="mb-5"><a href="{{ route('login') }}">Đăng nhập</a> để bình luận.</p>
                @endauth

                {{-- Display Comments --}}
                @if ($newsItem->comments->count() > 0)
                    @foreach ($newsItem->comments as $comment)
                        {{-- Include a partial to display each comment and its replies recursively --}}
                        @include('client.blocks._comment_single', ['comment' => $comment, 'level' => 0])
                    @endforeach
                @else
                    <p>Chưa có bình luận nào.</p>
                @endif

            </div>
        </div>
    </div>
</div>