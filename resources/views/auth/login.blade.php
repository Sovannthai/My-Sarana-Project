<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap">
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
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1440' height='560' preserveAspectRatio='none' viewBox='0 0 1440 560'%3e%3cg clip-path='url(%26quot%3b%23SvgjsClipPath1293%26quot%3b)' fill='none'%3e%3crect width='1440' height='560' x='0' y='0' fill='url(%26quot%3b%23SvgjsLinearGradient1294%26quot%3b)'%3e%3c/rect%3e%3ccircle r='23.945' cx='195.09' cy='374.55' fill='url(%26quot%3b%23SvgjsLinearGradient1295%26quot%3b)'%3e%3c/circle%3e%3ccircle r='46.38' cx='1235.35' cy='120.91' fill='url(%26quot%3b%23SvgjsLinearGradient1296%26quot%3b)'%3e%3c/circle%3e%3ccircle r='38.21' cx='1038.37' cy='236.46' fill='%2343468b'%3e%3c/circle%3e%3ccircle r='28.89' cx='1418.6' cy='382.32' fill='url(%26quot%3b%23SvgjsLinearGradient1297%26quot%3b)'%3e%3c/circle%3e%3ccircle r='35.675' cx='413.22' cy='179.35' fill='url(%26quot%3b%23SvgjsLinearGradient1298%26quot%3b)'%3e%3c/circle%3e%3ccircle r='48.995' cx='1206.23' cy='298.36' fill='url(%26quot%3b%23SvgjsLinearGradient1299%26quot%3b)'%3e%3c/circle%3e%3ccircle r='37.95' cx='515.61' cy='98.06' fill='url(%26quot%3b%23SvgjsLinearGradient1300%26quot%3b)'%3e%3c/circle%3e%3ccircle r='26.935' cx='754.5' cy='408.89' fill='%2343468b'%3e%3c/circle%3e%3c/g%3e%3cdefs%3e%3cclipPath id='SvgjsClipPath1293'%3e%3crect width='1440' height='560' x='0' y='0'%3e%3c/rect%3e%3c/clipPath%3e%3clinearGradient x1='15.28%25' y1='139.29%25' x2='84.72%25' y2='-39.29%25' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1294'%3e%3cstop stop-color='%230e2a47' offset='0'%3e%3c/stop%3e%3cstop stop-color='rgba(0%2c 0%2c 0%2c 1)' offset='1'%3e%3c/stop%3e%3c/linearGradient%3e%3clinearGradient x1='147.2' y1='374.55' x2='242.98' y2='374.55' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1295'%3e%3cstop stop-color='%23e298de' offset='0.1'%3e%3c/stop%3e%3cstop stop-color='%23484687' offset='0.9'%3e%3c/stop%3e%3c/linearGradient%3e%3clinearGradient x1='1142.59' y1='120.91' x2='1328.11' y2='120.91' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1296'%3e%3cstop stop-color='%23f29b7c' offset='0.1'%3e%3c/stop%3e%3cstop stop-color='%237e6286' offset='0.9'%3e%3c/stop%3e%3c/linearGradient%3e%3clinearGradient x1='1360.82' y1='382.31999999999994' x2='1476.3799999999999' y2='382.31999999999994' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1297'%3e%3cstop stop-color='%2332325d' offset='0.1'%3e%3c/stop%3e%3cstop stop-color='%23424488' offset='0.9'%3e%3c/stop%3e%3c/linearGradient%3e%3clinearGradient x1='341.87' y1='179.35' x2='484.57' y2='179.35' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1298'%3e%3cstop stop-color='%23e298de' offset='0.1'%3e%3c/stop%3e%3cstop stop-color='%23484687' offset='0.9'%3e%3c/stop%3e%3c/linearGradient%3e%3clinearGradient x1='1108.24' y1='298.36' x2='1304.22' y2='298.36' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1299'%3e%3cstop stop-color='%23ab3c51' offset='0.1'%3e%3c/stop%3e%3cstop stop-color='%234f4484' offset='0.9'%3e%3c/stop%3e%3c/linearGradient%3e%3clinearGradient x1='439.71000000000004' y1='98.06' x2='591.51' y2='98.06' gradientUnits='userSpaceOnUse' id='SvgjsLinearGradient1300'%3e%3cstop stop-color='%23ab3c51' offset='0.1'%3e%3c/stop%3e%3cstop stop-color='%234f4484' offset='0.9'%3e%3c/stop%3e%3c/linearGradient%3e%3c/defs%3e%3c/svg%3e");
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
            border: 2px solid rgba(215, 211, 211, 0.763);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.15);
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
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                    <label for="email">Enter your email</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-field">
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror" name="password" required
                        autocomplete="off">
                    <label for="password">Enter your password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
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
