<?php

namespace app\controllers;

use app\models\Exchange;
use app\modules\ConverterModule;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class ConverterController extends Controller
{

    public function actionIndex(): string
    {
        $converterModule = new ConverterModule();

        $exchanges = Exchange::find()
            ->orderBy(['id' => SORT_ASC])
            ->all();

        $defaultExchangeRates = $converterModule->getDefaultExchangeRates($exchanges);

        return $this->render('index', [
            'exchanges' => $exchanges,
            'defaultExchangeRates' => $defaultExchangeRates,
        ]);
    }

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

    public function actionGetNewValues(): void
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $changedCurrency = $request->post('changedCurrency');
            $newValueOfCurrency = $request->post('newValueOfCurrency');

            $data = [];

            /** @var Exchange $currentCurrency */
            $currentCurrency = Exchange::find()
                ->where(['char_code' => $changedCurrency])
                ->one();

            $rubValue = ($newValueOfCurrency * $currentCurrency->value_currency_to) / $currentCurrency->value_currency_from;

            $exchanges = Exchange::find()
                ->all();

            /** @var Exchange $exchange */
            foreach ($exchanges as $exchange) {
                $newValue = ($rubValue * $exchange->value_currency_from) / $exchange->value_currency_to;

                $data[] = [
                    'name' => $exchange->char_code,
                    'newValue' => round($newValue, 4)
                ];
            }

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