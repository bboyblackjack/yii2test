<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class ImageOperationForm extends Model
{
    public $id;
    public $accept;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'accept'], 'required'],
            ['id', 'integer'],
            ['accept', 'boolean', 'trueValue' => "true", 'falseValue' => "false"],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Image identifier',
            'accept' => 'Is accepted image',
        ];
    }
}
