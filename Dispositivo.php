<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
//require 'Database.php';

class Dispositivo
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
        $consulta = "SELECT * FROM dis_dispositivos";
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
        $consulta = "SELECT * FROM dis_dispositivos WHERE dis_id = ?";

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
        $deviceId,
        $firebaseToken
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE dis_dispositivos" .
            " SET dis_device_id=?, dis_firebase_token=? " .
            "WHERE dis_id=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($deviceId,
        $firebaseToken,
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
        $deviceId,
        $firebaseToken
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO dis_dispositivos ( " .
            "dis_device_id, dis_firebase_token)" .
            " VALUES( :deviceId, :firebaseToken) ON DUPLICATE KEY UPDATE dis_firebase_token = :firebaseToken";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        $sentencia->bindParam(':deviceId', $deviceId);
        $sentencia->bindParam(':firebaseToken', $firebaseToken);
        return $sentencia->execute();

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
        $comando = "DELETE FROM tur_turnos WHERE tur_id=?";

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
        $consulta = "UPDATE tur_turnos" .
            " SET tur_estado=? " .
            "WHERE tur_id=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($estado, $id));

        return $cmd;
    }
	
	public static function getByFecha($fecha)
    {
        // Consulta de la meta
        $consulta = "SELECT * FROM tur_turnos WHERE tur_fecha = CURDATE() AND tur_estado <> 'CANCELADO'";

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
	
	public static function getByDeviceId($deviceId)
    {
        // Consulta de la meta
        $consulta = "SELECT * FROM dis_dispositivos WHERE dis_device_id = ?";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($deviceId));
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return -1;
        }
    }
}

?>