<?php

/**
 * This file is part of the Nette Framework (http://nette.org)
 *
 * Copyright (c) 2004 David Grudl (http://davidgrudl.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace Nette\Config\Schema;

use Nette;



/**
 * A node in config description schema.
 *
 * @author     David Grudl
 */
class Node extends Nette\Object
{
	/** @var string */
	protected $type;

	/** @var bool */
	protected $required = FALSE;

	/** @var mixed */
	protected $defaultValue;

	/** @var callable */
	protected $normalizer;



	public function __construct($type = NULL, $defaultValue = NULL)
	{
		$this->type = $type;
		$this->defaultValue = $defaultValue;
	}



	/**
	 * @return Node  provides a fluent interface
	 */
	public function setRequired($on = TRUE)
	{
		$this->required = (bool) $on;
		return $this;
	}



	/**
	 * @return Node  provides a fluent interface
	 */
	public function setNormalizer($normalizer)
	{
		$this->normalizer = $normalizer ? callback($normalizer) : NULL;
		return $this;
	}



	public function process($value, $label = NULL)
	{
		if ($this->normalizer) {
			$value = $this->normalizer->__invoke($value, $label);
		}
		if ($value === NULL && !$this->required) {
			return $this->defaultValue;
		}
		if ($this->type) {
			Nette\Utils\Validators::assert($value, $this->type, $label ? $label : 'value');
		}
		return $value;
	}



	/********************* shortcuts ****************d*g**/



	/**
	 * @return Node
	 */
	public static function of($type = NULL, $defaultValue = NULL)
	{
		return new static($type, $defaultValue);
	}



	/**
	 * @return Node
	 */
	public static function bool($defaultValue = NULL)
	{
		return new static(__FUNCTION__, $defaultValue);
	}



	/**
	 * @return Node
	 */
	public static function string($defaultValue = NULL)
	{
		return new static(__FUNCTION__, $defaultValue);
	}



	/**
	 * @return Node
	 */
	public static function int($defaultValue = NULL)
	{
		return new static(__FUNCTION__, $defaultValue);
	}



	/**
	 * @return Node
	 */
	public static function scalar($defaultValue = NULL)
	{
		return new static(__FUNCTION__, $defaultValue);
	}



	/**
	 * @return ArrayNode
	 */
	public static function arrayOf($content, self $additional = NULL)
	{
		if ($content instanceof self) {
			return new ArrayNode('array', NULL, $content);
		} else {
			return new ArrayNode('array', $content, $additional);
		}
	}



	/**
	 * @return ArrayNode
	 */
	public static function listOf(self $additional)
	{
		return new ArrayNode('list', NULL, $additional);
	}

}
