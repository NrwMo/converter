<?php

namespace app\modules;

use app\models\Exchange;

class ConverterModule
{
    public array $errors = [];
    /**
     * Метод получения актуальных курсов валют по отношению к рос. рублю
     */
    public function getActualExchange(): array
    {
        $ch = curl_init('www.cbr.ru/scripts/XML_daily.asp?date_req='.date('d/m/Y'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        $xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);

        return json_decode($json, true);
    }

    /**
     * Метод обновления курсов валют в базе на основании актуальных данных
     */
    public function updateExchanges(): void
    {
        $data = $this->getActualExchange();

        $this->addDefaultExchange();

        foreach ($data['Valute'] as $currencyInfo) {
            $exchange = new Exchange();

            $currentExchange = $exchange->getExchangeByNumCode($currencyInfo['NumCode']);

            if (!is_null($currentExchange)) {
                $exchange = $currentExchange;
            }

            $exchange->num_code = $currencyInfo['NumCode'];
            $exchange->char_code = $currencyInfo['CharCode'];
            $exchange->name = $currencyInfo['Name'];
            $exchange->value_currency_from = $currencyInfo['Nominal'];
            $exchange->value_currency_to = floatval(str_replace(',', '.', $currencyInfo['Value']));

            if (!$exchange->validate() || !$exchange->save()) {
                $this->errors[] = $exchange->errors;
            }
        }


    }

    public function addDefaultExchange(): void
    {
        $exchange = new Exchange();

        $currentExchange = $exchange->getExchangeByNumCode(0);

        if (!is_null($currentExchange)) {
            $exchange = $currentExchange;
        }

        $exchange->num_code = 0;
        $exchange->char_code = 'RUB';
        $exchange->name = 'Российский рубль';
        $exchange->value_currency_from = 100;
        $exchange->value_currency_to = 100;

        if (!$exchange->validate() || !$exchange->save()) {
            $this->errors[] = $exchange->errors;
        }
    }

    public function getDefaultExchangeRates(array $exchanges): array
    {
        $result = [];

        $exchange = new Exchange();
        $defaultCurrency = $exchange->getExchangeByNumCode(0);

        /** @var Exchange $exchange */
        foreach ($exchanges as $exchange) {
            $result[$exchange->char_code] = ($defaultCurrency->value_currency_from * $exchange->value_currency_from) / $exchange->value_currency_to;
        }

        return $result;
    }
}