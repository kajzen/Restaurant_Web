<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dokumentace - Restaurace Li Chun</title>
    <style>
        :root {
            --primary-red: #d32f2f;
            --dark-green: #015958;
            --bg-color: #f4f4f4;
            --card-bg: #ffffff;
            --code-bg: #f8f9fa;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            max-width: 950px;
            margin: 0 auto;
            padding: 40px 20px;
            color: #333;
        }

        .doc-container {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--primary-red);
            border-bottom: 3px solid var(--primary-red);
            padding-bottom: 10px;
            margin-bottom: 5px;
        }

        h2 {
            color: #222;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
            margin-top: 40px;
        }

        h3 {
            color: var(--dark-green);
            margin-top: 30px;
            background: #e0f2f1;
            padding: 10px;
            border-radius: 5px;
        }

        .roles {
            background: #f9f9f9;
            padding: 20px;
            border-left: 5px solid var(--primary-red);
            margin: 20px 0;
            border-radius: 4px;
        }

        /* Опрятные картинки */
        img {
            display: block;
            width: 100%;
            max-width: 800px;
            height: auto;
            margin: 20px auto;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Технические блоки кода */
        .code-description {
            background: var(--code-bg);
            padding: 20px;
            margin: 15px 0;
            border-left: 4px solid var(--dark-green);
            border-radius: 4px;
        }

        .code-description h4 {
            margin-top: 0;
            color: var(--dark-green);
            font-size: 1.1em;
        }

        code {
            background: #eee;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
        }

        ul {
            margin-bottom: 20px;
        }

        li {
            margin-bottom: 5px;
        }

        .back-link {
            text-decoration: none;
            color: var(--primary-red);
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="doc-container">
        <h1>Dokumentace semestrální práce (ZWA)</h1>
        <p><strong>Autor:</strong> Sydorov Mykhailo</p>
        <p><strong>Projekt:</strong> Webová stránka čínské restaurace LiChun</p>

        <h2>Krátký popis:</h2>
        <p>
            Jedná se o jednoduchou webovou aplikaci pro reálný malý podnik. Uživatelé budou moci prohlížet menu s fotografiemi jídel, rezervovat stůl a přidávat recenze. Administrátor bude mít jednoduchou administrační část pro CRUD položek menu, správu rezervací a moderaci recenzí.
        </p>

        <h3>Plánovaná funkčnost:</h3>
        <ul>
            <li>Zobrazení menu s fotografiemi a informacemi o alergenech</li>
            <li>Formulář pro rezervaci stolů (uložení do DB)</li>
            <li>Systém recenzí (vložit/číst)</li>
            <li>Administrace (přihlášení admina, CRUD pro jídla, rezervace, recenze, novinky)</li>
        </ul>

        <h2>Technologie</h2>
        <ul>
            <li><strong>Frontend:</strong> HTML5, CSS3, JavaScript (validace formulářů, AJAX/Fetch API).</li>
            <li><strong>Backend:</strong> PHP 8.x (zpracování formulářů, správa session, PDO).</li>
            <li><strong>Databáze:</strong> MySQL (PDO pro bezpečné dotazy).</li>
        </ul>

        <h2>Databázové schéma</h2>
        <p>Systém využívá 5 hlavních tabulek:</p>
        <ul>
            <li><code>menu_items</code> - skladování informací o pokrmech.</li>
            <li><code>reservations</code> - záznamy o rezervacích od klientů.</li>
            <li><code>reviews</code> - uživatelské recenze a jejich stavy (New, Approved, Rejected).</li>
            <li><code>news</code> - aktuality z restaurace.</li>
            <li><code>admin</code> - Obsahuje přihlašovací údaje pro administrátora (id, username, password).</li>
        </ul>

        <div class="roles">
            <p><strong>Návštěvník:</strong> Může prohlížet menu, novinky, odesílat rezervace a psát recenze (které se zobrazí až po schválení).</p>
        </div>

        <h2>Uživatelská příručka</h2>

        <section class="doc-item">
            <h3>Hlavní stránka webu</h3>
            <p>
                Hlavní stránka obsahuje navigační menu, logo restaurace a interaktivní prvky. Střední část tvoří dynamický slider s recenzemi zákazníků. Spodní sekce zobrazuje aktuální nabídku jídelníčku generovanou z databáze, kde každá položka obsahuje fotografii, název, popis a cenu.
            </p>
            <img src="../images/doc/pic_main.jpg" alt="Hlavní stránka webu LiChun">
        </section>

        <section class="doc-item">
            <h3>Rezervační systém</h3>
            <p>
                Uživatelský formulář pro odesílání rezervací. Data jsou validována na straně klienta i serveru a následně uložena do databáze pro zpracování administrátorem. Při zadání neplatných údajů do rezervačního formuláře se zobrazí upozornění na každou konkrétní chybu.
            </p>
            <img src="../images/doc/rezervation.png" alt="Rezervační formulář">
        </section>

        <section class="doc-item">
            <h3>Recenze a hodnocení</h3>
            <p>
                Uživatelé mohou přidávat recenze, které se na webu zobrazí až po schválení administrátorem. Přímo pod formulářem se zobrazují již schválené recenze od uživatelů. Systém využívá funkci filtrace podle počtu hvězdiček a obsahuje stránkování (paginaci) pro přehlednější zobrazení velkého množství dat.
            </p>
            <img src="../images/doc/rewiev.png" alt="Formulář pro recenze">
            <img src="../images/doc/rewiev1.png" alt="Zobrazení recenzí s paginací">
        </section>

        <section class="doc-item">
            <h3>Detail jídla (dish.php)</h3>
            <p>
                Aplikace podporuje dynamické zobrazení detailu konkrétního jídla. Po kliknutí na název pokrmu v menu se otevře stránka <strong>dish.php</strong>, která pomocí parametru ID v URL adrese načte konkrétní data z databáze.
            </p>
            <img src="../images/doc/dish.png" alt="Detail pokrmu">
        </section>

        <h2>Administrace (Admin Panel)</h2>

        <section class="doc-item">
            <h3>Stránka přihlášení admina</h3>
            <p>
                Stránka slouží k autentizaci správce webu. Přístup do administračního panelu je chráněn heslem, které je v databázi uloženo v hashované podobě. Po úspěšném přihlášení je vytvořena uživatelská relace (session).
            </p>
            <img src="../images/doc/admin.png" alt="Přihlášení admina">
        </section>

        <section class="doc-item">
            <h3>Přidávání nových pokrmů</h3>
            <p>
                Prvním prvkem v administraci je funkce pro přidávání nových pokrmů do menu. Systém obsahuje bezpečnostní a logické validace: kontroluje, zda zadaná cena není záporná a zda nahrávaný soubor je ve správném formátu obrázku.
            </p>
            <img src="../images/doc/new_dish.png" alt="Přidání nového jídla">
        </section>

        <section class="doc-item">
            <h3>Správa rezervací</h3>
            <p>
                Tato sekce obsahuje tabulku se všemi odeslanými požadavky na rezervaci stolů. Administrátor má možnost sledovat kontaktní údaje hostů a měnit status každé rezervace (např. "New", "Confirmed" nebo "Cancelled").
            </p>
            <img src="../images/doc/reservation_handler.png" alt="Správa rezervací">
        </section>

        <section class="doc-item">
            <h3>Správa menu a AJAX mazání</h3>
            <p>
                Tato sekce umožňuje administrátorovi kompletní kontrolu nad jídelním lístkem. Obsahuje funkci pro úpravu detailů již existujících pokrmů a také možnost jejich odstranění. Mazání je implementováno pomocí technologie <strong>AJAX</strong>, díky čemuž je položka z tabulky odstraněna plynule a bez nutnosti znovunačtení celé stránky.
            </p>
            <img src="../images/doc/menu_handler.png" alt="Správa menu">
        </section>

        <section class="doc-item">
            <h3>Editace pokrmů</h3>
            <p>
                Při kliknutí na tlačítko "Upravit" se otevře samostatná stránka, která je předvyplněna aktuálními daty z databáze. Administrátor zde může změnit název, cenu, popis nebo nahrát novou fotografii.
            </p>
            <img src="../images/doc/edit_dish.png" alt="Editace jídla">
        </section>

        <section class="doc-item">
            <h3>Moderace uživatelských recenzí</h3>
            <p>
                Slouží k filtrování a schvalování zpětné vazby. Všechny nové recenze mají výchozí status "New" a nejsou viditelné na webu. Administrátor může každou recenzi schválit (Approved) nebo zamítnout (Rejected).
            </p>
            <img src="../images/doc/rewiev_handler.png" alt="Moderace recenzí">
        </section>

        <section class="doc-item">
            <h3>Zabezpečení a správa přístupu</h3>
            <p>
                Tlačítko pro odhlášení okamžitě ukončí aktivní relaci (session). Stránka pro změnu údajů umožňuje administrátorovi aktualizovat své heslo s logickou kontrolou shody polí (prevence překlepů).
            </p>
            <img src="../images/doc/buttons.png" alt="Tlačítka správy">
            <img src="../images/doc/admin_pwd.png" alt="Změna hesla">
        </section>

        <section class="doc-item">
            <h3>Správa novinek a AJAX mazání</h3>
            <p>
                Slouží k publikování aktuálních informací. Odstranění novinek je integrováno s technologií AJAX – po potvrzení smazání dojde k asynchronnímu požadavku a záznam zmizí bez restartu stránky.
            </p>
            <img src="../images/doc/news.png" alt="Správa novinek">
        </section>

        <h2>Klíčová technická řešení a logika kódu</h2>

        <div class="code-description">
            <h4>1. Práce s databází a bezpečnost (PDO)</h4>
            <p>Pro interakci s databází využívám knihovnu <strong>PDO</strong> s <em>prepared statements</em>. Tato metoda zcela eliminuje riziko <strong>SQL Injection</strong>.</p>
            <code>$stmt = $pdo->prepare($query); $stmt->execute([...]);</code>
        </div>

        <div class="code-description">
            <h4>2. Komplexní validace vstupních dat</h4>
            <ul>
                <li><strong>Kontrola cen:</strong> Logika zabraňuje uložení záporné ceny.</li>
                <li><strong>Ověření souborů:</strong> Funkce <code>getimagesize()</code> ověřuje integritu obrázků.</li>
                <li><strong>Rezervační logika:</strong> Kontrola otevírací doby (11:00 - 21:00) a ochrana proti rezervacím v minulosti.</li>
            </ul>
        </div>

        <div class="code-description">
            <h4>3. Asynchronní operace (AJAX & Fetch API)</h4>
            <p>Při mazání položek skript v JavaScriptu zachytí požadavek, odešle jej na pozadí a při úspěchu odstraní řádek tabulky pomocí CSS animace (opacity/remove).</p>
        </div>

        <div class="code-description">
            <h4>4. Zabezpečení přístupu (Session Management)</h4>
            <p>Kontrola <code>$_SESSION['admin_logged_in']</code> na začátku každého chráněného souboru zajišťuje, že neoprávněný uživatel bude přesměrován na login.</p>
        </div>

        <div class="code-description">
            <h4>5. Automatická správa souborů</h4>
            <p>Při smazání pokrmu se automaticky vyvolá funkce <code>unlink()</code>, která odstraní fyzický soubor obrázku ze serveru.</p>
        </div>

        <div class="code-description">
            <h4>6. Filtrace dat a stránkování (Paginace)</h4>
            <p>U recenzí je využita klauzule <code>LIMIT</code> a <code>OFFSET</code> přímo v SQL dotazech pro optimální výkon při velkém množství dat.</p>
        </div>

        <div class="code-description">
            <h4>7. Dynamické generování obsahu</h4>
            <p>Použití souboru <code>dish.php</code> s GET parametrem ID umožňuje zobrazení stovek produktů pomocí jediného šablonového souboru.</p>
        </div>

        <div class="code-description">
            <h4>8. Publikování novinek</h4>
            <p>Využití funkce <code>nl2br()</code> při výpisu zajišťuje, že formátování textu zadané adminem (zalomení řádků) zůstane zachováno i v HTML.</p>
        </div>

        <p style="margin-top: 50px; text-align: center;">
            <a href="../HTML/restaurant-LiChun-project.php" class="back-link">← Zpět na hlavní stránku</a>
        </p>
    </div>

</body>

</html>