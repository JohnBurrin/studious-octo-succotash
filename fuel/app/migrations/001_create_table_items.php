<?php

namespace Fuel\Migrations;

class Create_table_items
{
	public function up()
	{
		\DBUtil::create_table('items', array(
			'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
			'itemId' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'constraint' => '11'),
			'title' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'globalId' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'primaryCategory' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'galleryURL' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'viewItemURL' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'paymentMethod' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'autoPay' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'postalCode' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'location' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'country' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'shippingInfo' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'sellingStatus' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'listingInfo' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'condition' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'isMultiVariationListing' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'topRatedListing' => array('constraint' => 255, 'type' => 'varchar', 'null' => true,),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
		), array('id', 'itemId'));
	}

	public function down()
	{
		\DBUtil::drop_table('items');
	}
}