<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bikes Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"  type='text/css'>
</head>
<style>

  * {
    font-family: Arial, Helvetica, sans-serif;
  }

  i {
    font-family: "FontAwesome";
  }
  
  .menu a {
      margin-right: 50px;
      text-decoration: none;
      font-size: 25px;
      color: black;
      transition: 0.3s;
  }
  
  .menu {
    position: fixed;
    top: 0;
    margin-left: 210px;
    background-color: #ffeaf7;
    display: block;
  }
  
  .menu a:hover {
    color: #a36464;
  }
  
      
  .sidenav {
    height: 100%;
    width: 200px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #ffeaf7;
    overflow-x: hidden;
    padding-top: 20px;
  }
  
  /* The navigation menu links */
  .sidenav a{
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: black;
    display: block;
    transition: 0.3s;
  }
  
  /* When you mouse over the navigation links, change their color */
  .sidenav a:hover {
      color: #a36464;
  }
  
  /* Position and style the close button (top right corner) */
  .sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
  }
  
  /* Style page content - use this if you want to push the page content to the right when you open the side navigation */
  #main {
    margin-top: 100px;
      margin-left: 210px;
  }
  
  /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
  @media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
    .sidenav a {font-size: 18px;}
  }
  </style>
<body>
  <div class="menu">
    <a href="/">Orders</a>
    <a href="/bikes">Bikes</a>
    <a href="/schedule">Schedule</a>
  </div>
      <div id="main">
        <div id="mySidenav" class="sidenav">
          <a href="/"><img src="\images\RGB-LOGO-BYRON-BAY-BIKES.png" alt="Logo" width="150px"></a>
          <a href="/orders/add">Add Order</a>
          <a href="/bikes/add">Add Bike</a>
          <a href="/assign">Assign Bike to Order</a>
          <a href="/history">History</a>
          <a href="/reports">Reports</a>
        </div> 
        @yield('content')
        <x-flash-message />
      </div>
</body>
</html>
