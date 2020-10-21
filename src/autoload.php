<?php

require_once 'src/config/credenciales.php';
require_once 'src/config/conexionBD.php';
require_once 'src/config/token.php';

require_once 'src/graphql/error/errorAdministrativo.php';
require_once 'src/graphql/error/errorAsistente.php';
require_once 'src/graphql/error/errorConferencia.php';
require_once 'src/graphql/error/errorToken.php';

require_once 'src/graphql/schema/administrativo.php';
require_once 'src/graphql/schema/estado.php';
require_once 'src/graphql/schema/conferencia.php';
require_once 'src/graphql/schema/asistente.php';
require_once 'src/graphql/schema/query.php';
require_once 'src/graphql/schema/mutation.php';

require_once 'src/graphql/resolve/resolveAdministrativo.php';
require_once 'src/graphql/resolve/resolveConferencia.php';
require_once 'src/graphql/resolve/resolveAsistente.php';
require_once 'src/graphql/resolve/resolveEstado.php';