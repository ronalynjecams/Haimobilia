<?php
/**
 * QuotationProduct Fixture
 */
class QuotationProductFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'quotation_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'product_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'qty' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'list_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'unsigned' => false),
		'total_price' => array('type' => 'decimal', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'quotation_id' => 1,
			'product_id' => 1,
			'user_id' => 1,
			'qty' => 1,
			'list_price' => '',
			'total_price' => '',
			'created' => '2017-12-07 17:24:01',
			'modified' => '2017-12-07 17:24:01'
		),
	);

}
