<?php

/** @var PDO $pdo */ // 
require_once "includes/dhp.inc.php";

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}
$id = $_GET['id'];

$query = "SELECT * FROM menu_items WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);
$dish = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dish) {
    die("Jídlo nebylo nalezeno.");
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Upravit jídlo</title>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/admin_edit.css">
</head>

<body class="admin-body">

    <div class="edit-form-container">
        <h1 class="admin-title">Upravit jídlo</h1>

        <form action="includes/menu_handler.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="dish_id" value="<?php echo $dish['id']; ?>">

            <div class="input-group">
                <label>Název jídla:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($dish['name']); ?>" required>
            </div>

            <div class="input-group">
                <label>Cena (CZK):</label>
                <input type="number" name="price" step="0.01" value="<?php echo $dish['price']; ?>" required>
            </div>

            <div class="input-group">
                <label>Popis:</label>
                <textarea name="description" rows="4"><?php echo htmlspecialchars($dish['description']); ?></textarea>
            </div>

            <div class="input-group">
                <label>Aktuální obrázek:</label><br>
                <img src="../<?php echo $dish['image_path']; ?>" width="120" style="margin-bottom:10px;">
                <input type="file" name="dish_image">
            </div>

            <button type="submit" name="action" value="update" class="btn-edit" style="width:100%; padding:15px; font-size:16px;">Uložit změny</button>
            <div style="text-align: center; margin-top: 20px;">
                <a href="admin_dashboard.php" style="color: #666; text-decoration: none;">← Zpět do administrace</a>
            </div>
        </form>
    </div>

</body>

</html>