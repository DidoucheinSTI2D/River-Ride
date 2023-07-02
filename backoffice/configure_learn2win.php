<?php
require '../BDD/config.php';
session_start();

if (!isset($_SESSION['id_Utilisateur'])){
    header("location: ../connect.php?error=notconnected");
    exit;
}

if ($_SESSION['droits'] !== 'admin') {
    header("Location: ../profil.php?error=notadmin");
    exit();
}

$error = "";
$success = "";

if (isset($_POST['add_course'])) {
    $courseContent = $_POST['course_content'];
    $adminId = $_SESSION['id_Utilisateur'];

    $query = $bdd->prepare("INSERT INTO learntowin_cours (contenu, Utilisateur_id_Utilisateur) VALUES (:content, :adminId)");
    $query->bindParam(':content', $courseContent);
    $query->bindParam(':adminId', $adminId);

    if ($query->execute()) {
        $success = "Le cours a été ajouté avec succès.";
    } else {
        $error = "Une erreur s'est produite lors de l'ajout du cours.";
    }
}

if (isset($_POST['add_reward'])) {
    $rewardName = $_POST['reward_name'];

    $query = $bdd->prepare("INSERT INTO token (id_token) VALUES (:rewardName)");
    $query->bindParam(':rewardName', $rewardName);

    if ($query->execute()) {
        $success = "La récompense a été ajoutée avec succès.";
    } else {
        $error = "Une erreur s'est produite lors de l'ajout de la récompense.";
    }
}

if (isset($_POST['add_quiz'])) {
    $quizQuestion = $_POST['quiz_question'];
    $courseId = $_POST['course_id'];

    $query = $bdd->prepare("INSERT INTO quizz (Questions, LearTOWin_Cours_idLearnToWin_Cours) VALUES (:question, :courseId)");
    $query->bindParam(':question', $quizQuestion);
    $query->bindParam(':courseId', $courseId);

    if ($query->execute()) {
        $success = "Le quizz a été ajouté avec succès.";
    } else {
        $error = "Une erreur s'est produite lors de l'ajout du quizz.";
    }
}

if (isset($_POST['add_quiz_answer'])) {
    $quizId = $_POST['quiz_id'];
    $answer = $_POST['answer'];

    $query = $bdd->prepare("INSERT INTO reponse (Reponse, Quizz_idQuizz) VALUES (:answer, :quizId)");
    $query->bindParam(':answer', $answer);
    $query->bindParam(':quizId', $quizId);

    if ($query->execute()) {
        $success = "La réponse du quizz a été ajoutée avec succès.";
    } else {
        $error = "Une erreur s'est produite lors de l'ajout de la réponse du quizz.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <title>Configure Learn2Win</title>
</head>
<body>
<h1>Configure Learn2Win</h1>

<?php if (!empty($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>

<?php if (!empty($success)) { ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php } ?>

<h2>Ajouter un cours :</h2>
<form method="post" action="configure_learn2win.php">
    <label for="course_content">Contenu du cours :</label><br>
    <textarea name="course_content" id="course_content" required></textarea><br>
    <input type="submit" name="add_course" value="Ajouter le cours">
</form>

<h2>Ajouter une récompense :</h2>
<form method="post" action="configure_learn2win.php">
    <label for="reward_name">Nombre de Supercoin :</label>
    <input type="text" name="reward_name" id="reward_name" required pattern="[0-9]+" title="Veuillez entrer un nombre">
    <input type="submit" name="add_reward" value="Ajouter la récompense">
</form>

<h2>Ajouter un quizz :</h2>
<form method="post" action="configure_learn2win.php">
    <label for="quiz_question">Question :</label><br>
    <textarea name="quiz_question" id="quiz_question" required></textarea><br>
    <label for="course_id">ID du cours associé :</label>
    <input type="text" name="course_id" id="course_id" required>
    <input type="submit" name="add_quiz" value="Ajouter le quizz">
</form>

<h2>Ajouter une réponse pour un quizz :</h2>
<form method="post" action="configure_learn2win.php">
    <label for="quiz_id">ID du quizz :</label>
    <input type="text" name="quiz_id" id="quiz_id" required>
    <label for="answer">Réponse :</label>
    <input type="text" name="answer" id="answer" required>
    <input type="submit" name="add_quiz_answer" value="Ajouter la réponse">
</form>
</body>
</html>
