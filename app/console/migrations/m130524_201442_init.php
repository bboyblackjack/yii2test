<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'path' => $this->string()->notNull(),
            'is_accepted' => $this->boolean()->notNull()->defaultValue(false),
            'image_foreign_id' => $this->integer()->unique()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%images}}');
    }
}
