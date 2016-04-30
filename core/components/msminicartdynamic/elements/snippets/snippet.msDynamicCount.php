<?php

if (!$msMiniCartDynamic = $modx->getService('msminicartdynamic', 'msMiniCartDynamic', $modx->getOption('msminicartdynamic_core_path', null, $modx->getOption('core_path') . 'components/msminicartdynamic/') . 'model/msminicartdynamic/', $scriptProperties)) {
	return 'Could not load msMiniCartDynamic class!';
}

$tplDefault = $modx->getOption('tplDefault', $scriptProperties, 'msDynamicCount');
$tplChange = $modx->getOption('tplChange', $scriptProperties, 'msDynamicCountChange');
$id = $modx->getOption('id', $scriptProperties, '');

if (!isset($_SESSION['dynamicChunk'])) {
        $_SESSION['dynamicChunk'] = array();
        $_SESSION['dynamicChunk']['tplChange'] = $tplChange;
}
elseif ($_SESSION['dynamicChunk']['tplChange'] != $tplChange) {
        $_SESSION['dynamicChunk']['tplChange'] = $tplChange;
}

$output = $modx->getChunk($tplDefault);

$cart = $msMiniCartDynamic->getMsCart($id);

if ($cart && $cart['id_d'] == $id) {
        $output = $modx->getChunk($tplChange, array(
            'key_d' => $cart['key_d'],
            'count_d' => $cart['count_d'],
            'id_d' => $id,
        ));
}

return $output;
