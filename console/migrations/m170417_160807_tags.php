<?php
   use yii\db\Schema;

use yii\db\Migration;

class m170417_160807_tags extends Migration
{
    public function up()
    {
   
$this->createTable('tags', [
            'id' => Schema::TYPE_PK,
            'tags' => Schema::TYPE_STRING,
         
        ]);
$this->insert('tags', [
            'id' => 1,
            'tags' => 'toyota',
        ]);
$this->insert('tags', [
            'id' => 2,
            'tags' => 'honda',
        ]);
$this->insert('tags', [
            'id' => 3,
            'tags' => 'gmc',
        ]);
$this->insert('tags', [
            'id' => 4,
            'tags' => 'automatic',
        ]);
$this->insert('tags', [
            'id' => 5,
            'tags' => 'manual',
        ]);
$this->insert('tags', [
            'id' => 6,
            'tags' => 'hybrid',
        ]);
    $this->insert('tags', [
            'id' => 7,
            'tags' => 'gas',
        ]);
    $this->insert('tags', [
            'id' => 8,
            'tags' => 'iphone',
        ]);
    $this->insert('tags', [
            'id' => 9,
            'tags' => 'galaxy s',
        ]);
    $this->insert('tags', [
            'id' => 10,
            'tags' => 'galaxy note',
        ]);

    $this->insert('tags', [
            'id' => 11,
            'tags' => 'black',
        ]);
    $this->insert('tags', [
            'id' => 12,
            'tags' => 'white',
        ]);
    $this->insert('tags', [
            'id' => 13,
            'tags' => 'ipad and galaxy tab',
        ]);

    }

    public function down()
    {
        echo "m170417_160807_tags cannot be reverted.\n";

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
