<?php
// require("../forms/conexion.php");
require("../pdf/fpdf.php");

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('https://i.ibb.co/Hq1RRTf/Logo-Novus-Legal-09.png',10,8,33);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Movernos a la derecha
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'Title',1,0,'C');
    // Salto de línea
    $this->Ln(20);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}



$pdf = new FPDF("P", "mm", "letter");
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(195,10,utf8_decode("Novus Legal"), 1, 0, "C");
$pdf->Output();
?>

