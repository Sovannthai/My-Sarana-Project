<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('Document')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex align-items-center min-vh-100">
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4 class="mb-0">{{ __('Complete Your Login') }}</h4>
                    </div>
                    <div class="card-body p-5">
                        <form method="POST" action="{{ route('store_user.telegram') }}" enctype="multipart/form-data">
                            @csrf
                            {{-- @dd($telegram_user); --}}
                            <!-- Hidden fields to store Telegram user data -->
                            <input type="hidden" name="telegram_id" value="{{ $telegram_user->id }}">
                            <input type="hidden" name="name" value="{{ $telegram_user->name }}">
                            <input type="hidden" name="username" value="{{ $telegram_user->nickname }}">
                            <input type="hidden" name="phone" value="{{ $telegram_user->phone }}">
                            <input type="hidden" name="avatar" value="{{ $telegram_user->avatar }}">
                            <input type="hidden" name="access_token" value="{{ $telegram_user->hash }}">
                            <input type="hidden" name="password" value="{{ $telegram_user->email }}">
                            <input type="hidden" name="email" value="{{ $telegram_user->email }}">

                            <!-- Display the Telegram user information -->
                            <div class="mb-3">
                                <label for="display_name"
                                    class="form-label">{{ __('Telegram User Information') }}</label>
                                <div class="form-control-plaintext">
                                    <p><strong>{{ __('Telegram ID:') }}</strong>{{ $telegram_user->id }}</p>
                                    <p><strong>{{ __('Name:') }}</strong>{{ $telegram_user->name }}</p>
                                    <p><strong>{{ __('Username:') }}</strong> {{ $telegram_user->nickname }}</p>
                                    <p><strong>{{ __('Avatar URL:') }}</strong> <a href="{{ $telegram_user->avatar }}"
                                            target="_blank">{{ $telegram_user->avatar }}</a></p>
                                </div>
                            </div>

                            <!-- Optional Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Enter your email') }}</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" autocomplete="off" autofocus required>
                                @error('email')
                                    <span class="invalid-feedback d-block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">{{ __('Complete Login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional: FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <!-- Optional: Bootstrap 5 JS for components (like modals, dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to Toggle Password Visibility -->
    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

</body>

</html>
