<?php
require('fpdf186/fpdf.php'); 
require('libreria/configx.php'); 


if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$id = $_GET['id']; 

try {

    $c = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    $sql = "SELECT * FROM personajes WHERE id = :id";
    $stmt = $c->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $personaje = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$personaje) {
        die("Personaje no encontrado.");
    }


    $nombre = $personaje->nombre;
    $color = $personaje->color;
    $tipo = $personaje->tipo;
    $nivel = $personaje->nivel;
    $foto = $personaje->foto; 
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}


$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);


ob_clean(); 


$pdf->Cell(190, 10, "Perfil del Personaje", 0, 1, 'C');
$pdf->Ln(10);


$pdf->Image($foto, 80, 30, 50); 
$pdf->Ln(60);


$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 10, "Nombre:", 0, 0);
$pdf->Cell(100, 10, mb_convert_encoding($nombre, 'ISO-8859-1', 'UTF-8'), 0, 1);

$pdf->Cell(50, 10, "Color Representativo:", 0, 0);
$pdf->Cell(100, 10, mb_convert_encoding($color, 'ISO-8859-1', 'UTF-8'), 0, 1);

$pdf->Cell(50, 10, "Tipo:", 0, 0);
$pdf->Cell(100, 10, mb_convert_encoding($tipo, 'ISO-8859-1', 'UTF-8'), 0, 1);

$pdf->Cell(50, 10, "Nivel:", 0, 0);
$pdf->Cell(100, 10, mb_convert_encoding($nivel, 'ISO-8859-1', 'UTF-8'), 0, 1);


$pdf->Output("D", "perfil_$nombre.pdf");
exit;
?>