<?php
namespace Craft;

class DoxterModel extends BaseModel
{
	public static function create()
	{
		return new self;
	}

	public function __toString()
	{
		return $this->text();
	}

	public function text()
	{
		return $this->source;
	}

	public function html(array $params=array())
	{
		return craft()->doxter->parse($this->source, $params);
	}

	public function defineAttributes()
	{
		return array(
			'source'	=> AttributeType::String,
			'output'	=> AttributeType::String,
		);
	}
}