<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exchanges".
 *
 * @property int $id
 * @property int $num_code Код валюты
 * @property string $char_code Сокращенное название валюты
 * @property string $name Название валюты
 * @property int $value_currency_from Количество иностранной валюты для обмена
 * @property float $value_currency_to Количество российских рублей в эквиваленте
 */
class Exchange extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exchanges';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['num_code', 'char_code', 'name', 'value_currency_from', 'value_currency_to'], 'required'],
            [['num_code', 'value_currency_from'], 'integer'],
            [['value_currency_to'], 'number'],
            [['char_code'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'num_code' => 'Num Code',
            'char_code' => 'Char Code',
            'name' => 'Name',
            'value_currency_from' => 'Value Currency From',
            'value_currency_to' => 'Value Currency To',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes(): array
    {
        return [
            'id',
            'num_code',
            'char_code',
            'name',
            'value_currency_from',
            'value_currency_to',
        ];
    }

    /**
     * Метод получения курса валюты по её коду
     */
    public function getExchangeByNumCode(int $numCode): Exchange|null
    {
        /** @var Exchange|null $currentExchange */
        $currentExchange = $this->find()
            ->where([
                'num_code' => $numCode
            ])
            ->one();

        return $currentExchange;
    }
}
