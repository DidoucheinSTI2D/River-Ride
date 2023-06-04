<?php
$bdd = new PDO('mysql:host=localhost;dbname=MasterTheWeb', 'root', '');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);