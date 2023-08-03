<?php

namespace app\controllers;

use app\models\Exchange;
use app\modules\ConverterModule;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ConverterController extends Controller
{

    public float $rubValue = 100;

    /**
     * Эндпоинт для отображения самого конвертера валют
     */
    public function actionIndex(): string
    {
        $converterModule = new ConverterModule();

        $exchanges = Exchange::find()->orderBy(['id' => SORT_ASC])->all();

        $defaultExchangeRates = $converterModule->getDefaultExchangeRates($exchanges, $this->rubValue);

        return $this->render('index', [
            'exchanges' => $exchanges,
            'defaultExchangeRates' => $defaultExchangeRates,
        ]);
    }

    /**
     * Эндпоинт для обновления курса валют
     */
    public function actionUpdateExchanges(): string
    {
        $converterModule = new ConverterModule();
        $converterModule->updateExchanges();

        if (!empty($converterModule->errors)) {
            return $this->render('update/failed', [
                'errors' => $converterModule->errors,
            ]);
        }

        return $this->render('update/success');
    }

    /**
     * Эндпоинт для получения пересчитанных значений валют
     */
    public function actionGetNewValues(): void
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $changedCurrency = $request->post('changedCurrency');
            $newValueOfCurrency = $request->post('newValueOfCurrency');

            $converterModule = new ConverterModule();

            /** @var Exchange $currentCurrency */
            $currentCurrency = Exchange::find()->where(['char_code' => $changedCurrency])->one();
            $exchanges = Exchange::find()->all();

            $this->rubValue = ($newValueOfCurrency * $currentCurrency->value_currency_to) / $currentCurrency->value_currency_from;

            $data = $converterModule->getDefaultExchangeRates($exchanges, $this->rubValue);

            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = [
                'success' => true,
                'data' => $data,
            ];

            $response->send();
        }
    }
}