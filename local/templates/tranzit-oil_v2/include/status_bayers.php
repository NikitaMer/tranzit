<?php
// Status bayer
if($GLOBALS['USER']->IsAuthorized() && is_object($GLOBALS['USER']))
{
	$rsUser = CUser::GetList($by, $order,
		array(
			"ID" => $GLOBALS['USER']->GetID(),
		),
		array(
			"SELECT" => array(
				"UF_CONTRAGENT",
			),
		)
	);

	if($arUser = $rsUser->Fetch())
	{
		$rsGender = CUserFieldEnum::GetList(array(), array(
			"ID" => $arUser["UF_CONTRAGENT"],
		));
		if($arGender = $rsGender->GetNext())
			$status_bayer = $arGender["VALUE"];
	}
}
?>