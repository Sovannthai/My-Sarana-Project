<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('uploads/all_photo/' . session('web_logo')) }}" type="image/x-icon" />
    <!-- Fonts and icons -->
    <script src="{{ asset('backends/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('backends/assets/css/fonts.min.css') }}"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backends/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backends/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backends/assets/css/kaiadmin.min.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('backends/plugin/dropfy/dist/css/demo.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('backends/plugin/dropfy/dist/css/dropify.min.css') }}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{ asset('backends/assets/css/demo.css') }}" />
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include Font Awesome CSS -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
    {{-- Image link Preview --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js"></script>

    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('backends/plugin/select2/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('backends/plugin/select2/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .footer {
            background-color: #f8f9fa;
            /* Adjust as needed */
            padding: 20px 0;
        }

        .copyright {
            position: relative;
            overflow: hidden;
            width: 100%;
            height: 20px;
        }

        .text-container {
            display: inline-block;
            white-space: nowrap;
        }

        .sliding-text {
            display: inline-block;
            /* animation: slide 15s linear infinite; */
        }

        @keyframes slide {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .card {
            position: relative;
            border: 1px solid transparent;
            background-image: linear-gradient(white, white),
                linear-gradient(45deg, slateblue, #ff75c3, #0d9bb3);
            background-origin: border-box;
            background-clip: padding-box, border-box;
        }

        .form-control {
            position: relative;
            border: 1px solid transparent;
            background-image: linear-gradient(white, white),
                linear-gradient(45deg, slateblue, #ff75c3, #0d9bb3);
            background-origin: border-box;
            background-clip: padding-box, border-box;
        }

        .select2 {
            border-radius: 4px;
            position: relative;
            border: 1px solid transparent;
            background-image: linear-gradient(white, white),
                linear-gradient(45deg, slateblue, #ff75c3, #0d9bb3);
            background-origin: border-box;
            background-clip: padding-box, border-box;
        }

        .select2-container .select2-selection--single {
            height: 34px;
            line-height: 38px;
            padding: 0 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 34px;
        }
    </style>
</head>
