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

use Nette,
	Nette\Utils\Validators;



/**
 * A node representing Nette\DI\Statement.
 *
 * @author     David Grudl
 */
class EntityNode extends Node
{

	public function process($value, $label = NULL)
	{
		$value = parent::process($value, $label);
		if ($value === NULL) {

		} elseif ($value instanceof \stdClass && isset($value->value, $value->attributes)) {
			Validators::assert($value->value, 'string|array', $label);
			return new Nette\DI\Statement($value->value, $this->filterArguments($value->attributes));

		} else {
			Validators::assert($value, 'string|array', $label);
			return new Nette\DI\Statement($value);
		}
	}



	/**
	 * Removes ... and replaces entities with Nette\DI\Statement.
	 * @return array
	 */
	public static function filterArguments($args, $label = NULL)
	{
		Validators::assert($args, 'array|null', $label);
		foreach ((array) $args as $k => $v) {
			if ($v === '...') {
				unset($args[$k]);
			} elseif ($v instanceof \stdClass && isset($v->value, $v->attributes)) {
				$args[$k] = new Nette\DI\Statement($v->value, static::filterArguments($v->attributes));
			}
		}
		return $args;
	}

}
