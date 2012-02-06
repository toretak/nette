<?php

/**
 * Test: Nette\Config\Schema: Node
 *
 * @author     David Grudl
 * @package    Nette\Config
 * @subpackage UnitTests
 */

use Nette\Config\Schema\Node;



require __DIR__ . '/../bootstrap.php';



Assert::equal( NULL, Node::bool()->process(NULL) );
Assert::equal( TRUE, Node::bool()->process(TRUE) );
Assert::equal( FALSE, Node::bool()->process(FALSE) );
Assert::equal( TRUE, Node::bool(TRUE)->process(NULL) );
Assert::equal( FALSE, Node::bool(TRUE)->process(FALSE) );
Assert::equal( FALSE, Node::bool(FALSE)->process(NULL) );
Assert::equal( TRUE, Node::bool(FALSE)->process(TRUE) );

Assert::equal( NULL, Node::string()->process(NULL) );
Assert::equal( '', Node::string('')->process(NULL) );
Assert::equal( 'hello', Node::string('')->process('hello') );

Assert::equal( NULL, Node::int()->process(NULL) );
Assert::equal( 0, Node::int(0)->process(NULL) );
Assert::equal( 1, Node::int(0)->process(1) );

Assert::equal( NULL, Node::scalar()->process(NULL) );
Assert::equal( 0, Node::scalar()->process(0) );
Assert::equal( 1.0, Node::scalar()->process(1.0) );
