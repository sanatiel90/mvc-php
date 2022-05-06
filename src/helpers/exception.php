<?php

function formatException(Throwable $error){
    var_dump("Erro no arquivo {$error->getFile()} na linha {$error->getLine()}: {$error->getMessage()}");
}