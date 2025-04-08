<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
require('libreria/motor.php');
// Mostrar errores para depuración
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



// Configuración de conexión con PDO
try {
    // Conectar a la base de datos
    $c = new PDO("mysql:host=localhost;dbname=shingeki_db", "root", "");
    $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el formulario fue enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar si los campos están llenos
        if (!empty($_POST["nombre"]) && !empty($_POST["color"]) && !empty($_POST["tipo"]) && !empty($_POST["nivel"]) && !empty($_POST["foto"])) {
            
            // Obtener los valores del formulario
            $nombre = $_POST["nombre"];
            $color = $_POST["color"];
            $tipo = $_POST["tipo"];
            $nivel = $_POST["nivel"];
            $foto = $_POST["foto"];

            // Verificar si el personaje ya existe en la base de datos
            $sql_check = "SELECT COUNT(*) FROM personajes WHERE nombre = :nombre";
            $stmt_check = $c->prepare($sql_check);
            $stmt_check->bindParam(':nombre', $nombre);
            $stmt_check->execute();
            $existe = $stmt_check->fetchColumn();

            if ($existe == 0) { // Solo insertar si no existe
                $sql_insert = "INSERT INTO personajes (nombre, color, tipo, nivel, foto)
                               VALUES (:nombre, :color, :tipo, :nivel, :foto)";
                $stmt = $c->prepare($sql_insert);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':color', $color);
                $stmt->bindParam(':tipo', $tipo);
                $stmt->bindParam(':nivel', $nivel, PDO::PARAM_INT);
                $stmt->bindParam(':foto', $foto);
                $stmt->execute();

                echo "✅ Personaje insertado con éxito. ID: " . $c->lastInsertId();
            } else {
                echo "⚠️ El personaje ya existe en la base de datos.";
            }
        } else {
            echo "❌ Todos los campos son obligatorios.";
        }
    }

    // Mostrar los datos de la tabla personajes
    $sql = "SELECT * FROM personajes";
    $stmt = $c->query($sql);
    $filas = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($filas as $fila) {
            $fila->act = "<a href='editar.php?id=$fila->id' style='background-color: blue; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none;'>Editar</a>";
            $fila->foto = "<img onerror=\"this.src='https://img00.deviantart.net/de85/i/2013/298/1/0/shingeki_no_kyojin_logo_wallpaper_by_enabels-d6rqydp.png'\" alt='no foto' src='$fila->foto' width='100'>";
            $fila->eliminar = "<a href='eliminar.php?id=$fila->id' onclick='return confirm(\"¿Estás seguro de eliminar este personaje?\");' style='background-color: red; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none;'>Eliminar</a>";
            $fila->pdf = "<a href='generar_pdf.php?id=$fila->id' target='_blank' style='background-color: green; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none;'>📄 Descargar PDF</a>";
        }

} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
echo '<header class="bg-black text-white py-4">
    <div class="container mx-auto flex justify-between items-center">
        <img src="https://img00.deviantart.net/de85/i/2013/298/1/0/shingeki_no_kyojin_logo_wallpaper_by_enabels-d6rqydp.png" alt="Attack on Titan" class="h-12">
        <h1 class="text-3xl font-bold">Lista de Personajes</h1>
    </div>
</header>';

echo '<div class="container mx-auto mt-8">
    <a href="RegistroPersonaje.php" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Crear Personaje</a>
</div>';
// Mostrar la tabla con los datos de los personajes
mostrarTabla($filas);
?>