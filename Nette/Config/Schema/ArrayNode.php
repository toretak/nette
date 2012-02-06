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
 * An array node in config description schema.
 *
 * @author     David Grudl
 */
class ArrayNode extends Node
{
	/** @var array of Node */
	protected $items;

	/** @var Node */
	protected $additional;

	/** @var bool */
	protected $allowInheritance;



	public function __construct($type, array $items = NULL, Node $additional = NULL)
	{
		parent::__construct($type);
		$this->items = $items;
		$this->additional = $additional;
		$this->defaultValue = $items ? array() : NULL;

		foreach ((array) $items as $key => $item) {
			if (!$item instanceof Node) {
				throw new Nette\InvalidArgumentException;
			} elseif (!$item->required && $item->defaultValue !== NULL) {
				$this->defaultValue[$key] = $item->defaultValue;
			}
		}
	}



	/**
	 * @return ArrayNode  provides a fluent interface
	 */
	public function allowInheritance($on = TRUE)
	{
		$this->allowInheritance = $on;
		return $this;
	}



	public function process($value, $label = NULL)
	{
		$parent = $this->allowInheritance ? Nette\Config\Helpers::takeParent($value) : NULL;
		$value = parent::process($value, $label);
		if ($value === NULL) {
			return;
		}

		$label .= $label ? '|' : '';
		$res = array();
		if ($this->items) {
			foreach ($this->items as $key => $item) {
				if (!array_key_exists($key, $value) && $item->required) {
					throw new Nette\Utils\AssertionException("Missing required item '$label$key'.");
				}
				$res[$key] = $item->process(isset($value[$key]) ? $value[$key] : NULL, "$label$key");
				unset($value[$key]);
			}
		}

		if ($this->additional) {
			foreach ($value as $key => $item) {
				$res[$key] = $this->additional->process($item, "$label$key");
			}

		} elseif ($value) {
			throw new Nette\Utils\AssertionException("Found unexpected items: '$label" . implode("', '$label", array_keys($value)) . "'.");
		}

		if ($parent) {
			$res[Nette\Config\Helpers::EXTENDS_KEY] = $parent;
		}
		return $res;
	}

}
