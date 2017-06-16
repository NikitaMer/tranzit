$(document).ready(function() {
	$("#editStatusDIV .adm-btn").removeAttr("onclick").click(function() {
		if($("#STATUS_ID").val() == "H") {
			if($("#popup_form_delivery_addon").size() > 0)
				skProcessDeliveryAddon();
			else {
				if($('div:contains("Физическое")')) {
					id_user = 25;
				} else {
					id_user = 24;
				}
				$.ajax({
					type: "GET",
					url: "/system/admin_order_status_change.php",
					data: { ORDER_ID: $("#order_view_info_form input[name='ID']").val(), ID_USER: id_user }
				})
					.done(function( strResult ) {
						if(strResult.length > 0) {
							$("#admin-informer").after(strResult);
							skProcessDeliveryAddon();
						}
					});
			}
		} else fChangeStatus();

		return false;
	});
});

function skProcessDeliveryAddon() {
	formDeliveryAddon = BX.PopupWindowManager.create("popup-form-delivery-addon", BX('STATUS_ID'), {
		offsetTop: -100,
		offsetLeft: -150,
		autoHide: true,
		closeByEsc: true,
		closeIcon: true,
		draggable: {restrict: true},
		titleBar: {content: BX.create("span", {html: 'Информация по доставке', 'props': {'style': 'font-size: 13px; font-weight: bold; text-align: center; display: inline-block; width: 100%;'}})},
		content: document.getElementById("popup_form_delivery_addon")
	});
	formDeliveryAddon.setButtons([
		new BX.PopupWindowButton({
			text: "Сохранить",
			className: "",
			events: {
				click: function () {
					var strError = '';

					if(($("#FORM_DA_DATE").val()).length <= 0) strError += "Укажите дату\r\n";


					if(strError.length > 0)
						alert(strError);
					else {
						BX.showWait();
						if($('div:contains("Физическое")')) {
							id_user = 25;
						} else {
							id_user = 24;
						}
						$.ajax({
							type: "POST",
							url: "/system/admin_order_status_change.php",
							data: { SAVE_DA:"Y", ORDER_ID: $("#order_view_info_form input[name='ID']").val(), FORM_DA_DATE: $("#FORM_DA_DATE").val(), ID_USER: id_user }
						})
							.done(function( strResult ) {
								BX.closeWait();
								fChangeStatus();
								formDeliveryAddon.close();
							});
					}
				}
			}
		}),
		new BX.PopupWindowButton({
			text: "Отменить",
			className: "",
			events: {
				click: function () {
					formDeliveryAddon.close();
				}
			}
		})
	]);

	formDeliveryAddon.show();
}