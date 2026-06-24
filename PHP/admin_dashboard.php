<?php
session_start();
// Проверка авторизации
if (!isset($_SESSION['admin_logged_in'])) {
  header("Location: admin.php");
  exit();
}

require_once "includes/dhp.inc.php";
/** @var PDO $pdo */

// Загрузка raw data
try {
  $all_dishes = $pdo->query("SELECT * FROM menu_items ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
  $reservations = $pdo->query("SELECT * FROM reservations ORDER BY reservation_date DESC, reservation_time DESC")->fetchAll(PDO::FETCH_ASSOC);
  $reviews = $pdo->query("SELECT * FROM reviews ORDER BY FIELD(status, 'New', 'Approved', 'Rejected'), created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Ошибки при чтении БД: " . $e->getMessage());
}

$news_list = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8" />
  <title>Administrace Restaurace</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../CSS/admin_dashboard.css" />
</head>

<body>
  <h1>Administrace Restaurace</h1>

  <section>
    <a href="../HTML/restaurant-LiChun-project.php">Zpět na hlavní stránku</a>
  </section>

  <section>
    <h2>Správa Menu</h2>
    <form action="includes/menu_handler.php" method="POST" enctype="multipart/form-data">
      <label for="dish_name">Název:</label>
      <input type="text" id="dish_name" name="name" required />

      <label for="dish_price">Cena:</label>
      <input type="number" id="dish_price" name="price" step="0.01" min="0" required />

      <label for="dish_category">Kategorie:</label>
      <select id="dish_category" name="category" required>
        <option value="soups">Polévky</option>
        <option value="main">Hlavní jídla</option>
        <option value="desserts">Dezerty</option>
        <option value="drinks">Nápoje</option>
      </select>

      <label for="dish_allergens">Alergeny:</label>
      <input type="text" id="dish_allergens" name="allergens" />

      <label>Obrázek:</label>
      <input type="file" name="dish_image" accept="image/*" required>

      <label for="dish_description">Popis:</label><br />
      <textarea id="dish_description" name="description" rows="4"></textarea><br /><br />

      <button type="submit" name="action" value="add">Přidat Nové Jídlo</button>
    </form>
  </section>

  <hr />

  <section>
    <h2>Aktuální Rezervace</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Datum/Čas</th>
          <th>Hosté</th>
          <th>Jméno</th>
          <th>Telefon</th>
          <th>Kontakt (Email)</th>
          <th>Poznámka</th>
          <th>Status</th>
          <th>Akce</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservations as $res) : ?>
          <tr>
            <td><?php echo htmlspecialchars($res['id']); ?></td>
            <td><?php echo htmlspecialchars($res['reservation_date']) . ' / ' . htmlspecialchars($res['reservation_time']); ?></td>
            <td><?php echo htmlspecialchars($res['guests']); ?></td>
            <td><?php echo htmlspecialchars($res['name']); ?></td>

            <td><?php echo htmlspecialchars($res['phone']); ?></td>

            <td><?php echo htmlspecialchars($res['email']); ?></td>

            <td><?php echo htmlspecialchars($res['notes']); ?></td>

            <td><strong><?php echo htmlspecialchars($res['status']); ?></strong></td>
            <td>
              <form action="includes/reservation_status.php" method="POST">
                <input type="hidden" name="res_id" value="<?php echo $res['id']; ?>">

                <select name="new_status">
                  <option value="New" <?php echo ($res['status'] === 'New') ? 'selected' : ''; ?>>New</option>
                  <option value="Confirmed" <?php echo ($res['status'] === 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                  <option value="Cancelled" <?php echo ($res['status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>

                <button type="submit" name="action" value="update_status">Uložit</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

  <hr />

  <section class="admin-section">
    <h2 class="admin-title">Správa aktuálního menu</h2>
    <table class="admin-table">
      <thead>
        <tr>
          <th>Foto</th>
          <th>Název</th>
          <th>Cena</th>
          <th>Akce</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($all_dishes as $dish): ?>
          <tr>
            <td><img src="../<?php echo htmlspecialchars($dish['image_path']); ?>" width="60" height="60"></td>
            <td><strong><?php echo htmlspecialchars($dish['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($dish['price']); ?> Kč</td>
            <td>
              <a href="edit_dish.php?id=<?php echo (int)$dish['id']; ?>">Upravit</a> |
              <a href="includes/menu_handler.php?action=delete&id=<?php echo (int)$dish['id']; ?>"
                class="ajax-delete"
                style="color:red;"
                onclick="return confirm('Opravdu smazat?')">Smazat</a>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

  <hr />
  <hr />

  <section>
    <h2>Moderace Recenzí (Hodnocení)</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Hodnocení</th>
          <th>Autor</th>
          <th>Komentář</th>
          <th>Datum</th>
          <th>Status</th>
          <th>Akce</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reviews as $review) : ?>
          <tr>
            <td><?php echo htmlspecialchars($review['id']); ?></td>
            <td><?php echo htmlspecialchars($review['rating']); ?> ⭐</td>
            <td><?php echo htmlspecialchars($review['author_name']); ?></td>
            <td><?php echo htmlspecialchars($review['comment']); ?></td>
            <td><?php echo date("Y-m-d H:i", strtotime($review['created_at'])); ?></td>
            <td><?php echo htmlspecialchars($review['status']); ?></td>
            <td>
              <form action="includes/review_handler.php" method="POST">
                <input type="hidden" name="review_id" value="<?php echo (int)$review['id']; ?>">
                <select name="new_status">
                  <option value="New" <?php echo ($review['status'] === 'New') ? 'selected' : ''; ?>>New</option>
                  <option value="Approved" <?php echo ($review['status'] === 'Approved') ? 'selected' : ''; ?>>Approved</option>
                  <option value="Rejected" <?php echo ($review['status'] === 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                </select>
                <button type="submit" name="action" value="update_status">Změnit Status</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($reviews)) : ?>
          <tr>
            <td colspan="7">Žádné recenze k moderaci.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </section>
  <hr />

  <section>
    <h2>Správa Novinek</h2>
    <form action="includes/news_handler.php" method="POST">
      <label for="news_title">Titulek novinky:</label>
      <input type="text" id="news_title" name="title" required />

      <label for="news_content">Obsah novinky:</label><br />
      <textarea id="news_content" name="content" rows="4" required></textarea><br /><br />

      <button type="submit" name="action" value="add_news">Přidat Novinku</button>
    </form>

    <br>
    <h3>Aktuální novinky</h3>
    <table>
      <thead>
        <tr>
          <th>Datum</th>
          <th>Titulek</th>
          <th>Content</th>
          <th>Akce</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($news_list as $news) :
        ?>
          <tr>
            <td><?php echo date("d.m.Y", strtotime($news['created_at'])); ?></td>
            <td><?php echo htmlspecialchars($news['title']); ?></td>
            <td><?php echo nl2br(htmlspecialchars($news['content'])); ?></td>
            <td>
              <a href="includes/news_handler.php?action=delete&id=<?php echo $news['id']; ?>"
                class="ajax-delete"
                style="color:red;"
                onclick="return confirm('Smazat novinku?')">Smazat</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
  <div>
    <form action="includes/formhandler-test.inc.php" method="POST">
      <button type="submit">Odhlásit se</button>
    </form>
    <a class="change" href="change_password.php"><button class="change" type="submit">Zmenit heslo</button></a>
    </form>
  </div>
</body>

</html>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.ajax-delete').forEach(link => {
      link.addEventListener('click', function(e) {

        e.preventDefault(); // Останавливаем обычный переход по ссылке

        const url = this.getAttribute('href') + '&ajax=1'; // Добавляем флаг аякса к URL
        const row = this.closest('tr'); // Находим строку таблицы

        fetch(url)
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              // Анимация удаления
              row.style.transition = '0.5s';
              row.style.backgroundColor = '#ffebee';
              row.style.opacity = '0';
              setTimeout(() => row.remove(), 500);
            } else {
              // Если сервер вернул ошибку
              window.location.href = this.getAttribute('href');
            }
          })
          .catch(() => {
            // Если случилась ошибка сети
            window.location.href = this.getAttribute('href');
          });
      });
    });
  });
</script>