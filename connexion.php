<?php

session_start();

$message = '';

if( isset($_POST['submit'])){

    if(!empty($_POST['email']) && !empty($_POST['mot_de_passe'])){

        $email = trim($_POST['email']);
        $mot_de_passe = $_POST['mot_de_passe'];

        try{
            $pdo = new PDO ('mysql:host=localhost;dbname=ludotheque', 'root', 'root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

            $request = $pdo-> prepare('SELECT m.id_membre, m.prenom, m.nom, m.email, m.mot_de_passe FROM membres m WHERE email = ?');

            $request->execture([$email]);

            $membre = $request->fetch(PDO::FETCH_ASSOC);

            if($membre && password_verify($mot_de_passe, $membre['mot_de_passe'])){

                $_SESSION['id'] = $membre['id_membre'];
                $_SESSION['prenom'] = $membre['prenom'];
                $_SESSION['nom'] = $membre['nom'];
                $_SESSION['email'] = $membre['email'];

            }else{
                $message = "Email et/ou mot de passe incorrect";
            }
        }catch(EXCEPTION $error){
            die($error->getMessage());
        }
    }
}

include('includes/header.php') ?>

<section>
    <h2>Connexion</h2>
        <form action="" method="post">
            <input type="text" name="login">
            <input type="text" name="password">
            <input type="submit" name="submit">
        </form>
    <p><?php echo($message) ?></p>
</section>

<?php include('includes/footer.php') ?>