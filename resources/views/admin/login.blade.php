<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('style.css')}}">
    <title>Login</title>
</head>
<body>
    <div class="login-page">
        <div class="login-container">
            <div class="login-header">
                <div class="login-icon">
                <img src="/assets/Durga_logo.png" alt="logo" class="login-logo-img"/>
                </div>
                <h1>Durga Mining Admin</h1>
                <div class="subtitle">Enter your credentials to access the control panel</div>
            </div>
            
            <form class="login-form" action="{{ route('handle.login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="email">email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
               
                
                <button type="submit" class="login-button">Login</button>
                @if($errors->any())
                {!! implode('', $errors->all('<div class="text-danger my-2">:message</div>')) !!}
            @endif
            </form>
            
            <div class="login-footer">
                <p style="margin-top: 10px;">© 2025 Durga Mining. All rights reserved.</p>
            </div>
        </div>
    </div>
  
</body>
</html>