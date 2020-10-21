<?php

require_once 'vendor/autoload.php';
require_once 'src/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

use GraphQL\Error\Debug;
$debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;


$schema = new Schema([
    'query' => $queryType,
    'mutation' => $mutationType,
]);

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'];
$variableValues = isset($input['variables']) ? $input['variables'] : null;

try {
    $servidor = $_SERVER["HTTP_ORIGIN"];
    if($servidor == "")
    {
        header('Access-Control-Allow-Origin: ');
    }
    else
    {
        header('Access-Control-Allow-Origin: ""');
    }
    $result = GraphQL::executeQuery($schema, $query)->toArray();
    $status = 200;
} catch (\Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage()
            ]
        ]
    ];
}

header('Content-Type: application/json', true, $status);
header("Access-Control-Allow-Headers: Origin, Content-Type, Token, Tokenqr");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Expose-Headers: Origin, Content-Type, Token, Tokenqr");
echo json_encode($result);