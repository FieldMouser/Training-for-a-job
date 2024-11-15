<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arResult
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Форма</title>

    <!-- Подключаем стили -->
    <link href="/local/templates/form.result.new/new_template/build/css/common.css" rel="stylesheet">
</head>
<body>

<?php
if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?= $arResult["FORM_NOTE"] ?? '' ?>

<?if ($arResult["isFormNote"] != "Y") { ?>
<div class="contact-form">
    <?=$arResult["FORM_HEADER"]?>
    <table class="contact-form__table">
        <?php
        if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {
        ?>
        <tr>
            <td>
                <?php
                if ($arResult["isFormTitle"]) {
                ?>
                <h3 class="contact-form__title"><?=$arResult["FORM_TITLE"]?></h3>
                <?php } ?>

                <?php if ($arResult["isFormImage"] == "Y") { ?>
                    <a href="<?=$arResult["FORM_IMAGE"]["URL"]?>" target="_blank" alt="<?=GetMessage("FORM_ENLARGE")?>">
                        <img src="<?=$arResult["FORM_IMAGE"]["URL"]?>" 
                             <?php if($arResult["FORM_IMAGE"]["WIDTH"] > 300): ?> width="300" 
                             <?php elseif($arResult["FORM_IMAGE"]["HEIGHT"] > 200): ?> height="200"
                             <?php else: ?> <?=$arResult["FORM_IMAGE"]["ATTR"]?> 
                             <?php endif;?> 
                             alt=""/>
                    </a>
                <?php } ?>

                <p class="contact-form__description"><?=$arResult["FORM_DESCRIPTION"]?></p>
            </td>
        </tr>
        <?php } // endif ?>
    </table>

    <br />
    
    <table class="contact-form__input-table data-table">
        <thead>
            <tr>
                <th colspan="2">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
            if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
                echo $arQuestion["HTML_CODE"];
            } else {
        ?>
        <tr>
            <td class="contact-form__input-label">
                <?php if (isset($arResult["FORM_ERRORS"][$FIELD_SID])): ?>
                <span class="error-fld" title="<?=htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID])?>"></span>
                <?php endif; ?>
                <?=$arQuestion["CAPTION"]?>
                <?php if ($arQuestion["REQUIRED"] == "Y"): ?>
                    <?=$arResult["REQUIRED_SIGN"];?>
                <?php endif; ?>
                <?php if ($arQuestion["IS_INPUT_CAPTION_IMAGE"] == "Y") { ?>
                    <br /><?=$arQuestion["IMAGE"]["HTML_CODE"]?>
                <?php } ?>
            </td>
            <td class="contact-form__input-field">
                <!-- Добавляем нужные классы для полей формы -->
                <div class="input contact-form__input">
                    <label class="input__label" for="<?=$arQuestion['STRUCTURE'][0]['ID']?>">
                        <div class="input__label-text"><?=$arQuestion["CAPTION"]?></div>
                        <?=$arQuestion["HTML_CODE"]?>
                    </label>
                </div>
            </td>
        </tr>
        <?php } } // endforeach ?>
        </tbody>
        
        <?php if($arResult["isUseCaptcha"] == "Y") { ?>
        <tr>
            <th colspan="2"><b><?=GetMessage("FORM_CAPTCHA_TABLE_TITLE")?></b></th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>
                <input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" />
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"]);?>" width="180" height="40" alt=""/>
            </td>
        </tr>
        <tr>
            <td><?=GetMessage("FORM_CAPTCHA_FIELD_TITLE")?><?=$arResult["REQUIRED_SIGN"];?></td>
            <td><input type="text" name="captcha_word" size="30" maxlength="50" value="" class="input__input" /></td>
        </tr>
        <?php } // isUseCaptcha ?>
    </table>

    <tfoot>
        <tr>
            <th colspan="2">
                <!-- Кнопки с классами -->
                <input <?=(intval($arResult["F_RIGHT"]) < 10 ? "disabled=\"disabled\"" : "");?> type="submit" name="web_form_submit" value="<?=htmlspecialcharsbx(trim($arResult["arForm"]["BUTTON"]) == '' ? GetMessage("FORM_ADD") : $arResult["arForm"]["BUTTON"]);?>" class="form-button contact-form__bottom-button"/>
            </th>
        </tr>
    </tfoot>
</table>

<p class="contact-form__required">
    <?=$arResult["REQUIRED_SIGN"];?> - <?=GetMessage("FORM_REQUIRED_FIELDS")?>
</p>
<?=$arResult["FORM_FOOTER"]?>

</div> <!-- .contact-form -->
<?php } // endif (isFormNote) ?>

</body>
</html>
