<?php
//Clase que establece la conexion con la base de datos de mysql
    class Conexion
    {
        private $host = "";
        private $user = "";
        private $password = "";
        private $database = "";
        private $connection;

        //Constructor de la clase
        //para inicializar los atributos

        public function __construct()
        {
            $this->host = "localhost";
            $this->user = "root";
            $this->password = "";
            $this->database = "sakila";
        }

        //Metodo para abrir la conexion 
        public function openConnection(){
            try
            {
                //Objeto conexion para acceder a la base de datos con la cadena de conexion
                //Instancia de PDO
                $this->connection = new PDO("mysql:host={$this->host};dbname={$this->database}",$this->user,$this->password);
                //Manejo de errores cargando valores
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e)
            {
                $this->connection=false;
            }
        }

        //metodo para cerrar la conexion 
        public function closeConnection(){
            mysql_close($this->connection);
        }

        //Metodo para permitir a otras clases hacer uso de la conexion 
        public function getConnection(){
            return $this->connection;
        }
    
    }

    //Pruebas para verificar la conexion
    // $obj = new Conexion();

    // $obj->openConnection();
    // if($obj->getConnection()){
    // echo "Ok";
    // }


?>