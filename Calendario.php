<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
//require 'Database.php';

class Calendario
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
        $consulta = "SELECT * FROM cal_calendario";
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
        $consulta = "SELECT * FROM cal_calendario WHERE cal_id = ?";

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
        $fecha,
        $nombre,
        $id
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE cal_calendario" .
            " SET cal_dia=?, pro_nombre=? " .
            "WHERE cal_id=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array($fecha,
        $nombre,
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
        $nombre
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO cal_calendario ( " .
            "cal_dia, pro_nombre)" .
            " VALUES( :fecha, :nombre)";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        $sentencia->bindParam(':fecha', $fecha);
        $sentencia->bindParam(':nombre', $nombre);
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
        $comando = "DELETE FROM cal_calendario WHERE cal_id=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($id));
    }
	
	public static function getByMes($mes)
    {
        // Consulta de la meta
        $consulta = "SELECT * FROM cal_calendario WHERE MONTH(cal_dia) = $mes";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute(array($mes));
            // Capturar primera fila del resultado
            return $comando->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return $e -> getMessage();
        }
    }
}

?>