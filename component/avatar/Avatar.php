<?php
session_start();
require "../../BDD/config.php";
require "recuperer_avatar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>LeSuperCoin - Avatar</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .avatar-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .avatar-section {
            margin-right: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin: 1%;
        }
        button:hover {
            background: #2f9132;
        }

        .button-save {
            background-color: #7979ec;
        }
        .button-save:hover {
            background-color: #4848ec;
        }

        #avatar-result {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border: 1px solid #ccc;
            margin-right: 20px;
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<h1>Générateur d'avatar</h1>

<div class="avatar-container">
    <div class="avatar-section">
        <label for="rond">Rond:</label>
        <select id="rond">
            <option value="img/rond_bleu.png" <?php if ($avatar['rond'] === 'img/rond_bleu.png') echo 'selected'; ?>>Rond bleu</option>
            <option value="img/rond_jaune.png" <?php if ($avatar['rond'] === 'img/rond_jaune.png') echo 'selected'; ?>>Rond jaune</option>
            <option value="img/rond_vert.png" <?php if ($avatar['rond'] === 'img/rond_vert.png') echo 'selected'; ?>>Rond vert</option>
        </select>
    </div>
    <div class="avatar-section">
        <label for="yeux">Yeux:</label>
        <select id="yeux">
            <option value="img/yeux_bleu.png" <?php if ($avatar['yeux'] === 'img/yeux_bleu.png') echo 'selected'; ?>>Yeux bleu</option>
            <option value="img/yeux_jaune.png" <?php if ($avatar['yeux'] === 'img/yeux_jaune.png') echo 'selected'; ?>>Yeux jaune</option>
            <option value="img/yeux_vert.png" <?php if ($avatar['yeux'] === 'img/yeux_vert.png') echo 'selected'; ?>>Yeux vert</option>
        </select>
    </div>
    <div class="avatar-section">
        <label for="nez">Sourire:</label>
        <select id="nez">
            <option value="img/nez1.png" <?php if ($avatar['sourire'] === 'img/nez1.png') echo 'selected'; ?>>Nez 1</option>
            <option value="img/nez2.png" <?php if ($avatar['sourire'] === 'img/nez1.png') echo 'selected'; ?>>Nez 2</option>
        </select>
    </div>
    <div class="avatar-section">
        <label for="sourire">Sourire:</label>
        <select id="sourire">
            <option value="img/sourire.png" <?php if ($avatar['sourire'] === 'img/sourire.png') echo 'selected'; ?>>Content</option>
            <option value="img/pas-sourire.png" <?php if ($avatar['sourire'] === 'img/pas-sourire.png') echo 'selected'; ?>>Pas content</option>
        </select>
    </div>
</div>

<div id="avatar-result">
    <div class="avatar-preview"></div>
</div>

<button onclick="genererAvatar()">Générer la preview</button>
<button onclick="enregistrerAvatar()" class="button-save">Enregistrer l'avatar</button>
<a href="../../profil.php"><button> Retourner sur votre profil </button></a>
<script src="avatar.js"></script>
<script>
    // On genere une premiere previsualisation automatique de l'avatar
    genererAvatar()
</script>

</body>
</html>