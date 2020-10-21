<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$estado = new ObjectType([

    'name' => 'Estado',
    'fields' => [

        'id' => [
            'type' => Type::id(),
            'description' => 'ID del Estado'
        ],

        'nombre' => [
            'type' => Type::string(),
            'description' => 'Nombre del Estado'
        ]
    ]

]);