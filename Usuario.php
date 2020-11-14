<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
//require 'Database.php';

class Reserva
{
    function __construct()
    {
    }

	
    /**
     * Retorna en la fila especificada de la tabla 'men_menues'
     * @return array Datos del registro
     */
    public static function getAll()
    {
        $consulta = "SELECT * FROM res_reservas";
        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();

            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return $e;
        }
    }

    /**
     * Obtiene los campos de un menu con un identificador
     * determinado
     *
     * @param $id Identificador del menu
     * @return mixed
     */
    public static function getById($id)
    {
        // Consulta de la meta
        $consulta = "SELECT * FROM res_reservas WHERE res_id = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($id));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }

    /**
     * Actualiza un registro de la bases de datos basado
     * en los nuevos valores relacionados con un identificador
     *
     * @param $id      identificador
     * @param $fecha      nueva fecha
     * @param $descripcion nueva descripcion
	 * @return PDOStatement
     */
    public static function update(
        $id,
        $fecha,
        $nombre,
		$telefono,
		$direccionRojas,
		$direccionBsAs,
		$detalle,
		$horaDesde,
		$horaHasta,
		$ida,
		$vuelta,
		$estado,
		$userId
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE res_reservas" .
            " SET res_fecha=?, res_nombre=?, res_telefono=?, res_dir_rojas=?, res_dir_bsabs=?, res_detalle=?, res_hora_desde=?, res_hora_hasta=?, res_ida=?, res_vuelta=?, res_estado=?, user_id=? " .
            "WHERE res_id=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($fecha,
        $nombre,
		$telefono,
		$direccionRojas,
		$direccionBsAs,
		$detalle,
		$horaDesde,
		$horaHasta,
		$ida,
		$vuelta,
		$estado,
		$userId,
		$id));

        return $cmd;
    }

    /**
     * Insertar un nuevo menu
     *
     * @param $fecha      fecha del nuevo registro
     * @param $descripcion descripcion del nuevo registro
     * @return PDOStatement
     */
    public static function insert(
		$fecha,
        $nombre,
		$telefono,
		$direccionRojas,
		$direccionBsAs,
		$detalle,
		$horaDesde,
		$horaHasta,
		$ida,
		$vuelta,
		$estado,
		$userId
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO res_reservas ( " .
            "res_fecha, res_nombre, res_telefono, res_dir_rojas, res_dir_bsas, res_detalle, res_hora_desde, res_hora_hasta, res_ida, res_vuelta, res_estado, user_id)" .
            " VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(
            array(
				$fecha,
                $nombre,
				$telefono,
				$direccionRojas,
				$direccionBsAs,
				$detalle,
				$horaDesde,
				$horaHasta,
				$ida,
				$vuelta,
				$estado,
				$userId
            )
        );

    }

    /**
     * Eliminar el registro con el identificador especificado
     *
     * @param $id identificador del menu
     * @return bool Respuesta de la eliminación
     */
    public static function delete($id)
    {
        // Sentencia DELETE
        $comando = "DELETE FROM res_reservas WHERE res_id=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($id));
    }
	
	public static function updateEstado(
        $id,
		$estado
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE res_reservas" .
            " SET res_estado=? " .
            "WHERE res_id=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($estado, $id));

        return $cmd;
    }
	
	public static function getByFecha($fecha)
    {
        // Consulta de la meta
        $consulta = "SELECT * FROM res_reservas WHERE res_fecha = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($fecha));
            // Capturar primera fila del resultado
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return $e -> getMessage();
        }
    }
	
	public static function getByUserId($userId)
    {
        // Consulta de la meta
        $consulta = "SELECT * FROM res_reservas WHERE user_id = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($userId));
            // Capturar primera fila del resultado
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
}

?>