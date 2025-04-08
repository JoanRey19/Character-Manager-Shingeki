<?php
// Función para mostrar la tabla con los personajes
function mostrarTabla($filas) {
    if (empty($filas)) {
        echo "No hay datos para mostrar.";
        return;
    }

    echo "<table border='1'>";
    echo "<thead><tr>";

    // Mostrar encabezados de la tabla
    $fila = $filas[0];
    foreach ($fila as $columna => $valor) {
        echo "<th>$columna</th>";
    }
    echo "</tr></thead>";

    echo "<tbody>";
    foreach ($filas as $fila) {
        echo "<tr>";
        foreach ($fila as $columna => $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
}

?>