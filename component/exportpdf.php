<?php
session_start();

$id = $_SESSION['id_Utilisateur'];
$pseudo = $_SESSION['Pseudo'];
$email = $_SESSION['Email'];
$droits = $_SESSION['droits'];

require('../component/fdpf/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Info', 0, 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "ID: $id", 0, 1);
$pdf->Cell(0, 10, "Pseudo: $pseudo", 0, 1);
$pdf->Cell(0, 10, "Email: $email", 0, 1);
$pdf->Cell(0, 10, "Droits: $droits", 0, 1);

$pdf->Output('Info' . $pseudo . '.pdf', 'D');

ob_end_flush();

header('Location: ../profil.php');
exit();
?>
