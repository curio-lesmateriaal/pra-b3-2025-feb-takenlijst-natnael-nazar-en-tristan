<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login.php');
    exit;
}

require_once '../backend/conn.php';

// Voltooide taken ophalen
$query = "SELECT id, titel, beschrijving, afdeling, status, created_at FROM taken WHERE status = 'done'";
$stmt = $conn->prepare($query);
$stmt->execute();
$taken = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voltooide Taken</title>
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="taakbord.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js"></script>
</head>
<body>
    <header>
        <h1>Voltooide Taken</h1>
        <nav>
            <a href="index.php">Terug naar takenlijst</a>
            <a href="../app/http/Controllers/logoutController.php">Uitloggen</a>
        </nav>
    </header>

    <main>
        <div class="takenbord-container">
            <h2>Voltooide Taken</h2>
            <div id="takenbord" class="takenbord">
                <?php if (count($taken) > 0): ?>
                    <?php foreach ($taken as $taak): ?>
                        <div class="taak" data-id="<?= $taak['id'] ?>">
                            <h3><?= htmlspecialchars($taak['titel']) ?></h3>
                            <p><strong>Afdeling:</strong> <?= htmlspecialchars($taak['afdeling']) ?></p>
                            <p><strong>Status:</strong> <?= htmlspecialchars($taak['status']) ?></p>
                            <p><strong>Aangemaakt op:</strong> <?= htmlspecialchars($taak['created_at']) ?></p>
                            <p><?= nl2br(htmlspecialchars($taak['beschrijving'])) ?></p>
                            <button class="verwijder-knop" data-id="<?= $taak['id'] ?>">Verwijderen</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Er zijn geen voltooide taken.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        &copy; 2025 Developer Land Takenbord.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const takenbord = document.getElementById("takenbord");
            const drake = dragula([takenbord]);

            document.querySelectorAll(".verwijder-knop").forEach(button => {
                button.addEventListener("click", function() {
                    const taakId = this.dataset.id;
                    if (confirm("Weet je zeker dat je deze taak wilt verwijderen?")) {
                        fetch('../app/http/Controllers/deleteTaskController.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: 'id=' + taakId
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                this.parentElement.remove();
                            } else {
                                alert("Fout bij verwijderen!");
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
