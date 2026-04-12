<?php

return [
    [
        'id' => 1,
        'nome' => 'João Silva',
        'usuario' => 'joao.silva',
        'especialidade' => 'garcom',
        'senha' => password_hash('123456', PASSWORD_DEFAULT)
    ],
    [
        'id' => 2,
        'nome' => 'Maria Oliveira',
        'usuario' => 'maria.oliveira',
        'especialidade' => 'garcom',
        'senha' => password_hash('123456', PASSWORD_DEFAULT)
    ],
    [
        'id' => 3,
        'nome' => 'Carlos Souza',
        'usuario' => 'carlos.souza',
        'especialidade' => 'cozinha',
        'senha' => password_hash('123456', PASSWORD_DEFAULT)
    ],
];