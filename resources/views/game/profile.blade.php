@extends('layouts.game')
@section('alert')
    @if (session('status'))
        <div aria-live="polite" aria-atomic="true" class="position-relative">
            <div class="toast-container top-0 end-0 p-3">
                <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
                    <div class="toast-header">
                        <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
                        <strong class="me-auto">Success</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('main')
    <div class="px-0 container">
        <div class="d-flex flex-lg-row flex-column">
            <section class="col-lg-4 bg-danger rounded-3">
                <div class="card w-100 rounded-0">
                    {{-- <div class="card-img-container rounded-2 rounded-bottom-0" style="max-height: 14rem; overflow: hidden;">
                        <img class="img-fluid" src="/img/fotliv_ads.png" alt="Advertisement">
                    </div> --}}

                    <div class="card-title px-3 m-0 border-bottom">
                        <div class="d-flex flex-column justify-content-center align-items-center my-3">
                            <div class="" style="width: 7rem; height: 7rem;">
                                <img class="w-100 h-100 rounded-circle border shadow-sm" src="{{ $user->logo }}"
                                    alt="">
                            </div>
                            <div class="ms-2 text-center mt-2" style="line-height: 1rem;">
                                <h5 class="m-0 fw-semibold">{{ $user->name }}</h5>
                                <p class="m-0 text-muted">{{ $user->email }}</p>
                            </div>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <form id="forgot_pass_form" class="w-100 mb-3 d-flex justify-content-center"
                            action="{{ route('password.email') }}" method="post">
                            @csrf
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <button onclick="confirm_email()" type="button"
                                class="btn btn-light fw-semibold border shadow-sm">Change
                                password</button>
                            <button id="edit_btn" type="button" class="btn btn-light fw-semibold border shadow-sm mx-1"
                                data-bs-toggle="modal" data-bs-target="#editprofile">Edit</button>

                            <a type="button" onclick="logout()" id="focus_tag"
                                class="text-decoration-none btn btn-light fw-semibold border shadow-sm">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </a>
                        </form>
                    </div>
                    <!-- Button trigger modal -->

                    <!-- Modal -->
                    <div class="modal fade" id="editprofile" tabindex="-1" aria-labelledby="editprofileLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered w-100 m-0">
                            <div class="modal-content rounded-0" style="min-height: 100vh;">
                                <div class="modal-header pb-0 border-0">
                                    <h1 class="modal-title fs-5" id="editprofileLabel"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        data-bs-target="#editprofile"></button>
                                </div>
                                <div class="modal-body border-0">
                                    <form id="update_user_form" action="{{ route('update.profile') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="w-100 d-flex justify-content-center">
                                            <div class="mb-2 position-relative" style="width: 7rem; height: 7rem;">
                                                <!-- Display the current profile image or a placeholder image -->
                                                <img id="profile-image"
                                                    class="w-100 h-100 mb-2 rounded-circle border shadow-sm"
                                                    src="{{ $user->logo }}" alt="Profile Image">
                                                <!-- Plus icon overlay -->
                                                <div id="plus-icon" class="position-absolute bottom-0 p-2"
                                                    style="right: -5px !important;">
                                                    <i class="fas fa-plus-circle fa-2x text-body-secondary"
                                                        style="cursor: pointer;"></i>
                                                </div>
                                            </div>

                                        </div>
                                        @error('name')
                                            <span class="text-warning">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('email')
                                            <span class="text-warning">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('update_email')
                                            <span class="text-warning">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        @error('logo')
                                            <span class="text-warning">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <!-- Input field for selecting a new profile image -->
                                        <div class="input-group mb-2" style="border-right: none;">
                                            <input id="image-input" type="file" accept="image/*"
                                                class="form-control shadow-sm bg-white rounded-3 ps-3 p-2 d-none"
                                                name="logo" onchange="previewImage(event)">
                                        </div>
                                        <div class="input-group mb-2" style="border-right: none;">
                                            <input id="email-input" type="text" value="{{ $user->name }}"
                                                class="form-control shadow-sm bg-white rounded-3 ps-3 p-2" name="name"
                                                autofocus>
                                        </div>
                                        <div class="input-group mb-2" style="border-right: none;">
                                            <input id="email-input" type="email" value="{{ $user->email }}"
                                                class="form-control shadow-sm bg-white rounded-3 ps-3 p-2" name="email">
                                        </div>
                                        <button onclick="confirm_update_user()" type="button"
                                            class="btn btn-dark w-100 fw-semibold">Update</button>
                                    </form>
                                </div>
                                {{-- <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-2">
                        @if ($user->status == 'guest')
                            <div class="p-1 col-12 d-flex rounded-2 border px-2">
                                <div class="d-flex align-items-center bg-white text-dark ps-2 rounded-start-2">
                                    <i class="fa-solid fa-key fs-6" id="nav_icon"></i>
                                </div>
                                <input type="password" value="{{ $user->id * 937667564564 - 539523223322 }}"
                                    class="border-0 col-10 ps-2 bg-white text-dark rounded-0 appName fw-medium"
                                    id="passwordInput" disabled>
                                <div class="toggle-password">
                                    <i class="fa-solid fa-eye-slash" id="toggleIcon"></i>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </section>
            <section class="col-lg-8 border border-top-0">
                {{-- <h3 class="text-center my-3">Coming soon!</h3> --}}
                @if ($user->status == 'guest')
                    <div class="m-0 rounded-0 text-center alert alert-warning" role="alert">
                        <strong>Please update your email address!</strong> <br> It seems like you are using a temporary
                        email
                        address. To access all features, please update your email to a valid one.
                        <br>
                        <strong>If you want to change your password, first you need to change your real email
                            address.</strong>
                    </div>
                @elseif($user->email_verified_at == null)
                    <div class="m-0 rounded-0 text-center alert alert-info" role="alert">
                        <strong>Please verify your email address!</strong> <br> We've sent you an email with a verification
                        link.
                        Please check your inbox (and spam folder) and follow the instructions to verify your email address.
                    </div>
                @else
                    <div class="alert alert-white rounded-0 m-0 text-center" role="alert">
                        <strong>Coming soon!</strong>
                        <br> Exciting new features are on the way. Stay tuned!
                    </div>
                @endif
            </section>
        </div>
    </div>
@endsection
@section('script')
    @if (request()->show_update_form == 'true')
        <script>
            $(document).ready(function() {
                // Simulate click on the "Edit" button
                $("#edit_btn").click();

                // Remove the query parameter from the URL
                var urlWithoutQuery = window.location.href.split('?')[0];
                window.history.replaceState({}, document.title, urlWithoutQuery);
            });
        </script>
    @endif
    @if ($user->status === 'guest')
        <script>
            const passwordInput = document.getElementById('passwordInput');
            const toggleIcon = document.getElementById('toggleIcon');

            toggleIcon.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('fa-eye');
            });
        </script>
    @endif
    <script>
        // Function to trigger file input when plus icon is clicked
        document.getElementById('plus-icon').addEventListener('click', function() {
            document.getElementById('image-input').click();
        });

        // Function to preview the selected image
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profile-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirm_email() {
            Swal.fire({
                title: "Send Password Reset Email?",
                text: "Are you sure you want to send a password reset email?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, send it",
                confirmButtonColor: "#000",
                cancelButtonText: "No, cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form to send the password reset email
                    $("#forgot_pass_form").submit();
                }
            });
        }

        function confirm_update_user() {
            Swal.fire({
                title: "Confirm User Update",
                text: "Are you sure you want to update the user?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, update it",
                confirmButtonColor: "#000",
                cancelButtonText: "No, cancel",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // User confirmed, submit the form to update the user
                    $("#update_user_form").submit();
                }
            });
        }

        function logout() {
            @if (Auth::check() && Auth::user()->status === 'guest')
                var additionalText = `<br><div class='text-danger'> Please remember your email and password.</div>
                <br>Your email: {{ Auth::user()->email }}<br>Your password: {{ $user->id * 937667564564 - 539523223322 }}<br>
                `;
            @else
                var additionalText = "";
            @endif

            Swal.fire({
                title: "Confirm Logout",
                html: "Are you sure you want to logout?" + additionalText,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "logout",
                confirmButtonColor: "#afaeae",
                cancelButtonColor: "#000",
                cancelButtonText: "cancel",
                // reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    document.getElementById('logout-form').submit();
                }
            });
        }



        $(document).ready(function() {
            // Listen for change event on the checkbox
            $('input[name^="setting["]').change(function() {
                var settingIndex = $(this).data('setting-index');
                var isChecked = Boolean($(this).prop('checked'));
                var token = "{{ csrf_token() }}";

                console.log(settingIndex)
                console.log('isChecked:', isChecked);

                if (isChecked == false) {
                    isChecked = 0;
                } else {
                    isChecked = 1;
                }

                // Send AJAX request to update user setting['notification']
                $.ajax({
                    url: '/update-profile',
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: {
                        _token: token,
                        settingIndex: settingIndex,
                        isChecked: isChecked
                    },
                    success: function(response) {},
                    error: function(xhr, status, error) {
                        // Handle error
                        alert(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
