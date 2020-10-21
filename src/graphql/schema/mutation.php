<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$mutationType = new ObjectType([

    'name' => 'Mutation',
    'fields' => [

        'crearAsistente' => [
            'type' => $asistente,
            'args' => [
                'folio' => Type::nonNull(Type::string()),
                'nombre' => Type::nonNull(Type::string()),
                'apellidoPaterno' => Type::nonNull(Type::string()),
                'apellidoMaterno' => Type::nonNull(Type::string()),
                'estado' => Type::nonNull(Type::int()),
                'correo' => Type::nonNull(Type::string()),
                'telefono' => Type::nonNull(Type::string()),
                'facebook' => Type::nonNull(Type::string()),
                'tipoAsistente' => Type::nonNull(Type::int())
            ],
            'resolve' => function($root, $args){
                $asistente = new ResolveAsistente();
                $datosAsistente = [
                    'folio' => $args['folio'],
                    'nombre' => $args['nombre'],
                    'apellidoPaterno' => $args['apellidoPaterno'],
                    'apellidoMaterno' => $args['apellidoMaterno'],
                    'estado' => $args['estado'],
                    'correo' => $args['correo'],
                    'telefono' => $args['telefono'],
                    'facebook' => $args['facebook'],
                    'tipoAsistente' => $args['tipoAsistente']
                ];

                return $asistente->insertarAsistente($datosAsistente);
            }
        ],

        'crearConferencia' => [
            'type' => $conferencia,
            'args' => [
                'nombre' => Type::nonNull(Type::string()),
                'tipoConferencia' => Type::nonNull(Type::int()),
                'obligatorio' => Type::nonNull(Type::boolean())
            ],
            'resolve' => function($root, $args){
                $conferencia = new resolveConferencias();
                $datosConferencias = [
                    'nombre' => $args['nombre'],
                    'tipoConferencia' => $args['tipoConferencia'],
                    'obligatorio' => $args['obligatorio']
                ];
                
                return $conferencia->insertarConferencia($datosConferencias);
            }
        ],

        'crearRegistroAsistencia' => [
            'type' => $registroAsistencia,
            'args' => [
                'asistente' => Type::nonNull(Type::id()),
                'conferencia' => Type::nonNull(Type::id()),
            ],
            'resolve' => function($root, $args){
                $conferencia = new resolveAsistente();
                $datosConferencias = [
                    'asistente' => $args['asistente'],
                    'conferencia' => $args['conferencia']
                ];
                
                return $conferencia->insertarRegistroAsistencia($datosConferencias);
            }
        ],

    ]

]);