<?php
/** @var modX $modx */
/** @var array $scriptProperties */

if (!$msMiniCartDynamic = $modx->getService('msminicartdynamic', 'msMiniCartDynamic',
    $modx->getOption('msminicartdynamic_core_path', null, $modx->getOption('core_path')
        . 'components/msminicartdynamic/') . 'model/msminicartdynamic/', $scriptProperties)) {
	return '';
}

$tpl = $modx->getOption('tpl', $scriptProperties, 'msMinicartDynamic');
$tplOuter = $modx->getOption('tplOuter', $scriptProperties, 'msMinicartDynamicOuter');
$img = $modx->getOption('img', $scriptProperties, '');

$out = '';
$output = '';
$cart = $msMiniCartDynamic->getMsCart('get');

$img = !empty($img)
	? '/'. $img. '/'
	: '';

$record = array(
    'tpl' => $tpl,
    'img' => $img,
);

if (!isset($_SESSION['dynamicChunk'])) {
    $_SESSION['dynamicChunk'] = array();
}

if ($_SESSION['dynamicChunk'] !== $record) {
    $_SESSION['dynamicChunk'] = $record;
}

if ($cart == false)
    return $msMiniCartDynamic->getChunk($tplOuter, array('output' => ''));
    
foreach ($cart as $k => $v) {
	$t = array();
	$t = $msMiniCartDynamic->getPathImg($v['id'], $img);
	
        $out .= $msMiniCartDynamic->getChunk($tpl, array(
            'name_d' => $t['title'],
            'id_d' => $v['id'],
            'key_d' => $k,
            'count_d' => $v['count'],
            'price_d' => $v['price'],
            'sum_d' => $v['count'] * $v['price'],
            'img_d' => $t['img_path'],
        ));
}
$output = $msMiniCartDynamic->getChunk($tplOuter, array('output' => $out));

return $output;
