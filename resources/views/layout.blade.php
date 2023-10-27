<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bikes Dashboard</title>
    <link rel="stylesheet" type='text/css' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="\css\app.css" >
</head>
<body>
  <nav class="navbar-bottom">
    <div class="logo-container">
      <div class="logo">
        <a href="/"><img src="\images\RGB-LOGO-BYRON-BAY-BIKES.png" alt="Logo" width="150px"></a>
      </div>
    </div>
    <div class="container">
      <div class="main-menu">
        <ul>
          <li><a href="/orders/archive">Archive</a></li>
          <li><a href="/history">History</a></li>
          <li><a href="/reports">Reports</a></li>
          <li><a href="/settings">Settings</a></li>
        </ul>
      </div>
    </div> 
  </nav> 

  <nav class="navbar-top">
    <div class="container">
      <div class="main-menu">
        <ul>
          <li><a class="nav-link" href="/">ORDERS</a></li>
          <li><a class="nav-link" href="/bikes">BIKES</a></li>
          <li><a class="nav-link" href="/schedule">SCHEDULE</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <script src="\js\app.js"></script>

  <div id="main">
    <x-flash-message />
    @yield('content')
  </div>
</body>
<footer class="footer">
  Copyright &copy; 2023 All Rights Reserved by Ostral
</footer>
</html>
