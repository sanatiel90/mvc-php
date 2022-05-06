<?php

namespace src\models\activeRecord;

use Exception;
use src\interfaces\ActiveRecordExecuteInterface;
use src\interfaces\ActiveRecordInterface;
use src\models\connection\Connection;
use Throwable;

class Update implements ActiveRecordExecuteInterface
{

    public function __construct(private string $field, private string $value)
    {
        
    }

    public function execute(ActiveRecordInterface $activeRecordInterface)
    {
        try{
            $query = $this->createQuery($activeRecordInterface);
            $conn = Connection::connect();

            $data = array_merge($activeRecordInterface->getData(), [
                $this->field => $this->value
            ]);

            $prepare = $conn->prepare($query);
            $prepare->execute($data);

        } catch(Throwable $e){
            formatException($e);
        }
    }

    private function createQuery(ActiveRecordInterface $activeRecordInterface)
    {
        
        if(array_key_exists('id', $activeRecordInterface->getData())){
            throw new Exception("O campo id não pode ser passado para o update");
        }
        
        $sql = "update {$activeRecordInterface->getTable()} set ";
        foreach($activeRecordInterface->getData() as $key=>$value){            
            $sql .= "{$key}=:{$key},";
        }

        $sql = rtrim($sql, ',');
        $sql .= " where {$this->field} = :{$this->field}";

        return $sql;
    }
    
}  

