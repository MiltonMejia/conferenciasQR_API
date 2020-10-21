<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$registroAsistencia = new ObjectType([

    'name' => 'RegistroAsistencia',
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
        ],
        
        'horaRegistro' => [
            'type' => Type::string(),
            'description' => 'Se muestra la hora de registro a la conferencia por parte del asistente si asi se ha seleccionado en la busqueda'
        ]
    ]

]);

$asistente = new ObjectType([
    'name' => 'Asistente',
    'fields' => [

        'id' => [
            'type' => Type::id(),
            'description' => 'ID del asistente'
        ],

        'folio' => [
            'type' => Type::string(),
            'description' => 'Número de folio del boleto del asistente'
        ],

        'nombre' => [
            'type' => Type::string(),
            'description' => 'Nombre del asistente'
        ],

        'apellidoPaterno' => [
            'type' => Type::string(),
            'description' => 'Apellido Paterno del asistente'
        ],

        'apellidoMaterno' => [
            'type' => Type::string(),
            'description' => 'Apellido Materno del asistente'
        ],

        'estado' => [
            'type' => Type::string(),
            'description' => 'Estado donde nació el asistente'
        ],

        'correo' => [
            'type' => Type::string(),
            'description' => 'Correo electronico del asistente'
        ],

        'telefono' => [
            'type' => Type::string(),
            'description' => 'Numero de telefono del asistente'
        ],

        'facebook' => [
            'type' => Type::string(),
            'description' => 'Nombre de perfil en Facebook del asistente'
        ],

        'tipoAsistente' => [
            'type' => Type::string(),
            'description' => 'Tipo de asistente de las conferencias: alumno o invitado'
        ],

        'conferencias' => [
            'type' => Type::listOf($registroAsistencia),
            'description' => 'Lista de las conferencias a las que se ha asistido'
        ]

    ]
]);