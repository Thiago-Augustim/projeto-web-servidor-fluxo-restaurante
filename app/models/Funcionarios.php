<?php

return [
    [
        'id' => 1,
        'nome' => 'Root Garcom',
        'usuario' => 'root.garcom',
        'especialidade' => 'garcom',
        'senha' => password_hash('123456', PASSWORD_DEFAULT)
    ],
    [
        'id' => 2,
        'nome' => 'Root Cozinha',
        'usuario' => 'root.cozinha',
        'especialidade' => 'cozinha',
        'senha' => password_hash('123456', PASSWORD_DEFAULT)
    ],
    [
        'id' => 3,
        'nome' => 'Root Gerente',
        'usuario' => 'root.gerente',
        'especialidade' => 'gerente',
        'senha' => password_hash('123456', PASSWORD_DEFAULT)
    ],
];