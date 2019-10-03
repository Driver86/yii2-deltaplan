<?php

use yii\db\Schema;
use jamband\schemadump\Migration;

class m191001_232051_base extends Migration
{
    public function safeUp()
    {
        // city
        $this->createTable('{{%city}}', [
            'id' => $this->primaryKey()->unsigned(),
            'regionId' => $this->integer(10)->unsigned()->notNull(),
            'name' => $this->string(255)->notNull(),
        ], $this->tableOptions);

        // client
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->notNull(),
            'phone' => $this->string(255)->notNull(),
            'vat' => $this->integer(1)->unsigned()->notNull(),
            'cityId' => $this->integer(10)->unsigned()->notNull(),
            'text' => $this->text()->notNull(),
            'logoId' => $this->integer(10)->unsigned()->null(),
            'createdAt' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
            'updatedAt' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
        ], $this->tableOptions);

        // logo
        $this->createTable('{{%logo}}', [
            'id' => $this->primaryKey()->unsigned(),
            'extension' => $this->string(255)->notNull(),
            'name' => $this->string(255)->notNull(),
            'size' => $this->integer(10)->unsigned()->notNull(),
            'createdAt' => $this->timestamp()->notNull()->defaultValue('0000-00-00 00:00:00'),
        ], $this->tableOptions);

        // region
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string(255)->notNull(),
        ], $this->tableOptions);

        // fk: city
        $this->addForeignKey('fk_city_regionId', '{{%city}}', 'regionId', '{{%region}}', 'id');

        // fk: client
        $this->addForeignKey('fk_client_cityId', '{{%client}}', 'cityId', '{{%city}}', 'id');
        $this->addForeignKey('fk_client_logoId', '{{%client}}', 'logoId', '{{%logo}}', 'id');
    }

    public function safeDown()
    {
    }
}
