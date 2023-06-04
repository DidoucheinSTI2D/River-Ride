<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mastertheweb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = $_POST['e-mail'];
    $password = $_POST['Mot_de_passe'];

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE `e-mail` = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $hashedPassword = $user['Mot_de_passe'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['email'] = $user['e-mail'];
            $_SESSION['droits'] = $user['Droits'];

            if ($user['Droits'] === 'admin') {
                header("Location: ./backoffice.php");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Mot de passe incorrect";
            header("Location: ../connect.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Identifiants incorrects";
        header("Location: ../connect.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
