function updateBasketTable(basketItemId, res)
{
	var items = $("#basket_items");

	if (!items)
		return;

	if(typeof UpdateCartMini == 'function') //updateCartInformer
		UpdateCartMini(null , res.BASKET_DATA.allSum_FORMATED); //res.BASKET_DATA.GRID.ROWS.length
	else
		console.error('UpdateCartMini - not found');

	var rows = items.find('.basket_item'),
		count_tovar = 0;

	// update product params after recalculation
	for (var id in res.BASKET_DATA.GRID.ROWS)
	{
		if (res.BASKET_DATA.GRID.ROWS.hasOwnProperty(id))
		{
			var item = res.BASKET_DATA.GRID.ROWS[id];

			if(item.CAN_BUY == 'N' || item.DELAY == 'Y')
				continue;

			basketItem = rows.filter('[id='+id+']');

			if(basketItem.length == 0){

				console.info('item', item);

				var list = $('#basket_items tbody');

				var row = $('<tr/>',{
					'class': "row item basket_item basket_line",
					'id': id,
					'data-id': item.PRODUCT_ID
					});

				// image
				row.append('<td class="image" rowspan="2"><div style="background-image: url('+item.DETAIL_PICTURE_SRC+');"></div></td>');

				//name
				row.append('<td class="name"><div class="title">Название товара</div><p class="name"><a href="' + item.DETAIL_PAGE_URL + '">' + item.NAME + '</a></p></td>');

				//price
				row.append('<td class="tovar-price"><div class="title">Цена</div><div class="price-block" id="current_price_' + id + '">' + item.PRICE_FORMATED.replace('руб.','<span>руб.</span>') + '<span>руб.<span></span></span></div></td>');

				//counter
				var counter = $('<td/>', {
					'class': 'counter'
					});

				counter.append('<input type="hidden" id="QUANTITY_'+id+'" name="QUANTITY_'+id+'" value="' + item.QUANTITY + '">');
				counter.append('<div class="title"> </div>');

				var counter_control = $('<div/>', {
					'class': 'counter-control',
					id: 'basket_quantity_control_' + id
					});

				counter_control.append('<input type="text" size="3" id="QUANTITY_INPUT_'+id+'" name="QUANTITY_INPUT_'+id+'" maxlength="10" min="0" max="120" step="1" style="max-width: 50px" value="' + item.QUANTITY + '" onchange="updateQuantity(\'QUANTITY_INPUT_'+id+'\', '+id+', 1, false)">');
				counter_control.append('<a href="javascript:void(0);" class="count add" onclick="setQuantity(' + id + ', 1, \'up\', false);"></a>');
				counter_control.append('<a href="javascript:void(0);" class="count rem" onclick="setQuantity(' + id + ', 1, \'down\', false);"></a>');

				counter_control.appendTo(counter);
				counter.appendTo(row);

				row.append('<td class="total-price"><div class="title">Сумма</div><div class="price-block" id="sum_'+id+'">' + item.SUM.replace('руб.','<span>руб.</span>') + '</div></td>');

				var row_actions_tr = $('<tr/>',{
					"class": "actions basket_line",
					"id": id
					});

				var row_actions_td = $('<td/>',{
					"colspan": 4
					});


				var row_action_line = $('<div/>',{
					"class": "line cart-actions",
					"id": id
					});


				row_action_line.append('<a href="#" class="icon icon16 compare" data-action="add2compare" data-id="' + item.PRODUCT_ID + '"><span>К сравнению</span></a>');
				row_action_line.append('<a href="#" class="icon icon16 favorite" data-action="add2favorite" data-id="' + item.PRODUCT_ID + '"><span>В закладки</span></a>');
				row_action_line.append('<a href="?action=delete&amp;id='+item.ID+'" class="icon icon16 remove">Удалить</a>');

				row_action_line.appendTo(row_actions_td);
				row_actions_td.appendTo(row_actions_tr);

				list.find('tr.basket_line:last').after(row);
				row.after(row_actions_tr);


				$('.cart-doptovar li').filter('[data-id='+item.PRODUCT_ID+']').remove();

				if(typeof CompareControl == 'object'){
					console.info('CompareControl.reload');
					CompareControl.reload();
					}



			}
			else
			{
				console.info('item', item);

				if (BX('discount_value_' + id))
					BX('discount_value_' + id).innerHTML = item.DISCOUNT_PRICE_PERCENT_FORMATED;

				if (BX('current_price_' + id))
					BX('current_price_' + id).innerHTML = item.PRICE_FORMATED.replace('руб.', '<span>руб.<span>');

				if (BX('old_price_' + id))
					BX('old_price_' + id).innerHTML = (item.FULL_PRICE_FORMATED != item.PRICE_FORMATED) ? item.FULL_PRICE_FORMATED : '';



				if (BX('sum_' + id))
					BX('sum_' + id).innerHTML = item.SUM.replace('руб.','<span>руб.</span>');

				// if the quantity was set by user to 0 or was too much, we need to show corrected quantity value from ajax response
				if (BX('QUANTITY_' + id))
				{
					BX('QUANTITY_INPUT_' + id).value = item.QUANTITY;
					BX('QUANTITY_INPUT_' + id).defaultValue = item.QUANTITY;

					BX('QUANTITY_' + id).value = item.QUANTITY;
				}
			}

			count_tovar += (item.QUANTITY - 0);


		}
	}


	// update warnings if any
	if (res.hasOwnProperty('WARNING_MESSAGE'))
	{
		var warningText = '';

		for (var i = res['WARNING_MESSAGE'].length - 1; i >= 0; i--)
			warningText += res['WARNING_MESSAGE'][i] + '<br/>';

		BX('warning_message').innerHTML = warningText;
	}

	// update total basket values
	if (BX('allWeight_FORMATED'))
		BX('allWeight_FORMATED').innerHTML = res['BASKET_DATA']['allWeight_FORMATED'].replace(/\s/g, ' ');

	if (BX('allSum_wVAT_FORMATED'))
		BX('allSum_wVAT_FORMATED').innerHTML = res['BASKET_DATA']['allSum_wVAT_FORMATED'].replace(/\s/g, ' ');

	if (BX('allVATSum_FORMATED'))
		BX('allVATSum_FORMATED').innerHTML = res['BASKET_DATA']['allVATSum_FORMATED'].replace(/\s/g, ' ');


	if (BX('all_count'))
		BX('all_count').value = count_tovar;

	if (BX('all_summ'))
		BX('all_summ').innerHTML = res['BASKET_DATA']['allSum_FORMATED'].replace('руб.','<span>руб.</span>');

	if (BX('allSum_FORMATED'))
		BX('allSum_FORMATED').innerHTML = res['BASKET_DATA']['allSum_FORMATED'].replace(/\s/g, ' ');

	if (BX('PRICE_WITHOUT_DISCOUNT'))
		BX('PRICE_WITHOUT_DISCOUNT').innerHTML = (res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'] != res['BASKET_DATA']['allSum_FORMATED']) ? res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'].replace(/\s/g, ' ') : '';
}



function updateBasketTable2(basketItemId, res)
{
	var items = $("#basket_items2");
	
	

	if (!items)
		return;

	if(typeof UpdateCartMini == 'function') //updateCartInformer
		UpdateCartMini(null , res.BASKET_DATA.allSum_FORMATED); //res.BASKET_DATA.GRID.ROWS.length
	else
		console.error('UpdateCartMini - not found');

	var rows = items.find('.basket_item'),
		count_tovar = 10;

	// update product params after recalculation
	for (var id in res.BASKET_DATA.GRID.ROWS)
	{
		if (res.BASKET_DATA.GRID.ROWS.hasOwnProperty(id))
		{
			var item = res.BASKET_DATA.GRID.ROWS[id];
			
			if(item.CAN_BUY == 'N' || item.DELAY == 'Y')
				continue;

			basketItem = rows.filter('[id='+id+']');

			if(basketItem.length == 0){

				console.info('item', item);

				var list = $('#basket_items2 tbody');

				var row = $('<tr/>',{
					'class': "row item basket_item basket_line",
					'id': id,
					'data-id': item.PRODUCT_ID
					});

	
					
				// image
				row.append('<td class="image" rowspan="2"><div style="background-image: url('+item.DETAIL_PICTURE_SRC+');"></div></td>');

				//name
				row.append('<td class="name"><div class="title">Название товара</div><p class="name"><a href="' + item.DETAIL_PAGE_URL + '">' + item.NAME + '</a></p></td>');

				//price
				row.append('<td class="tovar-price"><div class="title">Цена</div><div class="price-block" id="current_price_' + id + '">' + item.PRICE_FORMATED.replace('руб.','<span>руб.</span>') + '<span>руб.<span></span></span></div></td>');

				//counter
				var counter = $('<td/>', {
					'class': 'counter'
					});

				counter.append('<input type="hidden" id="QUANTITY_'+id+'" name="QUANTITY_'+id+'" value="' + item.QUANTITY + '">');
				counter.append('<div class="title"> </div>');

				var counter_control = $('<div/>', {
					'class': 'counter-control',
					id: 'basket_quantity_control_' + id
					});

				counter_control.append('<input type="text" size="3" id="QUANTITY_INPUT_'+id+'" name="QUANTITY_INPUT_'+id+'" maxlength="10" min="0" max="120" step="1" style="max-width: 50px" value="' + item.QUANTITY + '" onchange="updateQuantity(\'QUANTITY_INPUT_'+id+'\', '+id+', 1, false)">');
				counter_control.append('<a href="javascript:void(0);" class="count add" onclick="setQuantity2(' + id + ', 1, \'up\', false);"></a>');
				counter_control.append('<a href="javascript:void(0);" class="count rem" onclick="setQuantity2(' + id + ', 1, \'down\', false);"></a>');

				counter_control.appendTo(counter);
				counter.appendTo(row);

				row.append('<td class="total-price"><div class="title">Сумма</div><div class="price-block" id="sum_'+id+'">' + item.SUM.replace('руб.','<span>руб.</span>') + '</div></td>');

				var row_actions_tr = $('<tr/>',{
					"class": "actions basket_line",
					"id": id
					});

				var row_actions_td = $('<td/>',{
					"colspan": 4
					});


				var row_action_line = $('<div/>',{
					"class": "line cart-actions",
					"id": id
					});


				row_action_line.append('<a href="#" class="icon icon16 compare" data-action="add2compare" data-id="' + item.PRODUCT_ID + '"><span>К сравнению</span></a>');
				row_action_line.append('<a href="#" class="icon icon16 favorite" data-action="add2favorite" data-id="' + item.PRODUCT_ID + '"><span>В закладки</span></a>');
				row_action_line.append('<a href="?action=delete&amp;id='+item.ID+'" class="icon icon16 remove">Удалить</a>');

				row_action_line.appendTo(row_actions_td);
				row_actions_td.appendTo(row_actions_tr);

				list.find('tr.basket_line:last').after(row);
				row.after(row_actions_tr);


				$('.cart-doptovar li').filter('[data-id='+item.PRODUCT_ID+']').remove();

				if(typeof CompareControl == 'object'){
					console.info('CompareControl.reload');
					CompareControl.reload();
					}



			}
			else
			{
				console.info('item', item);

				if (BX('discount_value_' + id))
					BX('discount_value_' + id).innerHTML = item.DISCOUNT_PRICE_PERCENT_FORMATED;

				if (BX('current_price_' + id))
					BX('current_price_' + id).innerHTML = item.PRICE_FORMATED.replace('руб.', '<span>руб.<span>');

				if (BX('old_price_' + id))
					BX('old_price_' + id).innerHTML = (item.FULL_PRICE_FORMATED != item.PRICE_FORMATED) ? item.FULL_PRICE_FORMATED : '';



				if (BX('sum_' + id))
					BX('sum_' + id).innerHTML = item.SUM.replace('руб.','<span>руб.</span>');

				// if the quantity was set by user to 0 or was too much, we need to show corrected quantity value from ajax response
				if (BX('QUANTITY_' + id))
				{
					BX('QUANTITY_INPUT_' + id).value = item.QUANTITY;
					BX('QUANTITY_INPUT_' + id).defaultValue = item.QUANTITY;

					BX('QUANTITY_' + id).value = item.QUANTITY;
				}
			}

			count_tovar += (item.QUANTITY - 0);


		}
	}


	// update warnings if any
	if (res.hasOwnProperty('WARNING_MESSAGE'))
	{
		var warningText = '';

		for (var i = res['WARNING_MESSAGE'].length - 1; i >= 0; i--)
			warningText += res['WARNING_MESSAGE'][i] + '<br/>';

		BX('warning_message').innerHTML = warningText;
	}

	// update total basket values
	if (BX('allWeight_FORMATED'))
		BX('allWeight_FORMATED').innerHTML = res['BASKET_DATA']['allWeight_FORMATED'].replace(/\s/g, ' ');

	if (BX('allSum_wVAT_FORMATED'))
		BX('allSum_wVAT_FORMATED').innerHTML = res['BASKET_DATA']['allSum_wVAT_FORMATED'].replace(/\s/g, ' ');

	if (BX('allVATSum_FORMATED'))
		BX('allVATSum_FORMATED').innerHTML = res['BASKET_DATA']['allVATSum_FORMATED'].replace(/\s/g, ' ');


	if (BX('all_count2'))
		BX('all_count2').value = count_tovar;

	if (BX('all_summ2'))
		BX('all_summ2').innerHTML = res['BASKET_DATA']['allSum_FORMATED'].replace('руб.','<span>руб.</span>');

	if (BX('allSum_FORMATED'))
		BX('allSum_FORMATED').innerHTML = res['BASKET_DATA']['allSum_FORMATED'].replace(/\s/g, ' ');

	if (BX('PRICE_WITHOUT_DISCOUNT'))
		BX('PRICE_WITHOUT_DISCOUNT').innerHTML = (res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'] != res['BASKET_DATA']['allSum_FORMATED']) ? res['BASKET_DATA']['PRICE_WITHOUT_DISCOUNT'].replace(/\s/g, ' ') : '';
}

function checkOut()
{
	BX("basket_form").submit();
	return true;
}

function enterCoupon()
{
	recalcBasketAjax();
}

// check if quantity is valid
// and update values of both controls (text input field for PC and mobile quantity select) simultaneously
function updateQuantity(controlId, basketId, ratio, bUseFloatQuantity)
{
	var oldVal = BX(controlId).defaultValue,
		newVal = parseFloat(BX(controlId).value) || 0,
		bIsCorrectQuantityForRatio = false;

	if (ratio === 0 || ratio == 1)
	{
		bIsCorrectQuantityForRatio = true;
	}
	else
	{

		var newValInt = newVal * 10000,
			ratioInt = ratio * 10000,
			reminder = newValInt % ratioInt,
			newValRound = parseInt(newVal);

		if (reminder === 0)
		{
			bIsCorrectQuantityForRatio = true;
		}
	}

	var bIsQuantityFloat = false;

	if (parseInt(newVal) != parseFloat(newVal))
	{
		bIsQuantityFloat = true;
	}

	newVal = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(newVal) : parseFloat(newVal).toFixed(2);

	if (bIsCorrectQuantityForRatio)
	{
		BX(controlId).defaultValue = newVal;

		BX("QUANTITY_INPUT_" + basketId).value = newVal;

		// set hidden real quantity value (will be used in actual calculation)
		BX("QUANTITY_" + basketId).value = newVal;

		recalcBasketAjax();
	}
	else
	{
		newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

		if (newVal != oldVal)
		{
			BX("QUANTITY_INPUT_" + basketId).value = newVal;
			BX("QUANTITY_" + basketId).value = newVal;
			recalcBasketAjax();
		}else
		{
			BX(controlId).value = oldVal;
		}
	}
}



function updateQuantity2(controlId, basketId, ratio, bUseFloatQuantity)
{
	
// Добавить новое значение товара
q=$('#QUANTITY_INPUT_'+basketId).val();
$.post( "/basket.php", { id: basketId, co: q } );
	
	var oldVal = BX(controlId).defaultValue,
		newVal = parseFloat(BX(controlId).value) || 0,
		bIsCorrectQuantityForRatio = false;

		
		
	if (ratio === 0 || ratio == 1)
	{
		bIsCorrectQuantityForRatio = true;
	}
	else
	{

		var newValInt = newVal * 10000,
			ratioInt = ratio * 10000,
			reminder = newValInt % ratioInt,
			newValRound = parseInt(newVal);

		if (reminder === 0)
		{
			bIsCorrectQuantityForRatio = true;
		}
	}
	
	

	var bIsQuantityFloat = false;

	if (parseInt(newVal) != parseFloat(newVal))
	{
		bIsQuantityFloat = true;
	}

	newVal = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(newVal) : parseFloat(newVal).toFixed(2);

		if (bIsCorrectQuantityForRatio)
	{
		BX(controlId).defaultValue = newVal;


		BX("QUANTITY_INPUT_" + basketId).value = newVal;

		// set hidden real quantity value (will be used in actual calculation)
		BX("QUANTITY_" + basketId).value = newVal;

		recalcBasketAjax2();
	}
	else
	{
		newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

		if (newVal != oldVal)
		{
			BX("QUANTITY_INPUT_" + basketId).value = newVal;
			BX("QUANTITY_" + basketId).value = newVal;
			recalcBasketAjax2();
		}else
		{
			BX(controlId).value = oldVal+3;
		}
	}
}



// used when quantity is changed by clicking on arrows
function setQuantity(basketId, ratio, sign, bUseFloatQuantity)
{
	var curVal = parseFloat(BX("QUANTITY_INPUT_" + basketId).value),
		newVal;

	newVal = (sign == 'up') ? curVal + ratio : curVal - ratio;

	if (newVal < 0)
		newVal = 0;

	if (bUseFloatQuantity)
	{
		newVal = newVal.toFixed(2);
	}

	if (ratio > 0 && newVal < ratio)
	{
		newVal = ratio;
	}

	if (!bUseFloatQuantity && newVal != newVal.toFixed(2))
	{
		newVal = newVal.toFixed(2);
	}

	newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);

	BX("QUANTITY_INPUT_" + basketId).value = newVal;
	BX("QUANTITY_INPUT_" + basketId).defaultValue = newVal;

	updateQuantity('QUANTITY_INPUT_' + basketId, basketId, ratio, bUseFloatQuantity);
}

function setQuantity2(basketId, ratio, sign, bUseFloatQuantity)
{
	var curVal = parseFloat(BX("QUANTITY_INPUT_" + basketId).value),
		newVal;
		
		

	newVal = (sign == 'up') ? curVal + ratio : curVal - ratio;

	if (newVal < 0)
		newVal = 0;
	
	if (bUseFloatQuantity)
	{
		newVal = newVal.toFixed(2);
	}

	if (ratio > 0 && newVal < ratio)
	{
		newVal = ratio;
	}

	if (!bUseFloatQuantity && newVal != newVal.toFixed(2))
	{
		newVal = newVal.toFixed(2);
	}

	// newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);
	newVal = getCorrectRatioQuantity(newVal, ratio, bUseFloatQuantity);
	
	

	BX("QUANTITY_INPUT_" + basketId).value = newVal;
	BX("QUANTITY_INPUT_" + basketId).defaultValue = newVal;

	updateQuantity2('QUANTITY_INPUT_' + basketId, basketId, ratio, bUseFloatQuantity);
}



function getCorrectRatioQuantity(quantity, ratio, bUseFloatQuantity)
{
	var newValInt = quantity * 10000,
		ratioInt = ratio * 10000,
		reminder = newValInt % ratioInt,
		result = quantity,
		bIsQuantityFloat = false,
		ratio = parseFloat(ratio);


	if (reminder === 0)
	{
		return result;
	}

	if (ratio !== 0 && ratio != 1)
	{
		for (var i = ratio, max = parseFloat(quantity) + parseFloat(ratio); i <= max; i = parseFloat(parseFloat(i) + parseFloat(ratio)).toFixed(2))
		{
			result = i;
		}

	}
	else if (ratio === 1)
	{
		result = quantity | 0;
	}

	if (parseInt(result) != parseFloat(result))
		bIsQuantityFloat = true;

	result = (bUseFloatQuantity === false && bIsQuantityFloat === false) ? parseInt(result) : parseFloat(result).toFixed(2);

	return result;
}

function recalcBasketAjax()
{
	BX.showWait();

	var property_values = {},
		action_var = BX('action_var').value,
		items = BX('basket_items'),
		delayedItems = BX('delayed_items');

	var postData = {
		'sessid': BX.bitrix_sessid(),
		'site_id': BX.message('SITE_ID'),
		'props': property_values,
		'action_var': action_var,
		'select_props': BX('column_headers').value,
		'offers_props': BX('offers_props').value,
		'quantity_float': BX('quantity_float').value,
		'count_discount_4_all_quantity': BX('count_discount_4_all_quantity').value,
		'price_vat_show_value': BX('price_vat_show_value').value,
		'hide_coupon': BX('hide_coupon').value,
		'use_prepayment': BX('use_prepayment').value
		};

	postData[action_var] = 'recalculate';

	var rows = BX.findChildren(items,  {className: 'basket_item'}, true);

	if (rows.length > 0){
		for(i in rows){
			postData['QUANTITY_' + rows[i].id] = BX('QUANTITY_' + rows[i].id).value;
		}
	}

	BX.ajax({
		url: '/local/templates/tranzit-oil_v2/components/bitrix/sale.basket.basket/main_cart/ajax.php',
		method: 'POST',
		data: postData,
		dataType: 'json',
		onsuccess: function(result)
		{
			BX.closeWait();
			updateBasketTable(null, result);
		}
	});
}



function recalcBasketAjax2()
{
	
	
	BX.showWait();

	var property_values = {},
		action_var = BX('action_var').value,
		items = BX('basket_items'),
		delayedItems = BX('delayed_items');

	var postData = {
		'sessid': BX.bitrix_sessid(),
		'site_id': BX.message('SITE_ID'),
		'props': property_values,
		'action_var': action_var,
		'select_props': BX('column_headers').value,
		'offers_props': BX('offers_props').value,
		'quantity_float': BX('quantity_float').value,
		'count_discount_4_all_quantity': BX('count_discount_4_all_quantity').value,
		'price_vat_show_value': BX('price_vat_show_value').value,
		'hide_coupon': BX('hide_coupon').value,
		'use_prepayment': BX('use_prepayment').value
		};
		
	postData[action_var] = 'recalculate';

	var rows = BX.findChildren(items,  {className: 'basket_item'}, true);
	
	if (rows.length >= 0){
		for(i in rows){
			postData['QUANTITY_' + rows[i].id] = BX('QUANTITY_' + rows[i].id).value;
		}
	}

	BX.ajax({
		url: '/local/templates/tranzit-oil_v2/components/bitrix/sale.basket.basket/main_cart/ajax2.php',
		method: 'POST',
		data: postData,
		dataType: 'json',
		onsuccess: function(result)
		{
			
			BX.closeWait();
			updateBasketTable2(null, result);
		}
	});
}
