<?php
   use yii\db\Schema;
use yii\db\Migration;

class m170417_155901_categories extends Migration
{
    public function up()
    {
$this->createTable('categories', [
            'id' => Schema::TYPE_PK,
            'categories' => Schema::TYPE_STRING,
         
        ]);

$this->insert('categories', [
            'id' => 1,
            'categories' => 'Cars',
        ]);
$this->insert('categories', [
            'id' => 2,
            'categories' => 'Mobiles',
        ]);
$this->insert('categories', [
            'id' => 3,
            'categories' => 'Tablets',
        ]);
    }

    public function down()
    {
        echo "m170417_155901_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
