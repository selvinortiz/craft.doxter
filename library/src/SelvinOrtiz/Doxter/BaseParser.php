<?php
namespace SelvinOrtiz\Doxter;

use SelvinOrtiz\Zit\IZit;

abstract class BaseParser implements ParserInterface
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
