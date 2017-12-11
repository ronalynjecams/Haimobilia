<?php
/**
 * Quotation Fixture
 */
class QuotationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'quote_number' => array('type' => 'string', 'null' => false, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'company_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'unsigned' => false),
		'terms' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shipping_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'billing_address' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sub_total' => array('type' => 'decimal', 'null' => false, 'default' => '0', 'length' => '10,0', 'unsigned' => false),
		'delivery_amount' => array('type' => 'decimal', 'null' => false, 'default' => '0', 'length' => '10,0', 'unsigned' => false),
		'installation_amount' => array('type' => 'decimal', 'null' => false, 'default' => '0', 'length' => '10,0', 'unsigned' => false),
		'discount' => array('type' => 'decimal', 'null' => false, 'default' => '0', 'length' => '10,0', 'unsigned' => false),
		'grand_total' => array('type' => 'decimal', 'null' => false, 'default' => '0', 'length' => '10,0', 'unsigned' => false),
		'collection_remarks' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'collection_date' => array('type' => 'date', 'null' => false, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => null),
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
			'quote_number' => 'Lorem ipsum dolor sit amet',
			'company_id' => 1,
			'user_id' => 1,
			'terms' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'shipping_address' => 'Lorem ipsum dolor sit amet',
			'billing_address' => 'Lorem ipsum dolor sit amet',
			'sub_total' => '',
			'delivery_amount' => '',
			'installation_amount' => '',
			'discount' => '',
			'grand_total' => '',
			'collection_remarks' => 'Lorem ipsum dolor sit amet',
			'collection_date' => '2017-12-05',
			'created' => '2017-12-05 00:16:43',
			'modified' => '2017-12-05 00:16:43'
		),
	);

}
