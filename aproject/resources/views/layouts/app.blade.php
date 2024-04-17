<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App Name - @yield('title')</title>
    <script src="/js/jquery.min.js"></script>
    <script src="/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <link  rel="stylesheet" href="/bootstrap/dist/css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="/css/bootstrap-datepicker.min.css"/>

    <style>
        .top-right{
            position: absolute;
            background: #fff;
            width: 100%;
            padding: 6px 0;
            text-align: right;
        }
        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
        header{
            padding-bottom: 60px;
        }
    </style>

</head>
<body>
<header>
    <!-- Navigation bar and other content -->
    <div class="top-right links">

        <a href="{{ url('/') }}">home</a>
        @if (Route::has('login'))
            @if(session('user'))
                <a href="{{ route('logout') }}">logout</a>
                <a href="javascript:;" id="cancel-account">Cancel account</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endif
        @endif
    </div>
</header>

<main>
    @yield('content')
</main>

<footer>
    <!-- Footer Content -->
</footer>
<script>
    $("#cancel-account").click(function () {
        if(confirm("Are you sure you want to cancel your account? Warning!!!  After logging out, your account will no longer be able to log in and publish projects, and previously published projects will also be deleted!!!")){
            $.get("{{ asset('cancel') }}",function (res) {
                if(res.status==='success'){
                    alert("Operation successful");
                    location.reload()
                }else{
                    alert(res.message);
                }
            })
        }
    });
</script>
</body>
</html>
