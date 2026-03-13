<?php
// Connexion au service "db"
$host = 'db';
$db   = 'concession_db';
$user = 'sio_user';
$pass = 'password123';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer tous les véhicules disponibles
$sql_list = "SELECT id, marque, modele, annee FROM voitures ORDER BY marque, modele";
$result_list = $conn->query($sql_list);

// Injection possible via la variable $_GET['id']
$id = isset($_GET['id']) ? $_GET['id'] : 1;

$sql = "SELECT marque, modele, annee FROM voitures WHERE id = " . $id;
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>TP Cybersécurité - BTS SIO - Concession Automobile</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h1>Concession Automobile</h1>

        <div class="card">
            <div class="section-title">Sélectionnez un véhicule</div>

            <form method="GET" class="menu-form">
                <select name="id" onchange="this.form.submit();">
                    <option value="">-- Choisir un véhicule --</option>
                    <?php if ($result_list && $result_list->num_rows > 0): ?>
                        <?php while ($row = $result_list->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>" <?= (isset($_GET['id']) && $_GET['id'] == $row['id']) ? 'selected' : '' ?>>
                                <?= $row['marque'] ?> <?= $row['modele'] ?> (<?= $row['annee'] ?>)
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </form>

            <div class="section-title">Véhicules disponibles</div>
            <div class="vehicle-cards">
                <?php
                // Réinitialiser le pointeur de résultat
                $result_list->data_seek(0);
                if ($result_list && $result_list->num_rows > 0):
                ?>
                    <?php while ($row = $result_list->fetch_assoc()): ?>
                        <a href="?id=<?= $row['id'] ?>" style="text-decoration: none;">
                            <div class="vehicle-button <?= (isset($_GET['id']) && $_GET['id'] == $row['id']) ? 'active' : '' ?>">
                                <div class="vehicle-info">
                                    <div class="brand"><?= htmlspecialchars($row['marque']) ?></div>
                                    <div class="model"><?= htmlspecialchars($row['modele']) ?></div>
                                    <div class="year"><?= $row['annee'] ?></div>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="details-card">
                <h2>Détails du véhicule sélectionné</h2>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="detail">
                        <label>Marque :</label>
                        <span><?= htmlspecialchars($row['marque']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Modèle :</label>
                        <span><?= htmlspecialchars($row['modele']) ?></span>
                    </div>
                    <div class="detail">
                        <label>Année :</label>
                        <span><?= $row['annee'] ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="info">
                Sélectionnez un véhicule pour voir ses détails.
            </div>
        <?php endif; ?>

        <div class="card" style="margin-top: 20px;">
            <div class="section-title">Requête SQL exécutée</div>
            <div class="sql-section">
                <div class="sql-label">SQL Query:</div>
                <code><?= htmlspecialchars($sql) ?></code>
            </div>
            <div class="warning">
                ⚠️ <strong>ATTENTION :</strong> Cette application est intentionnellement vulnérable aux injections SQL pour des fins éducatives.
                Utilisez-la uniquement dans un environnement de formation contrôlé !
            </div>
        </div>
    </div>
</body>

</html>