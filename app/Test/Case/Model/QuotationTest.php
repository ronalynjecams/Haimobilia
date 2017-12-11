<?php
App::uses('Quotation', 'Model');

/**
 * Quotation Test Case
 */
class QuotationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.quotation',
		'app.company',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Quotation = ClassRegistry::init('Quotation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Quotation);

		parent::tearDown();
	}

}
