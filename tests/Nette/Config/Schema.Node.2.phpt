<?php

/**
 * Test: Nette\Config\Schema: Node errors
 *
 * @author     David Grudl
 * @package    Nette\Config
 * @subpackage UnitTests
 */

use Nette\Config\Schema\Node;



require __DIR__ . '/../bootstrap.php';



Assert::throws(function() {
	Node::bool()->process('');
}, 'Nette\Utils\AssertionException', "The value expects to be bool, string '' given.");

Assert::throws(function() {
	Node::string()->process(1);
}, 'Nette\Utils\AssertionException', "The value expects to be string, integer given.");

Assert::throws(function() {
	Node::string()->setRequired()->process(NULL);
}, 'Nette\Utils\AssertionException', "The value expects to be string, NULL given.");
