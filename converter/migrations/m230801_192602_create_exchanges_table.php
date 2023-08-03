<?php

use yii\db\Migration;

/**
 * Handles the creation of table `exchanges`.
 */
class m230801_192602_create_exchanges_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        if (is_null($this->db->getTableSchema('exchanges'))) {
            $this->createTable('exchanges', [
                'id' => $this->primaryKey(),
                'num_code' => $this->integer(10)->notNull()->comment('Код валюты'),
                'char_code' => $this->string(10)->notNull()->comment('Сокращенное название валюты'),
                'name' => $this->string(255)->notNull()->comment('Название валюты'),
                'value_currency_from' => $this->integer(10)->notNull()->comment('Количество иностранной валюты для обмена'),
                'value_currency_to' => $this->float(4)->notNull()->comment('Количество российских рублей в эквиваленте')
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        if (!is_null($this->db->getTableSchema('exchanges'))) {
            $this->dropTable('exchanges');
        }
    }
}
