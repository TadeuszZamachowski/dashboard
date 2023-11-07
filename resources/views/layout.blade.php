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
  <nav id="navbar-bottom" class="navbar-bottom">
    <div class="logo-container">
      <div class="logo">
        <a href="/"><img src="\images\RGB-LOGO-BYRON-BAY-BIKES.png" alt="Logo" width="150px"></a>
      </div>
    </div>
    <div class="container">
      <div class="main-menu">
        <ul>
          <li><a href="/incidents">Incidents</a></li>
          <li><a href="/orders/archive">Archive</a></li>
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
          <li><a class ="nav-link" href="/">HOME</a></li>
          <li><a class="nav-link" href="/orders">ORDERS</a></li>
          <li><a class="nav-link" href="/bikes">BIKES</a></li>
          <li><a class="nav-link" href="/schedule">SCHEDULE</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <script src="\js\app.js"></script>
  <script src="\js\sortTable.js"></script>
  <div class="hamburger">
    <button id="hamburger" onclick="showSidebar()"><i class="fa fa-bars"></i></button>
  </div>
  <div id="main" class="main">
    <x-flash-message />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    @yield('content')
  </div>
</body>
<footer class="footer">
  Copyright &copy; 2023 All Rights Reserved by Ostral
</footer>
</html>
