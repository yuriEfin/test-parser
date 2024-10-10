<?php

return [
    'class'    => 'yii\db\Connection',
    'dsn'      => $_ENV['DB_POSTGRES_DSN'],
    'username' => $_ENV['PG_ROOT_USER'],
    'password' => $_ENV['PG_ROOT_PASSWORD'],
    'charset'  => 'utf8',
    
    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
