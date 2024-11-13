<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arResult
 */

// Вывод ошибок формы
if ($arResult["isFormErrors"] == "Y"):?>
    <div class="form-errors"><?= $arResult["FORM_ERRORS_TEXT"]; ?></div>
<?endif;?>

<?= $arResult["FORM_NOTE"] ?? '' ?>

<?if ($arResult["isFormNote"] != "Y"):?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= htmlspecialchars($arResult["arForm"]["NAME"]) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <link rel="shortcut icon" href="/build/images/favicon.604825ed.ico" type="image/x-icon">
    <link href="/local/templates/form.result.new/new_template/build/css/common.css" rel="stylesheet">
</head>
<body>
    <div class="contact-form">
        <div class="contact-form__head">
            <div class="contact-form__head-title">Связаться</div>
            <div class="contact-form__head-text">Наши сотрудники помогут выполнить подбор услуги и расчет цены с учетом ваших требований.</div>
        </div>
        <form class="contact-form__form" action="<?= POST_FORM_ACTION_URI ?>" method="POST">
            <?= bitrix_sessid_post(); // Вставка сессионного идентификатора ?>
            
            <!-- Контейнер для ввода данных -->
            <div class="contact-form__form-inputs">
                <?php
                foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion):
                    if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden'):
                        echo $arQuestion["HTML_CODE"];
                    else: ?>
                        <div class="input contact-form__input">
                            <label class="input__label" for="<?= $arQuestion['SID'] ?>">
                                <div class="input__label-text"><?= $arQuestion["CAPTION"] ?><?php if ($arQuestion["REQUIRED"] == "Y"): ?><?=$arResult["REQUIRED_SIGN"];?><?php endif; ?></div>
                                <?= $arQuestion["HTML_CODE"] ?>
                                <div class="input__notification"><?= $arQuestion["ERROR_MESSAGE"] ?? '' ?></div>
                            </label>
                        </div>
                    <?php
                    endif;
                endforeach;
                ?>
            </div>

            <!-- CAPTCHA, если она активирована -->
            <?php if ($arResult["isUseCaptcha"] == "Y"): ?>
                <div class="captcha-block">
                    <div><b><?= GetMessage("FORM_CAPTCHA_TABLE_TITLE") ?></b></div>
                    <input type="hidden" name="captcha_sid" value="<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>" />
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= htmlspecialcharsbx($arResult["CAPTCHACode"]); ?>" width="180" height="40" alt="" />
                    <input type="text" name="captcha_word" size="30" maxlength="50" class="inputtext" />
                </div>
            <?php endif; ?>

            <!-- Нижняя часть формы с кнопками -->
            <div class="contact-form__bottom">
                <div class="contact-form__bottom-policy">
                    Нажимая «Сохранить», вы подтверждаете, что ознакомлены, полностью согласны и принимаете условия «Согласия на обработку персональных данных».
                </div>
                <button class="form-button contact-form__bottom-button" type="submit" name="web_form_submit">
                    <div class="form-button__title"><?= htmlspecialchars(trim($arResult["arForm"]["BUTTON"])) ?: GetMessage("FORM_ADD") ?></div>
                </button>
            </div>
        </form>
    </div>

</body>
</html>
<?php endif; ?>
