<!-- create reset password email templates -->
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
  <style>
    /* Add your custom CSS styles here */
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
    }

    .box {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .logo {
      text-align: center;
      margin-bottom: 20px;
    }

    .logo img {
      max-width: 150px;
    }

    .message {
      margin-bottom: 20px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
    }

    .footer {
      text-align: center;
      margin-top: 20px;
      color: #888888;
    }
  </style>
</head>

<body>
  <div class="box">
    <div class="logo">
      <h1>Coralis Studio</h1>
    </div>
    <div class="message">
      <p>Dear <?= isset($name) ? $name : '' ?>,</p>
      <p>We have received a request to reset your password. To proceed, please click the button below:</p>
    </div>
    <div class="button">
      <a href="<?= isset($token) ? site_url('auth/reset_password/?token=' . $token) : '#' ?>" target="_blank">Reset Password</a>
    </div>
    <div class="footer">
      <p>If you did not request a password reset, please ignore this email.</p>
    </div>
  </div>
</body>

</html>