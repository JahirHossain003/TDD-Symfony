<?php
namespace AppBundle\Exception;


use Exception as ExceptionAlias;

class NotABuffetException extends ExceptionAlias
{
      protected $message = "Dont put Non-Carnivorous with Carnivorous Dinosaur. it will be a mess";
}
