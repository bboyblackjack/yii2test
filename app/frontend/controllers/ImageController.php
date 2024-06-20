<?php

namespace frontend\controllers;

use common\models\Image;
use yii\web\Controller;
use yii\web\Request;

class ImageController extends Controller
{
    private function getLastImage()
    {
        $from = \Yii::$app->params['image.id.from'] ?? 1;
        $to = \Yii::$app->params['image.id.to'] ?? 100;

        $imageIds = Image::find()
            ->select('image_foreign_id')
            ->where([
                '>=', 'image_foreign_id', $from,
            ])
            ->andWhere([
                '<=', 'image_foreign_id', $to,
            ])
            ->orderBy(['image_foreign_id' => SORT_ASC])
            ->column();

        if (empty($imageIds)) {
            return $from;
        }

        $prevId = 0;

        foreach ($imageIds as $key => $id) {
            if ($key == array_key_last($imageIds) && $id < $to) {
                return $id + 1;
            }
            if ($prevId + 1 < $id) {
                return $prevId + 1;
            }
            $prevId++;
        }

        return false;
    }

    private function getImageData()
    {
        $id = $this->getLastImage();

        if (!$id) {
            return [
                'isError' => true,
                'errorMessage' => \Yii::t('app', 'You have already rated all images from this range!')
            ];
        }

        $useProxy = \Yii::$app->params['useProxy'] ?? false;
        $proxy = \Yii::$app->params['proxy'];
        $imageWidth = \Yii::$app->params['image.width'] ?? 600;
        $imageHeight = \Yii::$app->params['image.height'] ?? 500;
        $imageUrlMain = \Yii::$app->params['image.url.main'] ?? 'https://picsum.photos/id';

        $url = "$imageUrlMain/$id/$imageWidth/$imageHeight";

        $ch = curl_init();

        if ($useProxy) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $curlResult = curl_exec($ch);

        if (curl_error($ch)) {
            return [
                'isError' => true,
                'errorMessage' => \Yii::t('app', 'Image receiving error!')
            ];
        }

        curl_close($ch);

        $image = base64_encode($curlResult);

        return [
            'id' => $id,
            'image' => $image,
            'isError' => false,
            'path' => $url
        ];
    }

    public function actionIndex()
    {
        \Yii::$app->view->title = 'Test image application';
        $imageData = $this->getImageData();

        if ($imageData['isError']) {
            return $this->render('index', [
                'isError' => true,
                'errorMessage' => $imageData['errorMessage']
            ]);
        }

        return $this->render('index', $imageData);
    }

    public function actionNextImage()
    {
        return json_encode($this->getImageData());
    }

    public function actionProcessImage(Request $request)
    {
        $model = new Image();
        $model->load([
            'image_foreign_id' => filter_var($request->post('id'), FILTER_SANITIZE_NUMBER_INT),
            'is_accepted' => filter_var($request->post('accept'), FILTER_VALIDATE_BOOLEAN),
            'path' => $request->post('path')
        ], '');

        if (!$model->validate() || !$model->save()) {
            return json_encode($model->errors);
        }

        return true;
    }
}