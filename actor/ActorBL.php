<?php
//Hacer uso de la clases
require '../DTO/ActorDTO.php';
require '../Conexion.php';
    class ActorBL
    {
        //Atributo referente a la conexion
        private $conn;
        
        public function __construct()
        {
            $this->conn = new Conexion();
        }

        public function create($actorDTO)
        {
            //instancia de conexion
            $this->conn->openConnection();
            $conn_sql = $this->conn->getConnection();
            $lastInsertId = 0;
            try
            {
                if($conn_sql)
                {
                    $conn_sql->beginTransaction();
                    $sqlStatement = $conn_sql->prepare(
                        "INSERT INTO actor VALUES(
                            default,
                            :first_name,
                            :last_name,
                            current_date
                        )"
                    );
                    $sqlStatement->bindParam(':first_name',$actorDTO->nombre);
                    $sqlStatement->bindParam(':last_name',$actorDTO->apellidos);
                    $sqlStatement->execute();
                    $lastInsertId = $conn_sql->lastInsertId();
                    $conn_sql->commit();
                }
                
            }
            catch(PDOException $e)
            {
                $conn_sql->rollback();
            }
            return $lastInsertId;
        }

        public function read($id){
            $this->conn->openConnection();
            $conn_sql = $this->conn->getConnection();
            $arrayActor = new ArrayObject();
            $sqlQuery ="SELECT * FROM actor";
            $actorDTO = new ActorDTO();
            if($id > 0)
                $sqlQuery ="SELECT * FROM actor WHERE actor_id={$id}";

            try
            {
                if($conn_sql)
                {
                    foreach($conn_sql->query($sqlQuery) as $row)
                    {
                        $actorDTO = new ActorDTO();
                        $actorDTO->id = $row['actor_id'];
                        $actorDTO->nombre = $row['first_name'];
                        $actorDTO->apellidos = $row['last_name'];
                        $arrayActor->append($actorDTO);
                    }
                }
            }
            catch(PDOException $e)
            {

            }
            return $arrayActor;

        }

        public function update($actorDTO)
        {
            $this->conn->openConnection();
            $conn_sql = $this->conn->getConnection();
            try
            {
                if($conn_sql)
                {
                    $conn_sql->beginTransaction();
                    $sqlStatement = $conn_sql->prepare(
                        "UPDATE actor SET 
                        first_name = :first_name,
                        last_name = :last_name,
                        last_update = current_date
                        WHERE actor_id = :actor_id"
                    );
                    $sqlStatement->bindParam(':first_name',$actorDTO->nombre);
                    $sqlStatement->bindParam(':last_name',$actorDTO->apellidos);
                    $sqlStatement->bindParam(':actor_id',$actorDTO->id);
                    $sqlStatement->execute();

                    $conn_sql->commit();
                }
            }
            catch(PDOException $e)
            {
                $conn_sql->rollback();
            }
        }

        public function delete($id)
        {
            $this->conn->openConnection();
            $conn_sql = $this->conn->getConnection();
            try
            {
                if($conn_sql)
                {
                    $conn_sql->beginTransaction();
                    $sqlStatement = $conn_sql->prepare(
                    "DELETE FROM actor WHERE actor_id = :actor_id"
                    );
                    $sqlStatement->bindParam(':actor_id',$id);
                    $sqlStatement->execute();

                    $conn_sql->commit();
                }
            }
            catch(PDOException $e)
            {
                $conn_sql->rollback();
            }
        }
    }
    //Pruebas
    // //create
    // $objActorDTO = new ActorDTO();
    // $objActorBL = new ActorBL();

    // $objActorDTO->nombre = "Guadalupe";
    // $objActorDTO->apellidos = "Mendoza del Toro";
    // $objActorBL->create($objActorDTO);
   
    //read
//     $objActorBL = new ActorBL();

//    print_r($objActorBL->read(0));
    //update
    // $objActorBL = new ActorBL();
    // $objActorDTO = new ActorDTO();
    // $objActorDTO->id = 202;
    // $objActorDTO->nombre = "Lupe";
    // $objActorDTO->apellidos = "MdT";

    // $objActorBL->update($objActorDTO);

    //delete    
    $objActorBL = new ActorBL();
    $objActorBL->delete(204);



?>