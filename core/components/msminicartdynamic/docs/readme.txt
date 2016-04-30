--------------------
msMiniCartDynamic
--------------------
Author: Marat Marabar <marat@marabar.ru>
--------------------

Компонент msMiniCartDynamic для miniShop2.

Чтобы добавить инпут в блоки с товарами на странице каталога, необходимо в форму добавить идентификатор id="dynamic-[[+id]]" и вызов сниппета msDynamicCount.
Удалить кнопку добавления и input[name=count]
Должно получится примерно следующее:

<form method="post" id="dynamic-[[+id]]" class="ms2_form">
        <a href="[[~[[+id]]]]">[[+pagetitle]]</a>
        <span class="flags">[[+new]] [[+popular]] [[+favorite]]</span>
        <span class="price">[[+price]] [[%ms2_frontend_currency]]</span>
        [[+old_price]]

        [[msDynamicCount? &id=`[[+id]]`]]

        <input type="hidden" name="id" value="[[+id]]">
        <input type="hidden" name="options" value="[]">
</form>

Передать в сниппет msDynamicCount обязательный параметр &id=`[[+id]]`.
Доступные плейсхолдеры:
[[+name_d]] - pagetitle товара
[[+key_d]] - ключ товара
[[+count_d]] - кол-во товара
[[+price_d]] - цена товара
[[+sum_d]] - сумма товара


В мини корзине разместить сниппет msMiniCartDynamic

<div id="msMiniCart" [[+total_count:isnot=`0`:then=`class="full"`:else=``]]>
	<div class="empty">
		<h5><i class="glyphicon glyphicon-shopping-cart"></i> [[%ms2_minicart]]</h5>
		[[%ms2_minicart_is_empty]]
	</div>

        [[msMiniCartDynamic]]

	<div class="not_empty">
		<h5><i class="glyphicon glyphicon-shopping-cart"></i> [[%ms2_minicart]]</h5>
		[[%ms2_minicart_goods]]: <strong class="ms2_total_count">[[+total_count]]</strong> [[%ms2_frontend_count_unit]],
		[[%ms2_minicart_cost]]: <strong class="ms2_total_cost">[[+total_cost]]</strong> [[%ms2_frontend_currency]]
	</div>
</div>

Подключить скрипт msMiniCartDynamic после jQuery.
До или после скрипта miniShop2 - разницы нет, работает так и так.

<script src="/assets/components/msminicartdynamic/js/web/msminicartdynamic.js"></script>