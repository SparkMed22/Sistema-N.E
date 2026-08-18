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

class Servicios
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function allServiciosModel():array{
        $stmt = $this->db->query("SELECT * FROM servicios;");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}