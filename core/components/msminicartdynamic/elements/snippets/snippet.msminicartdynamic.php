<?php

if (!$msMiniCartDynamic = $modx->getService('msminicartdynamic', 'msMiniCartDynamic', $modx->getOption('msminicartdynamic_core_path', null, $modx->getOption('core_path') . 'components/msminicartdynamic/') . 'model/msminicartdynamic/', $scriptProperties)) {
	return 'Could not load msMiniCartDynamic class!';
}

$tpl = $modx->getOption('tpl', $scriptProperties, 'msMinicartDynamic');
$tplOuter = $modx->getOption('tplOuter', $scriptProperties, 'msMinicartDynamicOuter');

$out = '';
$cart = $msMiniCartDynamic->getMsCart('get');

if (!isset($_SESSION['dynamicChunk'])) {
        $_SESSION['dynamicChunk'] = array();
        $_SESSION['dynamicChunk']['tpl'] = $tpl;
}
elseif ($_SESSION['dynamicChunk']['tpl'] != $tpl) {
        $_SESSION['dynamicChunk']['tpl'] = $tpl;
}

foreach ($cart as $k => $v) {
        $obj = $modx->getObject('msProduct', array('id' => $v['id']));
        if ($obj) {
                $title = $obj->get('pagetitle');
        }
        
        $out .= $modx->getChunk($tpl, array(
                'name_d' => $title,
                'key_d' => $k,
                'count_d' => $v['count'],
                'price_d' => $v['price'],
                'sum_d' => $v['count'] * $v['price'],
        ));
}

$output = $modx->getChunk($tplOuter, array('output' => $out));

return $output;
