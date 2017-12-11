<?php
App::uses('Collection', 'Model');

/**
 * Collection Test Case
 */
class CollectionTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.collection',
		'app.quotation',
		'app.company',
		'app.user',
		'app.bank'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Collection = ClassRegistry::init('Collection');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Collection);

		parent::tearDown();
	}

}
