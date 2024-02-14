<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Teacher Login</title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="app.css">
    </head>
    <body class="antialiased">
        <h1>Teacher Login Page</h1>
        <form action="{{ route('teacher.login') }}" method="post">
            @csrf
            <div class="p-4">
                <div class="">
                    <label for="username">Usename</label>
                    <input type="text" name="username">
                    @error('username')
                        <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="">
                    <label for="password">Password</label>
                    <input type="password" name="password">
                    @error('password')
                        <p>{{$message}}</p>
                    @enderror
                </div>
                <div class="">
                    <button type="submit">Submit</button>
                </div>
            </div>
        </form>
    </body>
</html>