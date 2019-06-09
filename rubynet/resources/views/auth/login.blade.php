<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <title>Login - Rubynet</title>

    <script type='text/javascript'>
       window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>
</head>
<body>
    <div class="grid-x align-center">
        <div class="row column align-center medium-6 large-4 container-padded">
            <form class="log-in-form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <h4 class="text-center">Rubynet Login</h4>
                @if(!empty($errors->first()))
                <div class="row col-lg-12">
                    <div class="callout alert">
                    {{ $errors->first() }}
                    </div>
                </div>
                @endif
                @if (session('status'))
                <div class="callout success">
                     {{ session('status') }}
                </div>
                @endif
                @if (session('warning'))
                <div class="callout warning">
                    {{ session('warning') }}
                </div>
                @endif
                <label>Email
                    <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                </label>                        
                <label>Password
                    <input id="password" type="password" placeholder="Password" name="password" required>
                </label>
                <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Remember me</label>
                <p><input type="submit" class="button expanded" value="Log in"></p>
                <p class="text-center">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </p>
                <div>
                    New to Rubynet ? <a href="{{ route('register') }}">Sign up now <i class="fi-pencil"></i></a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
