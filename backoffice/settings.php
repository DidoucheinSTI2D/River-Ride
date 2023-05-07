<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LeSuperCoin">
    <title>SuperBackOffice</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <?php
    $servername = "localhost"; // Nom du serveur où se trouve la base de données
    $username = "root"; // Nom d'utilisateur pour accéder à la base de données
    $password = ""; // Mot de passe pour accéder à la base de données
    $dbname = "mastertheweb"; // Nom de la base de données
    
    // Crée une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    function checkAdminAccess() {
      // Vérifier si l'utilisateur est connecté
      if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
        exit();
      }
      
      // Vérifier si l'utilisateur a le droit admin
      if ($_SESSION['Droits'] !== 'admin') {
        header("Location: reject.php");
        exit();
      }
    }
    ?>
</head>
<body>
    <div class="header d-flex">
        <img src="../img/badge/staffbadge.png" alt="logo SuperCoin" id="logo"/>
        <div class="user-info">
            <img src="../img/picture/pp.png" alt="Photo de profil" class="profile-picture" id="pp"/>
            <div class="username mt-2 col-md-3 ">
            <?php 
            session_start();
            if (!isset($_SESSION['Pseudo'])) {
                $_SESSION['Pseudo'] = "root";
            }
            echo $_SESSION['Pseudo'];
            ?>
            </div>
            <button class="logout-button">Déconnexion</button>
        </div>
    </div>
    <div class="container">
        <div class="column-left" id="left">
            <h2>Menu</h2>
            <ul>
                <li><a href="../connect.php">Accueil</a></li>
                <li><a href="./backoffice.php">BackOffice</a></li>
                <li><a href="./user.php">Utilisateurs</a></li>
                <li><a href="./topic.php">Topics</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>SuperBackOffice 1.0</h1>
            <div class="tab">
            <script>
                function Tab(evt, tabName) {
                var count, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (count = 0; count < tabcontent.length; count++) {
                    tabcontent[count].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (count = 0; count < tablinks.length; count++) {
                    tablinks[count].className = tablinks[count].className.replace(" active", "");
                }
                document.getElementById(tabName).style.display = "block";
                evt.currentTarget.className += " active";
                }
            </script>
            <button class="tablinks" onclick="Tab(event, 'Réglages')">Réglages</button>
            <button class="tablinks" onclick="Tab(event, 'Préférences')">Préférences</button>
            <button class="tablinks" onclick="Tab(event, 'Avancé')">Avancé</button>
            <div id="Réglages" class="tabcontent">
                <h3>Utilisateurs</h3>
                <p>Contenu de l'onglet Utilisateurs.</p>
            </div>
            <div id="Préférences" class="tabcontent">
                <h3>Préférences</h3>
                <p>Contenu de l'onglet Préférences.</p>
            </div>
            <div id="Avancé" class="tabcontent">
                <h3>Avancé</h3>
                <p>Contenu des paramètres Avancés.</p>
            </div>     
            </div>
            <h1>Paramètres</h1>
            <fieldset>
                <legend>Vos réglages:</legend>
                <div>
                    <input type="checkbox" id="blackmode" name="blackmode" checked>
                    <label for="blackmode">Mode nuit</label>
                </div>
                <div>
                    <input type="checkbox" id="test" name="test">
                    <label for="test">test</label>
                </div>
                <div>
                    <input type="checkbox" id="xxx" name="xxx">
                    <label for="xxx">xxx</label>
                </div>                <div>
                    <input type="checkbox" id="yyy" name="yyy">
                    <label for="yyy">yyy</label>
                </div>                <div>
                    <input type="checkbox" id="zzz" name="zzz">
                    <label for="zzz">zzz</label>
                </div>
            </fieldset>
        </div>
    </div>
</body>
</html>