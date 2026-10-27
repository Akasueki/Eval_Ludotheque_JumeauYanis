<?php

session_start();

$message = '';

if(isset($_POST['submit'])){
    
    if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email'])
    && !empty($_POST['mot_de_passe']) && !empty($_POST['confirme_mdp'])){

        if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){

            if(mb_strlen($_POST['mot_de_passe'], 'UTF-8')>=12 && mb_strlen($_POST['confirme_mdp'], 'UTF-8')>=12
            && ($_POST['mot_de_passe'] === $_POST['confirme_mdp'])){
                    
                    $prenom = trim($_POST['prenom']);
                    $nom = trim($_POST['nom']);
                    $email = trim($_POST['email']);

                    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

                    try{
                        $pdo = new PDO('mysql:host=localhost;dbname=ludotheque', 'root', 'root',[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

                        $request = $pdo->prepare('SELECT m.prenom, m.nom, m.email FROM membres m WHERE m.email = ?');

                        $request->bindParam(1,$email,PDO::PARAM_STR);

                        $request->execute();

                        $data = $request->fetch(PDO::FETCH_ASSOC);

                        if(empty($data)){
                            $request = $pdo->prepare('INSERT INTO membres (prenom, nom, email, `mot_de_passe`) VALUES(?, ?, ?, ?)');

                            $request->bindParam(1,$prenom,PDO::PARAM_STR);
                            $request->bindParam(2,$nom,PDO::PARAM_STR);
                            $request->bindParam(3,$email,PDO::PARAM_STR);
                            $request->bindParam(4,$mot_de_passe,PDO::PARAM_STR);

                            $request->execute();
                            
                            $message = "Le membre a été enregistré : {$prenom} {$nom} - {$email}";

                        }else{
                            $message = "Cette email est déjà utilisé par un autre compte.";
                        }

                    }catch(EXCEPTION $error){
                        die($error->getMessage());
                    }

            }else{
                $message = "Votre mot de passe doit faire au moins 12 caractères.";
            }

        }else{
            $message = "Votre email n'est pas au bon format.";
        }

    }else{
        $message = "Veuillez remplir tous les champs du formulaire.";
    }
}

include('includes/header.php')

?>

<section>
    <h2>Inscription</h2>
        <form action="" method="post">
            <label for="prenom">Prenom <input type="text" name="prenom" id="prenom"></label>
            <label for="nom">Nom <input type="text" name="nom" id="nom"></label>
            <label for="email">Email <input type="text" name="email" id="email"></label>
            <label for="mot_de_passe">Mot de Passe <input type="password" name="mot_de_passe" id="mot_de_passe"></label>
            <label for="confirme_mdp">Confirmation du mot de passe <input type="password" name="confirme_mdp" id="confirme_mdp"></label>
            <input type="submit" name="submit">
        </form>
        <p>
            <?php echo($message) ?>
        </p>
</section>

<?php include('includes/footer.php') ?>