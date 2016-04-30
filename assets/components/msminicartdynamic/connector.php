<?php

define('MODX_API_MODE', true);
require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/index.php';

$modx->getService('error','error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

/** @var msMiniCartDynamic $msMiniCartDynamic */
$msMiniCartDynamic = $modx->getService('msminicartdynamic', 'msMiniCartDynamic', $modx->getOption('msminicartdynamic_core_path', null, $modx->getOption('core_path') . 'components/msminicartdynamic/') . 'model/msminicartdynamic/');

if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	$modx->sendRedirect($modx->makeUrl($modx->getOption('site_start'),'','','full'));
}
elseif (!empty($_REQUEST['action'])) {
	echo $msMiniCartDynamic->parseCart($_REQUEST['action']);
}
else {
        return;
}
