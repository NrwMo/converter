<?php

/** @var array $exchanges */
/** @var Exchange $exchange */

/** @var array $defaultExchangeRates */

use app\models\Exchange;

?>


<div class="xxx-currency-grid__block xxx-currency-grid__block--separately ">
    <div class="xxx-line-h-1 xxx-mb-15">
        <a href="https://bankiros.ru/converter" class="xxx-text-bold xxx-fs-18 xxx-g-link xxx-g-link--no-bd">Конвертер валют ЦБ РФ</a>
    </div>
    <div class="xxx-tab-list-wrap xxx-tab-list-wrap--pt-0 xxx-tab-list-wrap--only-border-light xxx-mb-15">
        <ul class="xxx-tab__list xxx-tab__list--fix-scrollbar xxx-tab__list--overflow-auto">
            <li class="xxx-tab__item xxx-tab__item--p-b-5 active" data-tab="today">
                <span class="xxx-fs-14"> Сегодня </span>
            </li>
        </ul>
    </div>
    <div class="xxx-tab__content">
        <div class="xxx-tab__body active" id="today">
            <div class="blk-grid-content blk-grid-content--gap-10 ">
                <form id="exchanges">
                    <?php foreach ($exchanges as $key => $exchange): ?>
                        <div class="xxx-input-converter">
                            <input class="xxx-input-converter__input xxx-full-width"
                                   name="<?= $exchange->char_code; ?>-value"
                                   value="<?= $defaultExchangeRates[$exchange->char_code]['value']; ?>"
                                   id="<?= $exchange->char_code; ?>"
                            >
                            <span class="xxx-input-converter__before-text"><?= $exchange->char_code; ?></span>
<!--                            <img src="https://store.bankiros.ru/images/icons/flags/round/russia.svg"-->
<!--                                 alt="--><?php //= $exchange->char_code; ?><!---icon">-->
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
        </div>
    </div>
</div>