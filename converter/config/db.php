<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=host.docker.internal:3306;dbname=converter',
    'username' => 'root',
    'password' => 'converter',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
