<?php

session_start();

use src\controllers\Product;
use src\core\AppExtract;
use src\database\activeRecord\FindAll;
use src\database\activeRecord\Insert;
use src\models\activeRecord\Insert as ActiveRecordInsert;
use src\models\User;

require '../vendor/autoload.php';

require '../src/views/index.php';


$app = new AppExtract;
$product = new Product;
echo $app->controller($product);

