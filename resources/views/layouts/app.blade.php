<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Business Records') - Business Records App</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        nav {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
        }
        nav .nav-left {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        nav .nav-right {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }
        nav a:hover, nav a.active {
            color: #667eea;
        }
        .user-info {
            font-size: 14px;
            color: #666;
        }
        .user-info strong {
            color: #333;
        }
        .logout-form {
            margin: 0;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: background 0.3s;
        }
        .logout-btn:hover {
            background: #c82333;
        }
        .main {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }
        h1, h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5568d3;
        }
        .btn-secondary {
            background: #6c757d;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover {
            background: #c82333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background: #f8f9fa;
            font-weight: 600;
        }
        table tr:hover {
            background: #f8f9fa;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: 500;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-family: inherit;
            font-size: 14px;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a, .actions form {
            display: inline;
        }
        .text-muted {
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav>
            <div class="nav-left">
                <strong style="font-size: 18px;">📊 Business Records</strong>
                <a href="{{ route('home') }}">Dashboard</a>
                <a href="{{ route('suppliers.index') }}" @if(request()->routeIs('suppliers.*')) class="active" @endif>Suppliers</a>
                <a href="{{ route('goods.index') }}" @if(request()->routeIs('goods.*')) class="active" @endif>Goods</a>
                <a href="{{ route('sales.index') }}" @if(request()->routeIs('sales.*')) class="active" @endif>Sales</a>
            </div>
            <div class="nav-right">
                @auth
                    <div class="user-info">
                        Welcome, <strong>{{ Auth::user()->name }}</strong>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="color: #667eea; font-weight: 600;">Login</a>
                    <a href="{{ route('register') }}" style="background: #667eea; color: white; padding: 8px 16px; border-radius: 4px;">Register</a>
                @endauth
            </div>
        </nav>

        <div class="main">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
