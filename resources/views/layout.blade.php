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
          <li><a class="nav-link" href="/dashboard">Dashboard</a></li>
          <li><a class="nav-link" href="/incidents">Incidents</a></li>
          <li><a class="nav-link" href="/orders/archive">Archive</a></li>
          <li><a class="nav-link" href="/reports">Reports</a></li>
          <li><a class="nav-link" href="/settings">Settings</a></li>
          <li><a class="nav-link" href="/messages">Messages</a></li>
        </ul>
      </div>
    </div> 
  </nav>

  <nav id="navbar-top" class="navbar-top">
    <div class="container">
      <div class="main-menu">
        <ul>
          <li><button id="hamburger" onclick="showSidebar()"><i class="fa fa-bars btn"></i></button></li>
          <li><a class="nav-link" href="/">ORDERS</a></li>
          <li><a class="nav-link" href="/bikes">BIKES</a></li>
          <li><a class="nav-link" href="/schedule">SCHEDULE</a></li>
          <!-- <li><a class="nav-link" href="/inventory">INVENTORY</a></li> -->
        </ul>
      </div>
    </div>
  </nav>
  <script src="\js\app.js"></script>
  <script src="\js\sortTable.js"></script>
  <div class="hamburger">
    <button id="thisisbrokenbutwithoutthisitlooksugly">"<i class="fa fa-bars"></i></button>
  </div>
  <div id="main" class="main">
    <x-flash-message />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    @yield('content')
  </div>
</body>
<footer class="footer">
  Copyright &copy; 2024 All Rights Reserved by Ostral
</footer>
</html>
