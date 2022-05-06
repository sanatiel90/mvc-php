<?php

namespace src\models\activeRecord;

use Exception;
use src\interfaces\ActiveRecordExecuteInterface;
use src\interfaces\ActiveRecordInterface;
use src\models\connection\Connection;
use Throwable;

class Delete implements ActiveRecordExecuteInterface
{
    public function __construct(private string $field, private string|int $value)
    {
        
    }



    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();

           
            $statement = $connection->prepare($query);

            $statement->execute([
                $this->field => $this->value
            ]);

            return $statement->rowCount();

        } catch (Throwable $error){
            formatException($error);
        }
    }

    
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {

        if($activeRecordInterface->getData()){
            throw new Exception('Para deleter não precisa passar atributos');
        }

        $sql = "DELETE FROM {$activeRecordInterface->getTable()} ";
        $sql .= " WHERE {$this->field} = :{$this->field} ";
        return $sql;
    }
}