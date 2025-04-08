<?php

require('libreria/motor.php');

try {
    $c = new PDO("mysql:host=localhost;dbname=shingeki_db", "root", "");
    $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql_delete = "DELETE FROM personajes WHERE id = :id";
        $stmt = $c->prepare($sql_delete);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        echo "✅ Personaje eliminado con éxito.";
        header("Location: index.php"); 
        exit();
    } else {
        echo "❌ ID de personaje no proporcionado.";
        exit();
    }
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>