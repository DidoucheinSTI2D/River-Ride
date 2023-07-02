<?php
require '../BDD/config.php';

if (isset($_POST['chat_id'])) {
    $chat_id = $_POST['chat_id'];

    $query = $bdd->prepare("SELECT Utilisateur_id_Utilisateur, Contenu, Date_du_message FROM messages WHERE Chat_id_Chat = :chat_id");
    $query->bindParam(':chat_id', $chat_id);
    $query->execute();
    $messages = $query->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($messages as $message) {
        $user_id = $message['Utilisateur_id_Utilisateur'];
        $user_query = $bdd->prepare("SELECT Pseudo FROM utilisateur WHERE id_Utilisateur = :user_id");
        $user_query->bindParam(':user_id', $user_id);
        $user_query->execute();
        $user = $user_query->fetch(PDO::FETCH_ASSOC);

        $html .= "<p><strong>{$user['Pseudo']}:</strong> {$message['Contenu']} <span style='font-size: 12px;'>[{$message['Date_du_message']}]</span></p>";
    }

    echo $html;
}
?>