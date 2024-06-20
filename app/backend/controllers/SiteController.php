<?php

namespace backend\controllers;

use common\models\Image;
use Yii;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex($token = null)
    {
        \Yii::$app->view->title = 'Admin | Test image application';

        if ($token == Yii::$app->params['authToken']) {
            $images = Image::find()
                ->select(['id', 'path', 'is_accepted'])
                ->all();
            return $this->render('index', [
                'images' => $images
            ]);
        }
        throw new UnauthorizedHttpException('Please authorize to continue!');
    }

    public function actionCancel($id, $token = null)
    {
        if ($token == Yii::$app->params['authToken']) {
            Image::deleteAll(['id' => $id]);
            return $this->redirect("index.php?r=site/index&token=$token");
        }
        throw new UnauthorizedHttpException('Please authorize to continue!');
    }
}
