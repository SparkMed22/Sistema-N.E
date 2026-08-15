<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use RuntimeException;
use PDOException;

/**
 * Clase modelo encargargado de ejecutar SQL 
 * 
 * Maneja las peticiones HTTP para creación, listado y autenticación.
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Funciona ✅
    public function buscarPorCedula(string $cedula): ?object
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM usuarios WHERE cedula = :cedula LIMIT 1"
        );
        $stmt->execute(['cedula' => $cedula]);
        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }


    // Funciona ✅
    public function loginModel(string $cedula, string $password): ?object
    {
        $user = $this->buscarPorCedula($cedula);
        if ($user && password_verify($password, $user->password_hash)) {
            return ($user->estado == 1) ? $user : null;
        }
        return null;
    }


    // Funciona ✅
    public function updatePasswordModel(string $cedula, string $password): bool
    {
        $passHash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "UPDATE usuarios SET password_hash = ?, primer_ingreso = 0 WHERE cedula = ?";

        try {
            $stmt = $this->db->prepare($sql);

            $stmt->execute([$passHash, $cedula]);

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    // Funciona ✅
    public function updateUserModel(int $id, string $rol, bool $estado): bool
    {
        $sql = "UPDATE usuarios SET rol = :rol, estado = :estado WHERE id = :id";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':rol', $rol, \PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, \PDO::PARAM_BOOL);
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error al actualizar usuario (Model): " . $e->getMessage());
            return false;
        }
    }

    // Funciona ✅
    public function restartPasswordModel(string $cedula): bool
    {
        $passHash = password_hash($cedula, PASSWORD_BCRYPT);
        $sql = "UPDATE usuarios SET password_hash = ?, primer_ingreso = 1, estado = 1 WHERE cedula = ?";
        try {
            $stmt = $this->db->prepare($sql);

            $stmt->execute([$passHash, $cedula]);

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
    }


    // Funciona ✅
    public function crearUsuarioModel(string $nombre, string $apellido, string $cedula, string $rol): int
    {
        $passwordInicial = $cedula;
        $hash = password_hash($passwordInicial, PASSWORD_BCRYPT);

        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre,apellido,cedula,password_hash,rol) VALUES (:nombre, :apellido, :cedula, :password_hash, :rol)");

        try {
            $stmt->execute([
                'nombre'        => $nombre,
                'apellido'      => $apellido,
                'cedula'        => $cedula,
                'password_hash' => $hash,
                'rol'           => $rol
            ]);
            return (int)$this->db->lastInsertId();
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                throw new RuntimeException('La cédula ya está registrada.');
            }
            error_log("Error al crear usuario: " . $e->getMessage());
            throw new RuntimeException('Error al crear el usuario.');
        }
    }

    // Funciona ✅
    public function allModel(): array
    {
        $stmt = $this->db->query("SELECT id ,nombre, apellido, cedula, rol,estado FROM usuarios;");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
