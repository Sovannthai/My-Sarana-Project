<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Open Sans", sans-serif;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1020%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='%231a4e83'%3e%3c/rect%3e%3cpath d='M0 0L767.2 0L0 530.69z' filter='url(%23SvgjsFilter1021)' fill='%232d409e'%3e%3c/path%3e%3cpath d='M0 560L767.2 560L0 29.309999999999945z' filter='url(%23SvgjsFilter1021)' fill='%232d409e'%3e%3c/path%3e%3cpath d='M1440 560L672.8 560L1440 29.309999999999945z' filter='url(%23SvgjsFilter1021)' fill='%232d409e'%3e%3c/path%3e%3cpath d='M1440 0L672.8 0L1440 530.69z' filter='url(%23SvgjsFilter1021)' fill='%232d409e'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1020'%3e%3crect width='1440' height='560' fill='white'%3e%3c/rect%3e%3c/mask%3e%3cfilter height='130%25' id='SvgjsFilter1021'%3e%3cfeGaussianBlur in='SourceAlpha' stdDeviation='5' result='TopLeftG'%3e%3c/feGaussianBlur%3e%3cfeOffset dx='-5' dy='-5' in='TopLeftG' result='TopLeftO'%3e%3c/feOffset%3e%3cfeComponentTransfer in='TopLeftO' result='TopLeftC'%3e%3cfeFuncA type='linear' slope='0.7'%3e%3c/feFuncA%3e%3c/feComponentTransfer%3e%3cfeGaussianBlur in='SourceAlpha' stdDeviation='5' result='TopRightG'%3e%3c/feGaussianBlur%3e%3cfeOffset dx='5' dy='-5' in='TopRightG' result='TopRightO'%3e%3c/feOffset%3e%3cfeComponentTransfer in='TopRightO' result='TopRightC'%3e%3cfeFuncA type='linear' slope='0.7'%3e%3c/feFuncA%3e%3c/feComponentTransfer%3e%3cfeGaussianBlur in='SourceAlpha' stdDeviation='5' result='BottomLeftG'%3e%3c/feGaussianBlur%3e%3cfeOffset dx='-5' dy='5' in='BottomLeftG' result='BottomLeftO'%3e%3c/feOffset%3e%3cfeComponentTransfer in='BottomLeftO' result='BottomLeftC'%3e%3cfeFuncA type='linear' slope='0.7'%3e%3c/feFuncA%3e%3c/feComponentTransfer%3e%3cfeGaussianBlur in='SourceAlpha' stdDeviation='5' result='BottomRightG'%3e%3c/feGaussianBlur%3e%3cfeOffset dx='5' dy='5' in='BottomRightG' result='BottomRightO'%3e%3c/feOffset%3e%3cfeComponentTransfer in='BottomRightO' result='BottomRightC'%3e%3cfeFuncA type='linear' slope='0.7'%3e%3c/feFuncA%3e%3c/feComponentTransfer%3e%3cfeMerge%3e%3cfeMergeNode in='TopLeftC'%3e%3c/feMergeNode%3e%3cfeMergeNode in='TopRightC'%3e%3c/feMergeNode%3e%3cfeMergeNode in='BottomLeftC'%3e%3c/feMergeNode%3e%3cfeMergeNode in='BottomRightC'%3e%3c/feMergeNode%3e%3cfeMergeNode in='SourceGraphic'%3e%3c/feMergeNode%3e%3c/feMerge%3e%3c/filter%3e%3c/defs%3e%3c/svg%3e");
            background-position: center;
            background-size: cover;
            padding: 0 10px;
        }

        .wrapper {
            width: 90%;
            max-width: 400px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.763);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            background: rgba(57, 54, 54, 0.15);
            margin: auto;
            transition: 0.5s;
        }

        .wrapper:hover {
            transform: 5s;
            transform: translateY(-15px);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .input-field {
            position: relative;
            margin: 15px 0;
        }

        .input-field input {
            width: 100%;
            height: 40px;
            background: transparent;
            border: none;
            outline: none;
            font-size: 16px;
            color: #fff;
            border-bottom: 2px solid #ccc;
            transition: border-color 0.3s ease;
        }

        .input-field input:focus {
            border-bottom-color: #fff;
        }

        .input-field label {
            position: absolute;
            top: 10px;
            left: 0;
            color: #fff;
            font-size: 16px;
            pointer-events: none;
            transition: 0.15s ease;
        }

        .input-field input:focus~label,
        .input-field input:valid~label {
            top: -10px;
            font-size: 12px;
        }

        .forget {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 25px 0 35px 0;
            color: #fff;
        }

        .forget a {
            color: #fff;
            text-decoration: none;
        }

        .forget a:hover {
            text-decoration: underline;
        }

        button {
            background: #fff;
            color: #000;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
            border: 2px solid transparent;
            transition: 0.3s ease;
            margin-top: 15px;
        }

        button:hover {
            color: #fff;
            border-color: #fff;
            background: rgba(255, 255, 255, 0.15);
        }

        .register {
            text-align: center;
            margin-top: 30px;
            color: #fff;
        }

        .register a {
            color: #fff;
            text-decoration: none;
        }

        .register a:hover {
            text-decoration: underline;
        }

    </style>
</head>

<body>
    <div class="wrapper">
        <div class="row">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2>Login</h2>
                <div class="input-field">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                    <label for="email">Enter your email</label>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: rgb(255, 98, 98);">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="input-field">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="off">
                    <label for="password">Enter your password</label>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong style="color: rgb(255, 98, 98);">{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="forget">
                    <label for="remember">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    <a href="#">Forgot password?</a>
                </div>
                <button type="submit">Log In</button>

                <div class="register">
                    <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
