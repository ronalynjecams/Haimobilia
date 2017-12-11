<?php
App::uses('DeliveryReceipt', 'Model');

/**
 * DeliveryReceipt Test Case
 */
class DeliveryReceiptTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.delivery_receipt',
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
		$this->DeliveryReceipt = ClassRegistry::init('DeliveryReceipt');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DeliveryReceipt);

		parent::tearDown();
	}

}
