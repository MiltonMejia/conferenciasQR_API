<?php

use GraphQL\Error\ClientAware;

class ErrorAdministrativoInvalido extends \Exception implements ClientAware
{
  protected $message = 'Verifique el usuario y/o contraseña e inténtelo de nuevo';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'credenciales';
  }
}
