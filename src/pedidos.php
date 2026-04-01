<?php


$pedidos = [
    [
        'id'            => 1,
        'mesa_id'       => 2,
        'status'        => 'aberto',
        'data_abertura' => '19:03',
        'itens'         => [
            ['nome_item' => 'X-Burguer',     'tipo' => 'comida',  'quantidade' => 2, 'status' => 'entregue',   'hora' => '19:05'],
            ['nome_item' => 'Coca-Cola 350ml','tipo' => 'bebida',  'quantidade' => 2, 'status' => 'entregue',   'hora' => '19:05'],
            ['nome_item' => 'Batata Frita',  'tipo' => 'comida',  'quantidade' => 1, 'status' => 'preparando', 'hora' => '19:20'],
        ],
    ],
    [
        'id'            => 2,
        'mesa_id'       => 5,
        'status'        => 'aberto',
        'data_abertura' => '19:45',
        'itens'         => [
            ['nome_item' => 'Frango Grelhado','tipo' => 'comida', 'quantidade' => 1, 'status' => 'pendente',   'hora' => '19:47'],
            ['nome_item' => 'Suco de Laranja','tipo' => 'bebida', 'quantidade' => 2, 'status' => 'pendente',   'hora' => '19:47'],
        ],
    ],
    [
        'id'            => 3,
        'mesa_id'       => 1,
        'status'        => 'fechado',
        'data_abertura' => '18:10',
        'itens'         => [
            ['nome_item' => 'Pizza Calabresa','tipo' => 'comida', 'quantidade' => 1, 'status' => 'entregue',   'hora' => '18:30'],
            ['nome_item' => 'Cerveja Long Neck','tipo' => 'bebida','quantidade' => 4,'status' => 'entregue',   'hora' => '18:15'],
        ],
    ],
    [
        'id'            => 4,
        'mesa_id'       => 8,
        'status'        => 'aberto',
        'data_abertura' => '20:00',
        'itens'         => [
            ['nome_item' => 'Risoto de Cogumelo','tipo' => 'comida','quantidade' => 2,'status' => 'preparando','hora' => '20:05'],
        ],
    ],
    [
        'id'            => 5,
        'mesa_id'       => 3,
        'status'        => 'fechado',
        'data_abertura' => '17:30',
        'itens'         => [
            ['nome_item' => 'Prato Feito',   'tipo' => 'comida',  'quantidade' => 3, 'status' => 'entregue',  'hora' => '17:45'],
            ['nome_item' => 'Água Mineral',  'tipo' => 'bebida',  'quantidade' => 3, 'status' => 'entregue',  'hora' => '17:35'],
        ],
    ],
    [
        'id'            => 6,
        'mesa_id'       => 10,
        'status'        => 'aberto',
        'data_abertura' => '20:30',
        'itens'         => [],
    ],
];