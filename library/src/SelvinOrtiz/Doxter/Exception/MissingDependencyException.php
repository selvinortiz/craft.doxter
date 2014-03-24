<?php
namespace SelvinOrtiz\Doxter\Exception;

class MissingDependencyException extends \Exception
{
	public function __construct($dependency = null, $code = 0, $previous = null)
	{
		$message = sprintf('The (%s) dependency has not been registered and could not be resolved.', $dependency);

		parent::__construct($message, $code, $previous);
	}
}