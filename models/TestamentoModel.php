<?php

require_once __DIR__ . '/../config/conexion.php';

class TestamentoModel {

    private $db;

    public function __construct() {

    $conexion = new Conexion();

    $this->db = $conexion->conectar();

    if (!$this->db) {
        die("No se pudo conectar a la base de datos.");
    }
}
    public function guardar($datos) {

        try {

            $sql = "INSERT INTO testamentos (
                        nombre_testador,
                        dui_testador,
                        edad_testador,
                        estado_civil_testador,
                        domicilio_testador,
                        nombre_heredero,
                        parentesco_heredero,
                        bienes_declarados,
                        declaracion_voluntad
                        
                    )
                    VALUES (
                        :nombre_testador,
                        :dui_testador,
                        :edad_testador,
                        :estado_civil_testador,
                        :domicilio_testador,
                        :nombre_heredero,
                        :parentesco_heredero,
                        :bienes_declarados,
                        :declaracion_voluntad
                        
                    )";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([
                ':nombre_testador'       => $datos['nombre_testador'],
                ':dui_testador'          => $datos['dui'],
                ':edad_testador'         => $datos['edad'],
                ':estado_civil_testador' => $datos['estado_civil'],
                ':domicilio_testador'    => $datos['domicilio'],
                ':nombre_heredero'       => $datos['heredero'],
                ':parentesco_heredero'   => $datos['parentesco'],
                ':bienes_declarados'     => $datos['bienes'],
                ':declaracion_voluntad'  => $datos['declaracion']
                
            ]);

            return $this->db->lastInsertId();

        } catch (PDOException $e) {

            die("Error al guardar testamento: " . $e->getMessage());
        }
    }

    public function buscarPorId($id) {

        $sql = "SELECT *
                FROM testamentos
                WHERE id_testamento = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerRecientes($limite = 10) {

        $sql = "SELECT *
                FROM testamentos
                ORDER BY fecha_registro DESC
                LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, (int)$limite, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorDui($dui) {

        $sql = "SELECT *
                FROM testamentos
                WHERE dui_testador = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$dui]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}