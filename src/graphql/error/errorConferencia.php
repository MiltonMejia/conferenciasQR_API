<?php

use GraphQL\Error\ClientAware;

class ErrorConferenciaInterna extends \Exception implements ClientAware
{
  protected $message = 'No se ha podido registrar la conferencia, intente más tarde';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'internal';
  }
}