<?php
namespace SelvinOrtiz\Doxter;

use SelvinOrtiz\Zit\Zit;

class Doxter extends Zit
{
	public function init()
	{
		// Define parser dependencies
		doxter()->stash('parser', new DoxterParser);
		doxter()->stash('parsedown', \Parsedown::instance());
		doxter()->stash('headerParser', new HeaderParser);
		doxter()->stash('markdownParser', new MarkdownParser);
		doxter()->stash('referenceTagParser', new ReferenceTagParser);
	}

	protected function pop($id, $args=array() )
	{
		try
		{
			return parent::pop($id, $args);
		}
		catch (\Exception $e)
		{
			throw new Exception\MissingDependencyException($id);
		}
	}
}


/**
 * A way to grab the dependency container within the Doxter namespace
 */
if (!function_exists('\\SelvinOrtiz\\Doxter\\doxter'))
{
	function doxter()
	{
		return \SelvinOrtiz\Doxter\Doxter::getInstance();
	}
}
