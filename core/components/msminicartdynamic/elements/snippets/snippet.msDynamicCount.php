<?php
/** @var modX $modx */
/** @var array $scriptProperties */

if (!$msMiniCartDynamic = $modx->getService('msminicartdynamic', 'msMiniCartDynamic',
    $modx->getOption('msminicartdynamic_core_path', null, $modx->getOption('core_path')
        . 'components/msminicartdynamic/') . 'model/msminicartdynamic/', $scriptProperties)) {
	return '';
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

$output = $msMiniCartDynamic->getChunk($tplDefault);

$cart = $msMiniCartDynamic->getMsCart($id);

if ($cart && $cart['id_d'] == $id) {
        $output = $msMiniCartDynamic->getChunk($tplChange, array(
            'key_d' => $cart['key_d'],
            'count_d' => $cart['count_d'],
            'id_d' => $id,
        ));
}

return $output;
