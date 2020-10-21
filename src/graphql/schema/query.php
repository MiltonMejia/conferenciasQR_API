<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [

        'totalAsistentes' => [
            'description' => 'Lista de todos los asistentes registrados',
            'type' => Type::ListOf($asistente),
            'resolve' => function(){
                $asistentes = new ResolveAsistente();
                return $asistentes->obtenerTotalAsistentes();
            }
        ],

        'totalConferencias' => [
            'type' => Type::listOf($conferencia),
            'description' => 'Lista de todas las conferencias registradas',
            'resolve' => function(){
                $conferencias = new ResolveConferencia();
                return $conferencias->obtenerTotalConferencias();
            }
        ],

        'totalEstados' => [
            'type' => Type::listOf($estado),
            'description' => 'Lista de todas las conferencias registradas',
            'resolve' => function(){
                $conferencias = new ResolveEstado();
                return $conferencias->obtenerTotalEstados();
            }
        ],

        'administrativo' => [
            'type' => $administrativo,
            'description' => 'Información de un asistente mediante su ID',
            'args' => [
                'usuario' => Type::nonNull(Type::string()),
                'contrasena' => Type::nonNull(Type::string())
            ],
            'resolve' => function($root, $args){
                $administrativo = new ResolveAdministrativo();
                return $administrativo->obtenerAdministrativo($args['usuario'],$args['contrasena']);
            }
        ],

        'asistente' => [
            'type' => $asistente,
            'description' => 'Información de un asistente mediante su ID',
            'args' => [
                'id' => Type::id(),
                'nombre' => Type::string(),
                'apellidoPaterno' => Type::string(),
                'apellidoMaterno' => Type::string()
            ],
            'resolve' => function($root, $args){
                if(!empty($args['id']) && empty($args['nombre']) && empty($args['apellidoPaterno']) && empty($args['apellidoMaterno']))
                {
                    $asistente = new ResolveAsistente();
                    return $asistente->obtenerAsistente($args['id'], true);
                }
                else if(empty($args['id']) && !empty($args['nombre']) && !empty($args['apellidoPaterno']) && !empty($args['apellidoMaterno']))
                {
                    $asistente = new ResolveAsistente();
                    return $asistente->obtenerAsistenteBusqueda($args['nombre'], $args['apellidoPaterno'], $args['apellidoMaterno']);
                }
                else
                {
                    throw new ErrorArgumentosQuery;
                }
            }
        ],

        'conferencia' => [
            'type' => $conferencia,
            'description' => 'Información de la conferencia seleccionada por ID',
            'args' => [
                'id' => Type::nonNull(Type::id())
            ],
            'resolve' => function($root, $args){
                $conferencia = new ResolveConferencia();
                return $conferencia->obtenerConferencia($args['id']);
            }
        ],
    ]
    
]);