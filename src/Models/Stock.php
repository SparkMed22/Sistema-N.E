<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use Throwable;
use Exception;

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

    // Funciona ✅
    public function agregarInventarioModel(int $productoId, int $cantidad, string $motivo, int $usuarioId): bool
    {

        try {
            $this->db->beginTransaction();
            $sql = "UPDATE productos SET cantidad = cantidad + :cantidad WHERE id = :producto_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':cantidad' => $cantidad, ':producto_id' => $productoId]);
            if ($stmt->rowCount() === 0) throw new Exception('El producto no existe.');
            $sqlMovimiento = "INSERT INTO stock_movimientos (producto_id,usuario_id,tipo,cantidad,motivo)
                VALUES (:producto_id,:usuario_id,'ENTRADA',:cantidad,:motivo)";
            $stmtMovimiento = $this->db->prepare($sqlMovimiento);
            $stmtMovimiento->execute([':producto_id' => $productoId, ':usuario_id' => $usuarioId, ':cantidad' => $cantidad, ':motivo' => $motivo]);
            $this->db->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }

    // Funciona ✅
    public function retirarInventario(int $productoId,int $cantidad,string $motivo,int $usuarioId,?int $pedidoId = null): bool 
    {
        try {
            $this->db->beginTransaction();

            // Buscar y bloquear el producto
            $sqlProducto = "SELECT id, nombre, cantidad 
                FROM productos WHERE id = :producto_id FOR UPDATE";

            $stmtProducto = $this->db->prepare($sqlProducto);

            $stmtProducto->execute([':producto_id' => $productoId]);

            $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);
            if (!$producto) throw new \RuntimeException('El producto no existe.');

            if ($producto['cantidad'] < $cantidad) throw new \RuntimeException('Stock insuficiente.');
            
            $sqlActualizar = "UPDATE productos SET cantidad = cantidad - :cantidad WHERE id = :producto_id";
            $stmtActualizar = $this->db->prepare($sqlActualizar);
            $stmtActualizar->execute([
                ':cantidad' => $cantidad,
                ':producto_id' => $productoId
            ]);

            if ($stmtActualizar->rowCount() !== 1) throw new \RuntimeException('No se pudo actualizar el stock del producto.');
            

            $sqlMovimiento = "INSERT INTO stock_movimientos (producto_id,pedido_id,usuario_id,tipo,cantidad,motivo)
            VALUES (:producto_id,:pedido_id,:usuario_id,'SALIDA',:cantidad,:motivo)";

            $stmtMovimiento = $this->db->prepare($sqlMovimiento);

            $stmtMovimiento->execute([
                ':producto_id' => $productoId,
                ':pedido_id' => $pedidoId,
                ':usuario_id' => $usuarioId,
                ':cantidad' => $cantidad,
                ':motivo' => $motivo
            ]);
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            throw $e;
        }
    }
}
