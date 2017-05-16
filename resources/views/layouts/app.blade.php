<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Stock - @yield('title')</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/css/app.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
          <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="/">Stock</a>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="/">Home</a>
              </li>
              @if(Auth::check())
              <li class="nav-item">
                <a class="nav-link" href="/dash">Control Panel</a>
              </li>
              @endif
            </ul>
            <ul class="navbar-nav my-6 my-lg-0">
              @if(Auth::check())
              <li class="nav-item">
                <a class="nav-link" href="/dash">Shares owned: <strong>{{ Auth::user()->sharesOwned() }}</strong></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/bank">Bank: <strong>${{ number_format(Auth::user()->bank->credit / 100,2) }}</strong></a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="userMenuLink">
                  <a class="dropdown-item" href="/user/{{ Auth::user()->name }}">Profile</a>
                  <a class="dropdown-item" href="/settings">Settings</a>
                  <a class="dropdown-item" href="/logout">Logout</a>
                </div>
              </li>     
              @else
              <li class="nav-item">
                <a class="nav-link" href="/login">Sign In</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/register">Sign Up</a>
              </li>
              @endif
            </ul>
          </div>
        </nav>    

        
        @yield('content')
        
        
        <!-- jQuery -->
        <script src="/js/app.js"></script>
        @yield('scripts')      
    </body>
</html>