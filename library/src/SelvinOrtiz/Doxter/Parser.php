<?php
namespace SelvinOrtiz\Doxter;

abstract class Parser
{
	public function isValidString($subject)
	{
		if (empty($subject))
		{
			return false;
		}

		return (bool) (is_string($subject) || is_callable(array($subject, '__toString')));
	}
}
