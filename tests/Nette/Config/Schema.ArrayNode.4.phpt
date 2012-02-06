<?php

/**
 * Test: Nette\Config\Schema: ArrayNode
 *
 * @author     David Grudl
 * @package    Nette\Config
 * @subpackage UnitTests
 */

use Nette\Config\Schema\Node;



require __DIR__ . '/../bootstrap.php';



$schema = Node::listOf(Node::bool());



Assert::same(
	array(NULL, FALSE, TRUE),
	$schema->process(array(NULL, FALSE, TRUE))
);


Assert::same(
	array(TRUE, Nette\Config\Helpers::EXTENDS_KEY => TRUE),
	$schema->allowInheritance()->process(array(TRUE, Nette\Config\Helpers::EXTENDS_KEY => TRUE))
);
