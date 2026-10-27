<?php 

try{
    $pdo = new PDO('mysql:host=localhost;dbname=ludotheque;charset=utf8mb4','root','root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    $request = $pdo->prepare('SELECT j.titre, j.joueurs_min, j.joueurs_max, j.duree, c.nom_categorie AS categorie, m.prenom
    FROM jeux j
    JOIN categorie c ON j.id_categorie = c.id_categorie
    JOIN membres m ON j.id_membre = m.id_membre
    ORDER BY j.titre')

    $jeux = $request->fetchAll(PDO::FETCH_ASSOC);

}catch(EXCEPTION $error){
    die("Erreur")
}

include('includes/header.php')
?>

<main>
    <h1>Liste des jeux</h1>

    <article>
    <?php foreach($jeux as $jeu): ?>
        <h2><? = htmlspecialchars($jeu['titre']) ?></h2>

        <p>Catégorie :<? = htmlspecialchars($jeu['categorie']) ?></p>

        <p>Nombres de joueurs :<? = htmlspecialchars(formatJoueurs(int) $jeu['joueurs_min'], (int) $jeu['joueurs_max']) ?></p>

        <p>Durée :<? = htmlspecialchars(int) $jeu['duree'] ?> minutes (<?= htmlspecialchars(categorieDuree((int) $jeu['duree'])) ?>)</p>

        <p><? = htmlspecialchars($jeu['categorie']) ?></p>

        <p>Ajouté par :<? = htmlspecialchars($jeu['prenom']) ?></p>
        </article>
    <?php endforeach; ?>
</main>

<?php include('includes/footer.php') ?>