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
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1009%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='%230e2a47'%3e%3c/rect%3e%3cpath d='M0%2c311.715C56.529%2c301.526%2c97.927%2c258.564%2c147.251%2c229.127C198.629%2c198.464%2c263.228%2c185.261%2c295.885%2c135.126C330.205%2c82.437%2c334.398%2c15.425%2c327.136%2c-47.035C319.745%2c-110.602%2c288.721%2c-166.456%2c254.532%2c-220.553C215.046%2c-283.031%2c184.84%2c-367.345%2c113.203%2c-385.534C41.352%2c-403.777%2c-21.745%2c-335.913%2c-90.481%2c-308.152C-151.296%2c-283.59%2c-227.562%2c-283.816%2c-267.488%2c-231.78C-307.119%2c-180.129%2c-287.778%2c-107.095%2c-294.439%2c-42.334C-300.784%2c19.358%2c-324.993%2c80.667%2c-305.685%2c139.602C-285.383%2c201.568%2c-242.653%2c257.17%2c-185.833%2c289.162C-130.336%2c320.409%2c-62.679%2c323.012%2c0%2c311.715' fill='%230b2239'%3e%3c/path%3e%3cpath d='M1440 1026.849C1535.946 1011.97 1636.112 1042.98 1724.3319999999999 1002.4300000000001 1819.4560000000001 958.706 1895.655 882.469 1949.473 792.669 2007.551 695.762 2045.126 586.459 2041.298 473.546 2037.21 352.971 2010.62 225.00099999999998 1927.271 137.77800000000002 1845.07 51.757000000000005 1719.56 18.976 1600.753 12.527000000000044 1495.941 6.837999999999965 1401.753 60.78199999999998 1306.124 104.06 1223.042 141.66000000000003 1140.788 180.07600000000002 1080.108 248.152 1018.855 316.87 982.521 401.618 961.0930000000001 491.144 937.9839999999999 587.692 931.174 685.763 952.139 782.799 977.0930000000001 898.294 987.047 1047.512 1092.722 1100.375 1200.732 1154.4070000000002 1320.655 1045.356 1440 1026.849' fill='%23113255'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1009'%3e%3crect width='1440' height='560' fill='white'%3e%3c/rect%3e%3c/mask%3e%3c/defs%3e%3c/svg%3e");
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
            <script async src="https://telegram.org/js/telegram-widget.js?7" data-telegram-login="NotificatonServiceLogin887_bot"
                data-size="large" data-auth-url="{{ route('telegram_callback') }}" data-request-access="write"></script>
            <script type="text/javascript">
                function onTelegramAuth(user) {
                    fetch('{{ route('telegram_callback') }}', {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(user)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = '/home'; // Redirect to the home route on successful login
                            } else {
                                alert('Login failed.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            </script>
        </div>
    </div>

</body>

</html>
