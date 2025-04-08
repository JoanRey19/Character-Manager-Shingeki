<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de personajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Registro de personajes</h1>
    <p>Crear persona</p>
</body>
    <form action="index.php" method="Post">
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" required><br>
        <label for="color">Color:</label><br>
        <input type="text" name="color" required><br>
        <label for="tipo">Tipo:</label><br>
        <input type="text" name="tipo" required><br>
        <label for="nivel">Nivel:</label><br>
        <input type="number" name="nivel" required><br>
        <label for="foto">Foto:</label><br>
        <input type="text" name="foto"><br>
        <button type="submit">Guardar</button>
    </form>
</html>