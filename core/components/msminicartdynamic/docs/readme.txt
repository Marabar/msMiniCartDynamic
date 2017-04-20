--------------------
msMiniCartDynamic
--------------------
Author: Marat Marabar <marat@marabar.ru>
--------------------

Компонент msMiniCartDynamic для магазина miniShop2 даёт возможность изменять количество добавляемых товаров в корзину, как кнопками +-,
так и ручным вводом количества в поле input. Также, при необходимости, есть возможность динамического изменения миникорзины.

  *********************************
1. Добавление +- к товарам каталога
  *********************************

Для добавления к товарам каталога кнопок +-, необходимо отредактировать форму в чанке miniShop2 - tpl.msProducts.row, должно получиться примерно так:

<form method="post" id="dynamic-[[+id]]" class="ms2_form">
	<a href="[[~[[+id]]]]">[[+pagetitle]]</a>
	<span class="flags">[[+new]] [[+popular]] [[+favorite]]</span>
	<span class="price">[[+price]] [[%ms2_frontend_currency]]</span>
	[[+old_price]]

	[[!msDynamicCount?
		&id=`[[+id]]`
	]]

	<input type="hidden" name="id" value="[[+id]]">
	<input type="hidden" name="options" value="[]">
</form>



    Удалить button name="ms2_action"
    Удалить input name="count"
    Добавить в форму идентификатор id="dynamic-[[+id]]": <form method="post" id="dynamic-[[+id]]" class="ms2_form">...</form>
    Разместить не кэшированный вызов сниппета [[!msDynamicCount]], с обязательным параметром &id=[[+id]]



Подключить скрипт msMiniCartDynamic после jQuery. До или после скрипта miniShop2 - разницы нет, работает так и так.

<script src="/assets/components/msminicartdynamic/js/web/msminicartdynamic.js"></script>

Доступны плейсхолдеры:

    [[+key_d]] - Уникальный ключ товара в корзине
    [[+count_d]] - Количество этого товара в корзине
    [[+id_d]] - ID товара (ресурса) в корзине
	

  ***********************************
2.  Динамическое изменение миникорзины
  ***********************************

Компонент имеет возможность динамически изменять состав миникорзины, для этого достаточно в чанк tpl.msMiniCart поместить вызов сниппета 


<div id="msMiniCart" [[+total_count:isnot=`0`:then=`class="full"`:else=``]]>
	<div class="empty">
		<h5><i class="glyphicon glyphicon-shopping-cart"></i> [[%ms2_minicart]]</h5>
		[[%ms2_minicart_is_empty]]
	</div>

	[[!msMiniCartDynamic?
            &img = `small`
        ]]

	<div class="not_empty">
		<h5><i class="glyphicon glyphicon-shopping-cart"></i> [[%ms2_minicart]]</h5>
		[[%ms2_minicart_goods]]: <strong class="ms2_total_count">[[+total_count]]</strong> [[%ms2_frontend_count_unit]],
		[[%ms2_minicart_cost]]: <strong class="ms2_total_cost">[[+total_cost]]</strong> [[%ms2_frontend_currency]]
	</div>
</div>


Доступны плейсхолдеры:

    [[+name_d]] - Название товара (pagetitle)
    [[+key_d]] - Ключ товара
    [[+count_d]] - Количество данного товара в корзине
    [[+price_d]] - Цена товара товара за единицу
    [[+sum_d]] - Сумма товара
    [[+img_d]] - Картинка товара
    [[+id_d]] - ID товара (ресурса)


Параметры:

    &tpl - Чанк для одного товара. По умолчанию: msMinicartDynamic
    &tplOuter - Чанк обёртка всего блока. По умолчанию: msMinicartDynamicOuter
    &img - Картинка (миниатюра) товара. По умолчанию: Пусто


*******************************

Сам по себе мой компонент в корзину ничего не добавляет, этим всем занимается miniShop2. <b>msMiniCartDynamic</b> просто инициализирует и ловит
определённые события изменения корзины, подсчитывает кол-во и сумму определённого товара и выводит всё это дело на экран.

С версии 1.0.0-pl мини корзина динамически обновляется без использования +/- (Т.е. при добавления товара кнопкой "В корзину".), для этого достаточно пункта № 2 данного руководства.
