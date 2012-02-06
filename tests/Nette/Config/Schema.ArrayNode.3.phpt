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



$schema = Node::arrayOf(Node::bool());



Assert::same( array(
	'b1' => NULL,
	'b2' => FALSE,
	'b3' => TRUE,
), $schema->process(array(
	'b1' => NULL,
	'b2' => FALSE,
	'b3' => TRUE,
)));
