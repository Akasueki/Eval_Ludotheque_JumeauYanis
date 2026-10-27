<?php
session_start();

if(!isset($_SESSION['id'])){
    header('Location: connexion.php');
    exit;
}

$message = '';

try{
    $pdo = new PDO('mysql:host=localhost;dbname=ludotheque;charset=utf8mb4','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $request = $pdo->prepare('SELECT id_categorie, c.nom_categorie FROM  categorie');

    $request->execute();

    $categorie = $request->fetchAll(PDO::FETCH_ASSOC);

}catch(EXCEPTION $error){
    die("Erreur")
}

include('includes/header.php') 
?>

<section>

    <h2>Ajouter un jeu</h2>

    <form action="" method="post">

        <label for="titre">Titre du jeu</label>

        <input type="text" name="titre" id="titre" required>

        <label for="joueurs_min">Nombre minimum de joueurs</label>

        <input type="number" name="joueurs_min"
               id="joueurs_min" min="1" required>

        <label for="joueurs_max">Nombre maximum de joueurs</label>

        <input type="number" name="joueurs_max"
               id="joueurs_max" min="1" required>

        <label for="duree">Durée d'une partie (en minutes)</label>

        <input type="number" name="duree"
               id="duree" min="1" required>

        <label for="id_categorie">Catégorie</label>

        <select name="id_categorie" id="id_categorie" required>
            <option value="">-- Choisir une catégorie --</option>

            <?php foreach ($categories as $categorie): ?>

                <option value="<?= (int) $categorie['id_categorie'] ?>">
                    <?= htmlspecialchars($categorie['nom'], ENT_QUOTES, 'UTF-8') ?>
                </option>

            <?php endforeach; ?>

        </select>
        <input type="submit" name="submit" value="Ajouter le jeu">
    </form>
    <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
</section>

<?php include 'includes/footer.php'; ?>