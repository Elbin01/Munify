<?php
require_once __DIR__ . '/config/Conexion.php';

try {
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    
    if (!$conn) {
        die("Error: No se pudo conectar a la base de datos.");
    }
    
    // Desactivar validación de claves foráneas para poder hacer TRUNCATE sin errores de dependencias
    $conn->exec('SET FOREIGN_KEY_CHECKS = 0');
    
    // Obtener todas las tablas de la base de datos actual
    $stmt = $conn->query('SHOW TABLES');
    $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Lista de tablas que NO queremos vaciar para no perder la configuración básica y el acceso
    $tablas_excluidas = ['rol', 'usuario'];
    
    $tablas_limpiadas = [];
    foreach ($tablas as $tabla) {
        if (!in_array(strtolower($tabla), $tablas_excluidas)) {
            // TRUNCATE vacía la tabla y reinicia los contadores (AUTO_INCREMENT) a 1
            $conn->exec("TRUNCATE TABLE `$tabla`");
            $tablas_limpiadas[] = $tabla;
        }
    }
    
    // Reactivar validación de claves foráneas
    $conn->exec('SET FOREIGN_KEY_CHECKS = 1');
    
    echo "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>";
    echo "<h2 style='color: #2e7d32;'>✅ Base de datos limpiada con éxito</h2>";
    echo "<p>El sistema está como nuevo. Se han vaciado y reiniciado los contadores de las siguientes tablas:</p>";
    echo "<ul>";
    foreach ($tablas_limpiadas as $t) {
        echo "<li><strong>$t</strong></li>";
    }
    echo "</ul>";
    
    echo "<div style='background-color: #fff3cd; color: #856404; padding: 10px; border-radius: 4px; margin-top: 20px;'>";
    echo "<strong>Nota de seguridad:</strong> Las tablas de <code>rol</code> y <code>usuario</code> no fueron alteradas para asegurar que puedas seguir iniciando sesión en el sistema.";
    echo "</div>";
    
    echo "<br><a href='index.php' style='display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px;'>Volver al inicio</a>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error al limpiar la base de datos</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
