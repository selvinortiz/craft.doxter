<?php
namespace SelvinOrtiz\Doxter;

/**
 * Dependency Injection Container
 *
 * @package	SelvinOrtiz\Doxter
 */
class Di extends \SelvinOrtiz\Zit\Zit
{
	public function init()
	{
		// Define parser dependencies
		static::getInstance()->stash('doxter', new Doxter);
		static::getInstance()->stash('parsedown', \Parsedown::instance());
		static::getInstance()->stash('headerParser', new HeaderParser);
		static::getInstance()->stash('markdownParser', new MarkdownParser);
		static::getInstance()->stash('referenceTagParser', new ReferenceTagParser);
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
