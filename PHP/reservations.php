<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezervace stolu | Restaurace Li Chun</title>
    <link rel="stylesheet" href="../CSS/reservations.css">
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="res-container">
        <form action="includes/reservation_handler.php" method="POST" class="res-form">
            <h1 class="res-title">Rezervovat stůl</h1>
            <p class="res-subtitle">Vyplňte formulář</p>

            <?php
            $error_messages = [
                'invalid_phone' => '❌ Neplatný formát telefonního čísla.',
                'invalid_guests' => '❌ Počet hostů musí být mezi 1 a 30.',
                'date_in_past' => '❌ Datum nemůže být v minulosti.',
                'date_too_far' => '❌ Rezervace je možná maximálně na rok dopředu.',
                'invalid_time' => '❌ Rezervace přijímáme pouze mezi 11:00 a 21:00.',
                'empty_fields' => '❌ Vyplňte prosím všechna povinná pole.',
                'invalid_data' => '❌ Zadaná data jsou neplatná.'
            ];

            if (isset($_GET['success'])): ?>
                <div class="alert alert-success">✅ Rezervace byla úspěšně odeslána!</div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && isset($error_messages[$_GET['error']])): ?>
                <div class="alert alert-danger" style="color: #d32f2f; background: #ffebee; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo $error_messages[$_GET['error']]; ?>
                </div>
            <?php endif; ?>

            <div class="res-grid">
                <div class="input-group">
                    <label>Jméno a příjmení</label>
                    <input type="text" name="name" placeholder="Jan Novák" required>
                </div>

                <div class="input-group">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="jan@example.cz" required>
                </div>

                <div class="input-group">
                    <label>Telefon</label>
                    <input type="tel" name="phone" placeholder="+420 123 456 789" pattern="^[+]?[0-9\s]{9,15}$">
                </div>

                <div class="input-group">
                    <label>Počet osob</label>
                    <input type="number" name="guests" min="1" max="30" value="2" required>
                </div>

                <div class="input-group">
                    <label>Datum</label>
                    <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="input-group">
                    <label>Čas (11:00 - 21:00)</label>
                    <input type="time" name="time" required>
                </div>
            </div>

            <div class="input-group full-width">
                <label>Poznámka (alergie, speciální přání)</label>
                <textarea name="notes" rows="3"></textarea>
            </div>

            <button type="submit" name="submit_res" class="res-button">Odeslat rezervaci</button>
            <a href="../HTML/restaurant-LiChun-project.php" class="res-back">← Zpět na hlavní stránku</a>
        </form>
    </div>

    <script>
        document.querySelector('.res-form').addEventListener('submit', function(e) {
            const dateInput = document.querySelector('input[name="date"]');
            const guestsInput = document.querySelector('input[name="guests"]');
            const timeInput = document.querySelector('input[name="time"]');

            const selectedDate = new Date(dateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);

            let errorMessage = "";

            // 1. Kontrola data
            if (selectedDate < today) {
                errorMessage = "Datum nemůže být v minulosti.";
            } else if (selectedDate > maxDate) {
                errorMessage = "Rezervace je možná maximálně na rok dopředu.";
            }
            // 2. Kontrola hostů
            else if (guestsInput.value < 1 || guestsInput.value > 30) {
                errorMessage = "Počet hostů musí být mezi 1 a 30.";
            }
            // 3. Kontrola času (11:00 - 21:00)
            else if (timeInput.value) {
                const hour = parseInt(timeInput.value.split(':')[0]);
                if (hour < 11 || hour >= 21) {
                    errorMessage = "Rezervace přijímáme pouze mezi 11:00 a 21:00.";
                }
            }

            if (errorMessage) {
                e.preventDefault();
                alert(errorMessage);
                dateInput.style.borderColor = "red";
            }
        });
    </script>
</body>

</html>