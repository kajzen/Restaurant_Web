<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Přihlášení Administrátora</title>
  <link href="https://fonts.googleapis.com/css2?family=Caprasimo&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/admin.css">
</head>

<body class="login-body">

  <div class="login-container">
    <form action="includes/formhandler.inc.php" method="POST" class="login-form">
      <h1 class="login-title">Administrace</h1>
      <p class="login-subtitle">Vítejte zpět, prosím přihlaste se</p>

      <div class="input-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="vas@email.cz" required />
      </div>

      <div class="input-group">
        <label for="pwd">Heslo</label>
        <input type="password" id="pwd" name="pwd" placeholder="••••••••" required />
      </div>

      <button type="submit" name="submit" class="login-button">Přihlásit se</button>

      <a href="../HTML/restaurant-LiChun-project.php" class="back-link">← Zpět na web</a>
    </form>
  </div>

</body>

</html>