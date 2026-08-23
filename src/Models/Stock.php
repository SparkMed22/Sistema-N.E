<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use Throwable;
use Exception;
use RuntimeException;

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

    public function db_f(): PDO
    {
        return $this->db;
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

            // 1. Actualizar el stock en la tabla 'productos'
            $sql = "UPDATE productos SET cantidad = cantidad + :cantidad WHERE id = :producto_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':cantidad'    => $cantidad,
                ':producto_id' => $productoId
            ]);

            if ($stmt->rowCount() === 0) {
                throw new \Exception('El producto no existe.');
            }

            $sqlMovimiento = "INSERT INTO stock_movimientos (producto_id, usuario_id, tipo, cantidad, motivo)
                          VALUES (:producto_id, :usuario_id, 'ENTRADA', :cantidad, :motivo)";
            $stmtMovimiento = $this->db->prepare($sqlMovimiento);
            $stmtMovimiento->execute([
                ':producto_id' => $productoId,
                ':usuario_id'  => $usuarioId,
                ':cantidad'    => $cantidad,
                ':motivo'      => $motivo
            ]);

            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    // Funciona ✅
    /*public function retirarInventario(int $productoId, int $cantidad, string $motivo, int $usuarioId, ?int $pedidoId = null): bool
    {
        try {
            $this->db->beginTransaction();

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
    }*/

    public function retirarInventario(int $productoId, int $cantidad, string $motivo, int $usuarioId, ?int $pedidoId = null): bool
    {
        // NO iniciar ni confirmar transacciones aquí. Se asume que el llamador controla la transacción.
        $sqlProducto = "SELECT id, nombre, cantidad 
        FROM productos WHERE id = :producto_id FOR UPDATE";

        $stmtProducto = $this->db->prepare($sqlProducto);
        $stmtProducto->execute([':producto_id' => $productoId]);

        $producto = $stmtProducto->fetch(PDO::FETCH_ASSOC);
        if (!$producto) {
            throw new \RuntimeException("El producto con ID {$productoId} no existe.");
        }

        if ((int)$producto['cantidad'] < $cantidad) {
            throw new \RuntimeException("Stock insuficiente para el producto: {$producto['nombre']}. Disponible: {$producto['cantidad']}, Requerido: {$cantidad}");
        }

        $sqlActualizar = "UPDATE productos SET cantidad = cantidad - :cantidad WHERE id = :producto_id";
        $stmtActualizar = $this->db->prepare($sqlActualizar);
        $stmtActualizar->execute([
            ':cantidad' => $cantidad,
            ':producto_id' => $productoId
        ]);

        if ($stmtActualizar->rowCount() !== 1) {
            throw new \RuntimeException("No se pudo actualizar el stock del producto ID {$productoId}.");
        }

        $sqlMovimiento = "INSERT INTO stock_movimientos (producto_id, pedido_id, usuario_id, tipo, cantidad, motivo)
        VALUES (:producto_id, :pedido_id, :usuario_id, 'SALIDA', :cantidad, :motivo)";

        $stmtMovimiento = $this->db->prepare($sqlMovimiento);
        $resultado = $stmtMovimiento->execute([
            ':producto_id' => $productoId,
            ':pedido_id'   => $pedidoId,
            ':usuario_id'  => $usuarioId,
            ':cantidad'    => $cantidad,
            ':motivo'      => $motivo
        ]);

        if (!$resultado) {
            throw new \RuntimeException('No se pudo registrar el movimiento de stock.');
        }

        return true;
    }


    public function registrarComponentePedido(int $pedidoId, int $productoId, int $cantidad): bool
    {
        $sql = "INSERT INTO pedido_componentes (pedido_id,producto_id,cantidad)
            VALUES (:pedido_id,:producto_id,:cantidad)";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':pedido_id' => $pedidoId,
                ':producto_id' => $productoId,
                ':cantidad' => $cantidad
            ]);
        } catch (Throwable $e) {

            throw new RuntimeException(
                'Error al registrar componente del pedido: ' .
                    $e->getMessage()
            );
        }
    }
}
