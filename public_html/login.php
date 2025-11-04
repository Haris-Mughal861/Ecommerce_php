<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="icon" type="png" href="login.png">
  <style>
    body {
      background-color: lightgray;
      padding: 80px;
    }
    .container {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      gap: 25px;
      padding: 50px;
      background: white;
      border-radius: 10px;
      width: 90%;
      max-width: 500px;
      margin: auto;
    }
    input, button {
      width: 80%;
      height: 40px;
      border-radius: 5px;
      border: 1px solid gray;
      padding: 5px;
    }
    button {
      background-color: blue;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }
    #loginMsg {
      text-align: center;
      font-weight: bold;
      margin-top: 20px;
      color: green;
    }
     img{
      display: block;
  margin-left: auto;
  margin-right: auto;
  padding: 20px;
  

    }
    a {
    text-decoration: none;
    color: darkblue;
    font-weight: bold;
    cursor: pointer;
    padding: 5px;
    border: 1px solid darkblue;
    border-radius: 5px;
    background-color: lightblue;
  }
   button {
    padding: 10px 20px;
    border: none;
    background-color: darkblue;
    color: white;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
  }
  </style>
</head>
<body>

<h1 style="text-align:center;">Entre login Details</h1>
<img src="lock.png" alt="Description" width="100" height="65">

<form id="loginForm" class="container">
  <label>Email:</label>
  <input type="email" name="email" >
  <label>Password:</label>
  <input type="password" name="password">
  <button type="submit">Login</button>
  <a href="register.php">Dont have Account?</a>
</form>



<div id="loginMsg"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function showPopup(message, type = "error") {
  const bg = type === "success" ? "#4CAF50" : "red";
  const popup = $(`
    <div style="
      position: fixed;
      top: 20%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: ${bg};
      color: white;
      padding: 15px 30px;
      border-radius: 8px;
      font-size: 18px;
      font-weight: bold;
      box-shadow: 0 3px 10px rgba(0,0,0,0.3);
      z-index: 9999;
      opacity: 0.9;
    ">${message}</div>
  `);
  $("body").append(popup);
  setTimeout(() => popup.fadeOut(500, () => popup.remove()), 1500);
}

$("#loginForm").submit(function(e) {
  e.preventDefault();

  $.ajax({
    url: "ajax/ajax_login.php",
    type: "POST",
    data: $(this).serialize(),
    success: function(response) {
      const res = response.trim();

      if (res === "admin_success") {
        showPopup("Admin Login Successful!", "success");
        setTimeout(() => window.location.href = "../admin/admin_dashboard.php", 1500);
      } 
      else if (res === "user_success") {
        showPopup("User Login Successful!", "success");
        setTimeout(() => window.location.href = "index.php", 1500);
      } 
      else {
        showPopup(res, "error");
      }
    },
    error: function() {
      showPopup("Server error. Try again.", "error");
    }
  });
});

</script>




</body>
</html>
        
      
      
      
