<?php
$cp = $this->__component; // объект компонента

if (is_object($cp))
{
    // добавим в arResult компонента два поля - MY_TITLE и IS_OBJECT
    $cp->arResult['DATE_ACTIVE_FROM'] = $arResult['DATE_ACTIVE_FROM'];
    $cp->SetResultCacheKeys(array('DATE_ACTIVE_FROM'));

    # сохраним их в копии arResult, с которой работает шаблон
    #$arResult['DATE_ACTIVE_FROM'] = $cp->arResult['DATE_ACTIVE_FROM'];
}