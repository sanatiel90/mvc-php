<?php

namespace src\models\activeRecord;

use Exception;
use src\interfaces\ActiveRecordExecuteInterface;
use src\interfaces\ActiveRecordInterface;
use src\models\connection\Connection;
use Throwable;

class Insert implements ActiveRecordExecuteInterface
{
    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try {
            $query = $this->createQuery($activeRecordInterface);

            $connection = Connection::connect();
            $statement = $connection->prepare($query);
            return $statement->execute($activeRecordInterface->getData());
            

        } catch (Throwable $error){
            formatException($error);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {

        if(array_key_exists('id', $activeRecordInterface->getData())){
            throw new Exception('O campo id não pode ser passado para o update');
        }

        $sql = "insert into {$activeRecordInterface->getTable()} (";
        $sql .= implode(',', array_keys($activeRecordInterface->getData())).') ';
        $sql .= 'values (';
        $sql .= ':'.implode(',:', array_keys($activeRecordInterface->getData())).')';
      
        return $sql;
    }
}