<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;
use PDOException;

/**
 * Clase modelo encargargado de ejecutar SQL 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class Stock
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Funciona ✅
    public function crearProductoModel(array $data)
    {
        $sql = "INSERT INTO productos(nombre,cantidad,stock_minimo) VALUES (:nombre,:cantidad,:stock_minimo);";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':nombre' => $data['nombre'],
                ':cantidad' => $data['cantidad_inicial'],
                ':stock_minimo' => $data['cantidad_minima'],
            ]);
            return $this->db->lastInsertId();
        } catch (\Throwable $th) {
            throw new \Exception("Error al crear producto: " . $th->getMessage());
        }
    }


    // Funciona ✅
    public function allProductosModel(): array
    {
        $stmt = $this->db->query("SELECT * from productos ORDER BY cantidad DESC;");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
