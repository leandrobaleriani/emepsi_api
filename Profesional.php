<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Representa el la estructura de las metas
 * almacenadas en la base de datos
 */
//require 'Database.php';

class Profesional
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
        $consulta = "SELECT * FROM pro_profesionales";
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
        $consulta = "SELECT * FROM pro_profesionales WHERE pro_id = ?";

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
        $nombre,
		$telefono,
		$direccion
    )
    {
        // Creando consulta UPDATE
        $consulta = "UPDATE pro_profesionales" .
            " SET pro_nombre=?, pro_telefono=?, pro_direccion=? " .
            "WHERE pro_id=?";

        // Preparar la sentencia
        $cmd = Database::getInstance()->getDb()->prepare($consulta);

        // Relacionar y ejecutar la sentencia
        $cmd->execute(array(
        $nombre,
		$telefono,
		$direccion,
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
		$nombre,
        $direccion,
        $telefono,
        $token
    )
    {
        // Sentencia INSERT
        $comando = "INSERT INTO pro_profesionales ( " .
            "pro_nombre, pro_telefono, pro_direccion, pro_token)" .
            " VALUES( :proNombre, :proTelefono, :proDireccion, :firebaseToken) ON DUPLICATE KEY UPDATE pro_token = :firebaseToken";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);
        $sentencia->bindParam(':proNombre', $nombre);
        $sentencia->bindParam(':proTelefono', $telefono);
        $sentencia->bindParam(':proDireccion', $direccion);
        $sentencia->bindParam(':firebaseToken', $token);
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
        $comando = "DELETE FROM pro_profesionales WHERE pro_id=?";

        // Preparar la sentencia
        $sentencia = Database::getInstance()->getDb()->prepare($comando);

        return $sentencia->execute(array($id));
    }

    public static function getByFecha()
    {
        // Consulta de la meta
        $consulta = "SELECT p.* FROM pro_profesionales p INNER JOIN cal_calendario c on c.pro_nombre = p.pro_nombre WHERE cal_dia = CURDATE()";

        try {
            // Preparar sentencia
            $comando = Database::getInstance()->getDb()->prepare($consulta);
            // Ejecutar sentencia preparada
            $comando->execute();
            // Capturar primera fila del resultado
            $row = $comando->fetch(PDO::FETCH_ASSOC);
            return $row;

        } catch (PDOException $e) {
            // Aquí puedes clasificar el error dependiendo de la excepción
            // para presentarlo en la respuesta Json
            return $e -> getMessage();
        }
    }
}

?>