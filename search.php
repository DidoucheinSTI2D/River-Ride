<?php
    session_start();
    require "./BDD/config.php";
    require "./LeSuPerisien/fonctions.php";


    function getAuthor ($idUtilisateur) {
        require('BDD/config.php');
            $req = $bdd->prepare('SELECT Pseudo FROM utilisateur WHERE id_Utilisateur = ?');
            $req->execute([$idUtilisateur]);
            $resultat = $req->fetch();
    
            if ($resultat) {
                return $resultat['Pseudo'];
            }
        }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <title>Moteur de recherche</title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">    
    <div class="container py-4">
    <h1> Recherche de contenu </h1>
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <h4> Tapez titre </h4>
        <div class="input-group mb-4 mt-3">
            <div class="form-outline">
                <input type="text" id="getTitle"/>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Titre</th>
                    <th>Rédacteur</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody id="showdata">
                <?php
                    $journals = getJournals();
                    $Topics = getTopics();
                    foreach(($journals) as $journal) : 
                        echo"<tr>";
                            echo"<td><h6>". $journal->id_Journal ."</h6></td>";
                            echo"<td><h6>". $journal->Titre ."</h6></td>";
                            echo"<td><h6>". $journal->Rédacteur ."</h6></td>";
                            echo"<td><h6> Journal </h6></td>";
                        echo"</tr>";
                    endforeach;
                    foreach(($Topics) as $Topic) :
                        $idUtilisateur = $Topic->Utilisateur_id_Utilisateur;
                        $pseudo = getAuthor($idUtilisateur);
                        echo"<tr>";
                            echo"<td><h6>". $Topic->id_Topic ."</h6></td>";
                            echo"<td><h6>". $Topic->titre ."</h6></td>";
                            echo"<td><h6>". $pseudo ."</h6></td>";
                            echo"<td><h6> Topic </h6></td>";
                        echo"</tr>";
                    endforeach;
                ?>
            </tbody>
        </table>    
    </div>
    </div>

    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
    <script>
  $(document).ready(function(){
   $('#getTitle').on("keyup", function(){
     var getTitle = $(this).val();
     $.ajax({
       method:'POST',
       url:'./searchajax.php',
       data:{title:getTitle},
       success:function(response)
       {
            $("#showdata").html(response);
       },
       error: function(xhr, status, error) {
            console.log("Erreur :", error); // Afficher l'erreur dans la console du navigateur (pour le débogage)
       }
     });
   });
  });
</script>

</body>
</html>