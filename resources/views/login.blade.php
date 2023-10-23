<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<style>
html {
  min-height: 100%;/* fill the screen height to allow vertical alignement */
  display: grid; /* display:flex works too since body is the only grid cell */
}

body {
  margin: auto;
  font-family: Arial, Helvetica, sans-serif;
}

.login {
    margin-bottom: 20%;
    border: solid 6px;
    border-radius: 20px;
    border-color: #ffdcf2;
    padding: 20px;
    box-shadow: 10px 10px 8px #888888;
}

.login-form {
    margin-left: 38%;
}

.inputs {
    margin-top: 10%;
}

input {
    margin-bottom: 20px;
    border-radius: 5px;
    background-color: #ffdcf2; 
    box-shadow: 3px 3px 1px #888888;
}

input::placeholder {
    text-align: center;
}

.submit {
    margin-left: 10%;
    cursor: pointer;
    padding: 2px 30px;
    font-weight: bold;
    transition: 0.5s
}

.submit:hover {
    background-color: #d2b7c8;
}

</style>
<body>
    <div class="login">
        <a href="https://byronbaybikes.com" target="_blank"><img src="\images\RGB-LOGO-BYRON-BAY-BIKES.png" alt="Logo"></a>
        <form class="login-form" method="POST" action="/login">
        @csrf
        <div class="inputs">
            <input type="text" id="username" name="username" placeholder="Username"><br>
            @error('username')
                <p>{{$message}}</p>
            @enderror
    
            <input type="password" id="password" name="password" placeholder="Password"><br>
            @error('password')
                <p>{{$message}}</p>
            @enderror
    
            <input class="submit" type="submit" value="LOGIN">
        </div>
    </form>
    </div>
</body>
</html>