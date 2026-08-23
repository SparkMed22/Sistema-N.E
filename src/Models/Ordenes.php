<?php

namespace App\Models;
use App\Core\Database;
use PDO;
use Throwable;
use RuntimeException;

/**
 * Clase modelo encargargado de ejecutar SQL 
 * 
 * @author Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @version 1.0.0
 * @package App\Moodels
 */

class Ordenes
{
    // TODO: modellReceta
    private PDO $db;
    private Stock $modelStock;
    private Recetas $modelReceta;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->modelStock = new Stock();
        $this->modelReceta = new Recetas();
    }

    // Funciona ✅
    public function crearOrdenModel(array $data): int
    {
        $sql = "INSERT INTO pedidos (receta_id,gestionado_usuario_id)
            VALUES (:receta_id,:gestionado_usuario_id)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':receta_id' => $data['receta_id'],
                ':gestionado_usuario_id' => $data['gestionado_usuario_id']
            ]);
            return (int) $this->db->lastInsertId();
        } catch (Throwable $e) {
            throw new RuntimeException('Error al crear la orden: ' . $e->getMessage());
        }
    }




    /*
            foreach ($data['productos'] as $producto) {
                $productoId = (int) $producto['id_producto'];
                $cantidad   = (int) $producto['cantidad'];

                $this->stockModel->retirarInventarioPedidio(
                    $productoId,
                    $cantidad,
                    'Retiro por receta',
                    (int) $data['gestionado_usuario_id'],
                    $idOrden
                );

                $this->stockModel->registrarComponentePedido($idOrden, $productoId, $cantidad);
            }

            $this->model->cerrarPedidioModel($idOrden);

            $DB_STOCK->commit();*/


    /**
     * {
     *  "receta_id":10,
     *  "gestionado_usuario_id":1,
     *  "productos":[
     *      {
     *          "id_producto":32,
     *          "cantidad":2
     *      },
     *      {   
     *          "id_producto":31,
     *          "cantidad":30  
     *      }
     *  ]
     * }
     */
    public function procesarOrderModel(array $data)
    {
        try {
            $this->db->beginTransaction();

            $idOrden = $this->crearOrdenModel($data);
            error_log('DATOS RECUPERADOS: ' . json_encode($data));

            foreach ($data['productos'] as $producto) {
                $productoId = (int) $producto['id_producto'];
                $cantidad   = (int) $producto['cantidad'];

                error_log("ProductoID => {$productoId} | Cantidad => {$cantidad}");

                $this->modelStock->retirarInventario(
                    $productoId,
                    $cantidad,
                    'Retiro por receta',
                    (int) $data['gestionado_usuario_id'],
                    $idOrden
                );
                $this->modelStock->registrarComponentePedido($idOrden, $productoId, $cantidad);
            }
            $this->cerrarPedidioModel($idOrden);
            $this->modelReceta->aprobarRecetaModel($data['receta_id'],'Vinculado a un PEDIDO',$data['gestionado_usuario_id']);
            $this->db->commit();
        } catch (\Throwable $th) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $th;
        }
    }





    public function cerrarPedidioModel(int $pedido_id): bool
    {
        $sql = "UPDATE pedidos 
            SET estado = 'CERRADO', fecha_cierre = NOW() 
            WHERE id = :pedido_id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':pedido_id' => $pedido_id
            ]);

            if ($stmt->rowCount() === 0) {
                throw new \RuntimeException("No se encontró el pedido con ID {$pedido_id} para cerrar.");
            }

            return true;
        } catch (\Throwable $e) {
            throw new \RuntimeException('Error al cerrar la orden: ' . $e->getMessage());
        }
    }
}
