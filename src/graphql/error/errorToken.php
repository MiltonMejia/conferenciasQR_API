<?php

use GraphQL\Error\ClientAware;

class ErrorTokenExpirado extends \Exception implements ClientAware
{
  protected $message = 'El token proporcionado ha expirado';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'token';
  }
}

class ErrorTokenInvalido extends \Exception implements ClientAware
{
  protected $message = 'El token proporcionado es inválido';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'token';
  }
}