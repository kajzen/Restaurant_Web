<?php
require_once "dhp.inc.php";
/** @var PDO $pdo */

// ДОБАВЛЕНИЕ БЛЮДА
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $category = $_POST['category'];
    $description = trim($_POST['description']);
    $allergens = trim($_POST['allergens']);

    if ($price < 0) {
        header("Location: ../admin_dashboard.php?error=negative_price");
        exit();
    }

    // ЛОГИКА ЗАГРУЗКИ КАРТИНКИ
    $target_dir = "../../images/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($_FILES["dish_image"]["name"], PATHINFO_EXTENSION));
    $file_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_extension;
    $target_file = $target_dir . $file_name;
    $db_image_path = "images/" . $file_name;

    // Проверка, что это реально картинка
    $check = getimagesize($_FILES["dish_image"]["tmp_name"]);
    if ($check !== false && move_uploaded_file($_FILES["dish_image"]["tmp_name"], $target_file)) {
        try {
            $query = "INSERT INTO menu_items (name, description, price, category, image_path, allergens) 
                      VALUES (?, ?, ?, ?, ?, ?);";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$name, $description, $price, $category, $db_image_path, $allergens]);

            header("Location: ../admin_dashboard.php?success=add");
            exit();
        } catch (PDOException $e) {
            die("Error Db: " . $e->getMessage());
        }
    } else {
        die("Chyba při nahrávání obrázku.");
    }
}

// ОБНОВЛЕНИЕ БЛЮДА
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = (int)$_POST['dish_id'];
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    $description = trim($_POST['description']);

    // ПРОВЕРКА ЦЕНЫ
    if ($price < 0) {
        header("Location: ../admin_dashboard.php?error=negative_price");
        exit();
    }

    // Получаем текущую картинку
    $stmt = $pdo->prepare("SELECT image_path FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);
    $current_dish = $stmt->fetch();
    $image_path = $current_dish['image_path'];

    // Если загружен новый файл
    if (!empty($_FILES['dish_image']['name'])) {
        $file_extension = strtolower(pathinfo($_FILES["dish_image"]["name"], PATHINFO_EXTENSION));
        $new_file_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_extension;
        $target_file = "../../images/" . $new_file_name;

        if (move_uploaded_file($_FILES["dish_image"]["tmp_name"], $target_file)) {
            // Удаляем старый файл, если он существует
            if (!empty($image_path) && file_exists("../../" . $image_path)) {
                unlink("../../" . $image_path);
            }
            $image_path = "images/" . $new_file_name;
        }
    }

    try {
        $sql = "UPDATE menu_items SET name = ?, price = ?, description = ?, image_path = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $price, $description, $image_path, $id]);

        header("Location: ../admin_dashboard.php?success=updated");
        exit();
    } catch (PDOException $e) {
        die("Chyba databáze: " . $e->getMessage());
    }
}

// УДАЛЕНИЕ БЛЮДА
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $isAjax = isset($_GET['ajax']); // Проверяем, пришел ли флаг из JavaScript

    try {
        // Сначала находим путь к картинке, чтобы удалить файл с сервера
        $query = "SELECT image_path FROM menu_items WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$id]);
        $dish = $stmt->fetch();

        if ($dish && !empty($dish['image_path'])) {
            $full_path = "../../" . $dish['image_path'];
            if (file_exists($full_path)) {
                unlink($full_path); // Удаляем физический файл
            }
        }

        // Потом удаляем запись из базы
        $delete_query = "DELETE FROM menu_items WHERE id = ?";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->execute([$id]);

        // ЛОГИКА ОТВЕТА
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
            exit();
        } else {
            header("Location: ../admin_dashboard.php?success=deleted");
            exit();
        }
    } catch (PDOException $e) {
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            exit();
        }
        die("Chyba při mazání: " . $e->getMessage());
    }
}
