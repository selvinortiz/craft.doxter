<?php
namespace SelvinOrtiz\Doxter\Exception;

class InvalidDependencyContainerException extends \Exception
{
    public function __construct($message = null, $code = 0, $previous = null)
    {
    	if (is_null($message))
    	{
    		$message = 'The dependency injection container is not available.';
    	}

        parent::__construct($message, $code, $previous);
    }
}