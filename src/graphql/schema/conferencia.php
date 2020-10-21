<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\InterfaceType;
use GraphQL\Type\Definition\Type;

$conferencia = new ObjectType([

    'name' => 'Conferencia',
    'fields' => [

        'id' => [
            'type' => Type::id(),
            'description' => 'ID de la conferencia'
        ],

        'nombre' => [
            'type' => Type::string(),
            'description' => 'Nombre de la conferencia'
        ],

        'tipoConferencia' => [
            'type' => Type::string(),
            'description' => 'Tipo de conferencia: taller o competencia'
        ],

        'obligatorio' => [
            'type' => Type::boolean(),
            'description' => 'Obligatoriedad de la conferencia'
        ]
    ]

]);