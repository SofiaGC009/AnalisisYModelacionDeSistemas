<?php

declare(strict_types=1);

class Conexion
{
    private $db_conn;

    public function __construct()
    {
        $this->set_db("localhost", "root", "", "agencia_autos");
    }

    public function __destruct()
    {
        $this->close_db();
    }

    private function set_db($host, $user, $passwd, $db)
    {
        if (!isset($this->db_conn)) {
            $this->db_conn = mysqli_connect($host, $user, $passwd, $db);
        }

        if (!$this->db_conn) {
            throw new Exception("Error de conexión a la base de datos.");
        }
    }

    private function close_db()
    {
        if (isset($this->db_conn)) {
            mysqli_close($this->db_conn);
        }
    }

    public function getConexion()
    {
        return $this->db_conn;
    }
}
