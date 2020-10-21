<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$administrativo = new ObjectType([

    'name' => 'Administrativo',
    'fields' => [

        'usuario' => [
            'type' => Type::string(),
            'description' => 'Nombre de usuario'
        ],
        'privilegio' => [
            'type' => Type::string(),
            'description' => 'Privilegio del usuario'
        ]
    ]

]);