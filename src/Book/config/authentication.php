<?php
return [
    'realm' => 'ZendCon2017 Book API',
    'pdo' => [
        'dsn' => 'sqlite:' . __DIR__ . '/../../../data/books.sq3',
        'table' => 'user',
        'field' => [
            'username' => 'username',
            'password' => 'password'
        ]
    ]
];
