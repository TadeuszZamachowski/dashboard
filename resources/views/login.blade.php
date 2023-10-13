<h1>Login</h1>
<form method="POST" action="/login">
    @csrf
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username"><br>
    @error('username')
        <p>{{$message}}</p>
    @enderror

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>
    @error('password')
        <p>{{$message}}</p>
    @enderror

    <input type="submit" value="Submit">
</form>