<?php

namespace Fuel\Migrations;

class Create_table_k100
{
    public function up()
    {
        \DBUtil::create_table('gs500', array(
            'id' => array('type' => 'bigint', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
            'itemId' => array('type' => 'bigint', 'unsigned' => true, 'null' => false, 'constraint' => '11'),
            'title' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'globalId' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'primaryCategory' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'galleryURL' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'viewItemURL' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'paymentMethod' => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'autoPay' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'postalCode' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'location' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'country' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'shippingInfo' => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'sellingStatus' => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'listingInfo' => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'condition' => array('constraint' => 512, 'type' => 'varchar', 'null' => true),
            'isMultiVariationListing' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'topRatedListing' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'sellerUserName' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'feedbackScore' => array('type' => 'bigint', 'unsigned' => true, 'null' => true, 'constraint' => '11'),
            'storeName' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'storeURL' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
            'categoryId' => array('type' => 'bigint', 'unsigned' => true, 'null' => true, 'constraint' => '11'),
            'created_at' => array('constraint' => 11, 'type' => 'bigint', 'null' => true),
            'updated_at' => array('constraint' => 11, 'type' => 'bigint', 'null' => true),
        ), array('id', 'itemId'));
    }

    public function down()
    {
        \DBUtil::drop_table('k100');
    }
}
