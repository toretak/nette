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



Assert::throws(function() {
	Node::arrayOf(Node::bool())->process('a');
}, 'Nette\Utils\AssertionException', "The value expects to be array, string 'a' given.");

Assert::throws(function() {
	Node::listOf(Node::bool())->process(array('a' => NULL));
}, 'Nette\Utils\AssertionException', "The value expects to be list, array(1) given.");

Assert::throws(function() {
	Node::arrayOf(array())->process(array('unexpected' => NULL));
}, 'Nette\Utils\AssertionException', "Found unexpected items: 'unexpected'.");

Assert::throws(function() {
	Node::arrayOf(array(
		'subitem' => Node::bool(),
	))->process(array(
		'subitem' => 'hello',
	));
}, 'Nette\Utils\AssertionException', "The subitem expects to be bool, string 'hello' given.");

Assert::throws(function() {
	Node::arrayOf(array(
		'subitem' => Node::bool()->setRequired(),
	))->process(array());
}, 'Nette\Utils\AssertionException', "Missing required item 'subitem'.");

Assert::throws(function() {
	Node::arrayOf(Node::bool())->setRequired()->process(NULL);
}, 'Nette\Utils\AssertionException', "The value expects to be array, NULL given.");
