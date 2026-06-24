<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Změna údajů | Administrace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../CSS/admin_dashboard.css">
</head>

<body>
    <div class="admin-container">
        <h1>Změna přihlašovacích údajů</h1>

        <?php if (isset($_GET['error'])): ?>
            <div style="color: red; margin-bottom: 15px;">
                <?php
                if ($_GET['error'] == 'empty') echo "Vyplňte všechna pole.";
                if ($_GET['error'] == 'mismatch') echo "Hesla se neshodují.";
                if ($_GET['error'] == 'db_error') echo "Chyba při ukládání do databáze.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div style="color: green; margin-bottom: 15px;">Údaje byly úspěšně změněny!</div>
        <?php endif; ?>

        <form action="includes/change_handler.php" method="POST">
            <div class="input-group">
                <label>Nový e-mail:</label>
                <input type="email" name="new_email" required>
            </div>

            <div class="input-group">
                <label>Nové heslo:</label>
                <input type="password" name="new_password" required minlength="6">
            </div>

            <div class="input-group">
                <label>Potvrzení nového hesla:</label>
                <input type="password" name="confirm_password" required minlength="6">
            </div>

            <button type="submit" name="submit_change">Aktualizovat údaje</button>
            <br><br>
            <a href="admin_dashboard.php">← Zpět do administrace</a>
        </form>
    </div>
</body>

</html>