<?php

namespace src\models;

use src\models\activeRecord\ActiveRecord;

class User extends ActiveRecord
{
    protected $table = 'users';
}