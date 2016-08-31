<?php

if (!$msMiniCartDynamic = $modx->getService('msminicartdynamic', 'msMiniCartDynamic', $modx->getOption('msminicartdynamic_core_path', null, $modx->getOption('core_path') . 'components/msminicartdynamic/') . 'model/msminicartdynamic/', $scriptProperties)) {
	return 'Could not load msMiniCartDynamic class!';
}

$tpl = $modx->getOption('tpl', $scriptProperties, 'msMinicartDynamic');
$tplOuter = $modx->getOption('tplOuter', $scriptProperties, 'msMinicartDynamicOuter');
$img = $modx->getOption('img', $scriptProperties, '');

$out = '';
$cart = $msMiniCartDynamic->getMsCart('get');

if ($cart == false)
    return $modx->getChunk($tplOuter, array('output' => ''));

$img = !empty($img)
	? '/'. $img. '/'
	: '';

if (!isset($_SESSION['dynamicChunk'])) {
    $_SESSION['dynamicChunk'] = array();
    $_SESSION['dynamicChunk']['tpl'] = $tpl;
	$_SESSION['dynamicChunk']['img'] = $img;
}
elseif ($_SESSION['dynamicChunk']['tpl'] != $tpl) {
    $_SESSION['dynamicChunk']['tpl'] = $tpl;
}
elseif ($_SESSION['dynamicChunk']['img'] != $img) {
    $_SESSION['dynamicChunk']['img'] = $img;
}

foreach ($cart as $k => $v) {
	
	$t = array();
	$t = $msMiniCartDynamic->getPathImg($v['id'], $img);
	
        $out .= $modx->getChunk($tpl, array(
            'name_d' => $t['title'],
            'id_d' => $v['id'],
            'key_d' => $k,
            'count_d' => $v['count'],
            'price_d' => $v['price'],
            'sum_d' => $v['count'] * $v['price'],
            'img_d' => $t['img_path'],
        ));
}

$output = $modx->getChunk($tplOuter, array('output' => $out));

return $output;
