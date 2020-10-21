<?php

use GraphQL\Error\ClientAware;

class ErrorAsistenciaDuplicado extends \Exception implements ClientAware
{
  protected $message = 'Ya se ha registrado anteriormente una asistencia';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'duplicado';
  }
}

class ErrorAsistenciaInterna extends \Exception implements ClientAware
{
  protected $message = 'No se ha podido registrar la asistencia, inténtelo más tarde';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'internal';
  }
}

class ErrorAsistenteDuplicado extends \Exception implements ClientAware
{
  protected $message = 'Ya se ha registrado anteriormente a este usuario';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'duplicado';
  }
}

class ErrorAsistenteInterno extends \Exception implements ClientAware
{
  protected $message = 'Ha ocurrido un error al momento de registrar a este usuario, inténtelo más tarde';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'internal';
  }
}

class ErrorArgumentosQuery extends \Exception implements ClientAware
{
  protected $message = 'Verifique que los campos de búsqueda no estén vacíos e inténtelo de nuevo';

  public function isClientSafe()
  {
      return true;
  }

  public function getCategory()
  {
      return 'internal';
  }
}