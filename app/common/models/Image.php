<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Image model
 *
 * @property integer $id
 * @property string $path
 * @property integer $image_foreign_id
 * @property boolean $is_accepted
 * @property integer $created_at
 * @property integer $updated_at
 */
class Image extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image_foreign_id', 'is_accepted', 'path'], 'required'],
            ['image_foreign_id', 'integer'],
            ['is_accepted', 'boolean'],
            ['path', 'string'],
        ];
    }
}
