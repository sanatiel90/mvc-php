<?php

namespace src\models\activeRecord;

use ReflectionClass;
use src\interfaces\ActiveRecordExecuteInterface;
use src\interfaces\ActiveRecordInterface;

abstract class ActiveRecord implements ActiveRecordInterface
{

    protected $table = null;
    protected $data = [];

    public function __construct()
    {
        if(!$this->table){
            //caso as classes q herdam do ActiveRecord nao tenham provido a var $table, preenche ela com o nome
            //da classe (para usar esse padrao é importante nomear as tabelas no BD no singular)
            $this->table = strtolower((new ReflectionClass($this))->getShortName());
        }
    }

    public function getTable(){
        return $this->table;
    }

    public function getData(){
        return $this->data;
    }

    public function __set($prop, $value)
    {
        $this->data[$prop] = $value;
    }

    public function __get($prop)
    {
        return $this->data[$prop];
    }

    public function execute(ActiveRecordExecuteInterface $activeRecordExecuteInterface)
    {
        return $activeRecordExecuteInterface->execute($this);
    }

    
}