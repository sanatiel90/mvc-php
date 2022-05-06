<?php

namespace src\models\activeRecord;

use src\interfaces\ActiveRecordExecuteInterface;
use src\interfaces\ActiveRecordInterface;
use src\models\connection\Connection;
use Throwable;

class FindBy implements ActiveRecordExecuteInterface
{ 
    public function __construct(private string $field, private string|int $value, private string $fields = '*')
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

            return $statement->fetch();

        } catch (Throwable $error){
            formatException($error);
        }
    }

    
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {        

        $sql = "SELECT {$this->fields} FROM {$activeRecordInterface->getTable()} ";
        $sql .= " WHERE {$this->field} = :{$this->field} ";        

        return $sql;
    }
}