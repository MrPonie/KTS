<a-header :title="'Admin Login'"/>

<h1>Admin Login Page</h1>
<form action="{{ route('admin.login') }}" method="post">
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