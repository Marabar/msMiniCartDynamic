<?php

/**
 * Class msMiniCartDynamicMainController
 */
abstract class msMiniCartDynamicMainController extends modExtraManagerController {
	/** @var msMiniCartDynamic $msMiniCartDynamic */
	public $msMiniCartDynamic;


	/**
	 * @return void
	 */
	public function initialize() {
		$corePath = $this->modx->getOption('msminicartdynamic_core_path', null, $this->modx->getOption('core_path') . 'components/msminicartdynamic/');
		require_once $corePath . 'model/msminicartdynamic/msminicartdynamic.class.php';

		$this->msMiniCartDynamic = new msMiniCartDynamic($this->modx);
		//$this->addCss($this->msMiniCartDynamic->config['cssUrl'] . 'mgr/main.css');
		$this->addJavascript($this->msMiniCartDynamic->config['jsUrl'] . 'mgr/msminicartdynamic.js');
		$this->addHtml('
		<script type="text/javascript">
			msMiniCartDynamic.config = ' . $this->modx->toJSON($this->msMiniCartDynamic->config) . ';
			msMiniCartDynamic.config.connector_url = "' . $this->msMiniCartDynamic->config['connectorUrl'] . '";
		</script>
		');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('msminicartdynamic:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends msMiniCartDynamicMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}