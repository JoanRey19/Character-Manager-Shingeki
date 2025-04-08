<?php

require('libreria/motor.php');

try {
    $c = new PDO("mysql:host=localhost;dbname=shingeki_db", "root", "");
    $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $color = $_POST["color"];
        $tipo = $_POST["tipo"];
        $nivel = $_POST["nivel"];
        $foto = $_POST["foto"];
    

    $sql_update = "UPDATE personajes SET nombre = :nombre, color = :color, tipo = :tipo, nivel = :nivel, foto = :foto WHERE id = :id";
    $stmt = $c->prepare($sql_update);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':tipo', $tipo);
    $stmt->bindParam(':nivel', $nivel, PDO::PARAM_INT);
    $stmt->bindParam(':foto', $foto);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "✅ Personaje actualizado con éxito.";
    header("Location: index.php");
    exit();
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $sql_select = "SELECT * FROM personajes WHERE id = :id";
        $stmt = $c->prepare($sql_select);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $personaje = $stmt->fetch(PDO::FETCH_OBJ);
    } else {
        echo "❌ ID de personaje no proporcionado.";
        exit();
    }


} catch (PDOException $e) {
    echo"❌ Error de conexion: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personaje</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-top: 10px;
            color: #555;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            margin-top: 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>Editar Personaje</h1>
        <form method="POST" action="editar.php">
            <input type="hidden" name="id" value="<?php echo $personaje->id; ?>">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $personaje->nombre; ?>" required>
            <label>Color:</label>
            <input type="text" name="color" value="<?php echo $personaje->color; ?>" required>
            <label>Tipo:</label>
            <input type="text" name="tipo" value="<?php echo $personaje->tipo; ?>" required>
            <label>Nivel:</label>
            <input type="number" name="nivel" value="<?php echo $personaje->nivel; ?>" required>
            <label>Foto (URL):</label>
            <input type="text" name="foto" value="<?php echo $personaje->foto; ?>" required>
            <button type="submit">Guardar Cambios</button>
        </form>
        <a href="index.php">Volver a la lista</a>
    </div>
</body>
</html>