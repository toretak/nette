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



$schema = Node::arrayOf(array(
	'b1' => Node::bool(),
	'b2' => Node::bool(),
	'b3' => Node::bool(),
	'b4' => Node::bool(TRUE),
	'b5' => Node::bool(TRUE),
	'b6' => Node::bool(TRUE),
));



Assert::same( array(
	'b1' => NULL,
	'b2' => FALSE,
	'b3' => NULL,
	'b4' => TRUE,
	'b5' => FALSE,
	'b6' => TRUE,
), $schema->process(array(
	'b1' => NULL,
	'b2' => FALSE,
	'b4' => NULL,
	'b5' => FALSE,
)));
