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
	'b1' => Node::bool(FALSE),
),	Node::bool(TRUE));



Assert::same( array(
	'b1' => FALSE,
	'b2' => TRUE,
	'b3' => TRUE,
), $schema->process(array(
	'b1' => NULL,
	'b2' => NULL,
	'b3' => TRUE,
)));
