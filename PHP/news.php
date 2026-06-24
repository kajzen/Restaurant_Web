<?php
require_once "includes/dhp.inc.php";
/** @var PDO $pdo */ //
// Получаем новости
$query = "SELECT * FROM news ORDER BY created_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$all_news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Novinky | Li Chun</title>
    <link rel="stylesheet" href="../CSS/static_pages.css">
</head>

<body>
    <div class="container">
        <header class="static-header">
            <h1>Novinky</h1>
        </header>

        <main class="news-list">
            <?php if (empty($all_news)): ?>
                <p>Zatím žádné novinky.</p>
            <?php else: ?>
                <?php foreach ($all_news as $post): ?>
                    <article class="news-item">
                        <span class="date"><?php echo date("d.m.Y", strtotime($post['created_at'])); ?></span>
                        <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                        <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>

        <footer class="static-footer">
            <a href="../HTML/restaurant-LiChun-project.php" class="btn-back">← Zpět</a>
        </footer>
    </div>
</body>

</html>