<?php

namespace src\models\activeRecord;

use Exception;
use src\interfaces\ActiveRecordInterface;
use src\models\connection\Connection;
use Throwable;

class FindAll
{
    public function __construct(
        private array $where = [],
        private string|int $limit = '', 
        private string|int $offset = '',
        private string $fields = '*')
    {
        
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();           

            $statement = $connection->prepare($query);

            $statement->execute($this->where);

            return $statement->fetchAll();

        } catch (Throwable $error){
            formatException($error);
        }
    }

    
    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {        
        if(count($this->where) > 1){
            throw new Exception("No where so pode passar um indice!");
        }

        $where = array_keys($this->where);
        $sql = "select {$this->fields} from {$activeRecordInterface->getTable()} ";
        $sql .= (!$this->where) ? '' : " where {$where[0]} = :{$where[0]}";
        $sql .= (!$this->limit) ? '' : " limit {$this->limit} ";
        $sql .= ($this->offset != '') ? " offset {$this->offset} " : "";
        return $sql;
    }
}