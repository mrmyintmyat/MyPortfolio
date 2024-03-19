<div class="col-11 me-0 ms-auto mb-3">
    <div class="card bg-white border-1 shadow-sm">
        <div class="card-body">
            <div class="d-flex align-items-start">
                <div class="avatar me-2 col-1">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_640.png"
                        alt="@user" class="img-fluid rounded-circle" />
                </div>
                <div class="w-100">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="card-title mb-0">
                            {{ $reply->name }}</h5>
                        <small class="text-muted ms-2">{{ $reply->created_at->diffForHumans() }}</small>
                        @if (!optional($reply->from_user())->exists())
                            <small class="ms-2 text-danger">
                                Deleted User
                            </small>
                        @elseif($reply->from_user->user_token == 3)
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
                    <div class="d-flex align-items-center justify-content-between mt-2">
                        <button
                            onclick="ShowReplyForm('{{ $reply->name }}',{{ $reply->post_id }},'{{ encrypt($reply->comment_id) }}', '{{ encrypt($reply->from_user_id) }}', '{{ encrypt($reply->name) }}','{{ $reply->comment_id }}')"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasCommentReply"
                            aria-controls="offcanvasCommentReply" class="btn btn-sm border-0 me-2 fw-medium"><i
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
