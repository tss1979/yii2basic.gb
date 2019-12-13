<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calendar}}`.
 */
class m191212_170306_create_calendar_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%calendar}}', [
            'id' => $this->primaryKey(),
        ]);
        $this->addColumn('{{%calendar}}', 'user_id', $this->bigInteger());
        $this->addColumn('{{%calendar}}', 'action_id', $this->bigInteger());
        $this->addColumn('{{%calendar}}', 'created_at', $this->bigInteger());
        $this->addColumn('{{%calendar}}', 'updated_at', $this->bigInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%calendar}}');

    }
}
