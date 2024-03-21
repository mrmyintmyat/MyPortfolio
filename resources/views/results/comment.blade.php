 @if (isset($comments))
    @foreach ($comments as $comment)
        <div class="col-12 mb-4 border-bottom" id="scroll_{{ $comment->id }}3">
            <div class="card bg-white border-0">
                <div class="card-body p-0">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-2 col-1">
                            <img src="{{$comment->from_user->logo}}"
                                alt="@user" class="img-fluid rounded-circle shadow-sm border" />
                        </div>
                        <div class="w-100">
                            <div class="col-12 mb-3 message_container">
                                <div class="card bg-white border-1 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h5 class="card-title mb-0">
                                                        {{ $comment->name }}</h5>
                                                    <small
                                                        class="text-muted ms-2">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans(null, true) }}</small>
                                                    @if($comment->from_user && $comment->from_user->user_token == 3)
                                                        <small class="text-danger ms-2">
                                                            Banned User
                                                        </small>
                                                    @endif
                                                </div>
                                                <span class="card-text">
                                                    <div class="comment">
                                                        <span class="short-text">
                                                            {{ substr($comment->text, 0, 100) }}{{ strlen($comment->text) > 100 ? '...' : '' }}
                                                        </span>
                                                        <span class="full-text" style="display: none;">
                                                            {{ $comment->text }}
                                                        </span>
                                                        @if (strlen($comment->text) > 100)
                                                            <a href="#" onclick="seemore(event)"
                                                                class="text-decoration-none fw-medium text-muted">see
                                                                more</a>
                                                        @endif
                                                    </div>

                                                </span>
                                                <div class="d-flex align-items-center mt-2">
                                                    <button
                                                        onclick="ShowReplyForm('{{ $comment->name }}', {{ $comment->post_id }},'{{ encrypt($comment->id) }}', '{{ encrypt($comment->from_user_id) }}', '{{ encrypt($comment->name) }}', '{{ $comment->id }}')"
                                                        data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasCommentReply"
                                                        aria-controls="offcanvasCommentReply"
                                                        class="btn btn-sm border-0 me-2 fw-medium"><i
                                                            class="fas fa-arrow-turn-up flip-horizontal me-2"></i>
                                                        Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="replyCmContainer{{ $comment->id }}">
                                @if ($view_rp)
                                    {!! $view_rp !!}
                                @endif
                                @php
                                    $replies = $comment->replies()->where('id', '!=', $rp_id)->paginate(3);
                                @endphp
                                @foreach ($replies as $reply)
                                    <div class="col-11 me-0 ms-auto mb-3">
                                        <div class="card bg-white border-1 shadow-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-start">
                                                    <div class="avatar me-2 col-1">
                                                        <img src="{{$reply->from_user->logo}}"
                                                            alt="@user" class="img-fluid rounded-circle" />
                                                    </div>
                                                    <div class="w-100">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <h5 class="card-title mb-0">
                                                                {{ $reply->name }}</h5>
                                                            <small
                                                                class="text-muted ms-2">{{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans(null, true) }}</small>
                                                            @if($reply->from_user && $reply->from_user->user_token == 3)
                                                                <small class="text-danger ms-2">
                                                                    Banned User
                                                                </small>
                                                            @endif
                                                        </div>
                                                        <span class="card-text">
                                                            <div class="reply">
                                                                <span class="short-text">
                                                                    {{ substr($reply->text, 0, 100) }}{{ strlen($reply->text) > 100 ? '...' : '' }}
                                                                </span>
                                                                <span class="full-text" style="display: none;">
                                                                    {{ $reply->text }}
                                                                </span>
                                                                @if (strlen($reply->text) > 100)
                                                                    <a href="#" onclick="seemore(event)"
                                                                        class="text-decoration-none fw-medium text-muted">see
                                                                        more</a>
                                                                @endif
                                                            </div>
                                                        </span>
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mt-2">
                                                            <button
                                                                onclick="ShowReplyForm('{{ $reply->name }}',{{ $comment->post_id }},'{{ encrypt($comment->id) }}', '{{ encrypt($reply->from_user_id) }}', '{{ encrypt($reply->name) }}','{{ $comment->id }}')"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#offcanvasCommentReply"
                                                                aria-controls="offcanvasCommentReply"
                                                                class="btn btn-sm border-0 me-2 fw-medium"><i
                                                                    class="fas fa-arrow-turn-up flip-horizontal me-2"></i>
                                                                Reply</button>
                                                            <small class="text-muted ">replyed
                                                                to
                                                                {{ $reply->reply_to }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @if (count($comment->replies) > 3)
                                <div class="mb-3 text-center">
                                    <i class="fas fa-spinner fa-spin" style="display: none;"></i>
                                    <a onclick="MoreReply(event,{{ $comment->id }},{{ $comment->id }})"
                                        data-rp-page="1" class="text-secondary text-decoration-none"
                                        style="cursor: pointer">more
                                        replies>></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    @if (isset($comment))
        <div class="col-12 mb-4 border-bottom" id="scroll_{{ $comment->id }}3">
            <div class="card bg-white border-0">
                <div class="card-body p-0">
                    <div class="d-flex align-items-start">
                        <div class="avatar me-2 col-1">
                            <img src="{{$comment->from_user->logo}}"
                                alt="@user" class="img-fluid rounded-circle shadow-sm border" />
                        </div>
                        <div class="w-100">
                            <div class="col-12 mb-3 message_container">
                                <div class="card bg-white border-1 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <h5 class="card-title mb-0">
                                                        {{ $comment->name }}</h5>
                                                    <small
                                                        class="text-muted ms-2">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans(null, true) }}</small>
                                                    @if($comment->from_user && $comment->from_user->user_token == 3)
                                                        <small class="text-danger ms-2">
                                                            Banned User
                                                        </small>
                                                    @endif
                                                </div>
                                                <span class="card-text">
                                                    <div class="comment">
                                                        <span class="short-text">
                                                            {{ substr($comment->text, 0, 100) }}{{ strlen($comment->text) > 100 ? '...' : '' }}
                                                        </span>
                                                        <span class="full-text" style="display: none;">
                                                            {{ $comment->text }}
                                                        </span>
                                                        @if (strlen($comment->text) > 100)
                                                            <a href="#" onclick="seemore(event)"
                                                                class="text-decoration-none fw-medium text-muted">see
                                                                more</a>
                                                        @endif
                                                    </div>

                                                </span>
                                                <div class="d-flex align-items-center mt-2">
                                                    <button
                                                        onclick="ShowReplyForm('{{ $comment->name }}', {{ $comment->post_id }},'{{ encrypt($comment->id) }}', '{{ encrypt($comment->from_user_id) }}', '{{ encrypt($comment->name) }}', '{{ $comment->id }}')"
                                                        data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasCommentReply"
                                                        aria-controls="offcanvasCommentReply"
                                                        class="btn btn-sm border-0 me-2 fw-medium"><i
                                                            class="fas fa-arrow-turn-up flip-horizontal me-2"></i>
                                                        Reply</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="replyCmContainer{{ $comment->id }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
