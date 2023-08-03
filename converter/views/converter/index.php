<?php

/** @var array $exchanges */
/** @var Exchange $exchange */

/** @var array $defaultExchangeRates */

use app\models\Exchange;

?>

<div>
    <div>
        <a href="https://bankiros.ru/converter">Конвертер валют ЦБ РФ</a>
    </div>
    <div>
        <ul>
            <li>
                <span>Сегодня</span>
            </li>
        </ul>
    </div>
    <div>
        <div>
            <div>
                <form id="exchanges">
                    <?php foreach ($exchanges as $key => $exchange): ?>
                        <div>
                            <label>
                                <input class="currency-value" name="<?= $exchange->char_code; ?>-value" value="<?= $defaultExchangeRates[$exchange->char_code]['value']; ?>" id="<?= $exchange->char_code; ?>">
                            </label>
                            <span><?= $exchange->char_code; ?></span>
                            <img src="https://store.bankiros.ru/images/icons/flags/round/russia.svg"
                                 alt="<?= $exchange->char_code; ?>-icon">
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</div>