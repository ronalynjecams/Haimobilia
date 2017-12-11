<?php
/**
 * Collection Fixture
 */
class CollectionFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'quotation_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'paid_amount' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'unsigned' => false),
		'ewt_amount' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'unsigned' => false),
		'other_amount' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'unsigned' => false),
		'balance' => array('type' => 'float', 'null' => false, 'default' => '0.000000', 'length' => '10,6', 'unsigned' => false),
		'cheque_date' => array('type' => 'date', 'null' => true, 'default' => null),
		'bank_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'cheque_number' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'paid_amount' => 1,
			'ewt_amount' => 1,
			'other_amount' => 1,
			'balance' => 1,
			'cheque_date' => '2017-12-11',
			'bank_id' => 1,
			'cheque_number' => 1,
			'created' => '2017-12-11 02:49:18',
			'modified' => '2017-12-11 02:49:18'
		),
	);

}
