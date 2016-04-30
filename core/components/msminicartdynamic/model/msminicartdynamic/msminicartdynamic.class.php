<?php

/**
 * The base class for msMiniCartDynamic.
 */
class msMiniCartDynamic {
	/* @var modX $modx */
	public $modx;
        public $ms2;


	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('msminicartdynamic_core_path', $config, $this->modx->getOption('core_path') . 'components/msminicartdynamic/');
		$assetsUrl = $this->modx->getOption('msminicartdynamic_assets_url', $config, $this->modx->getOption('assets_url') . 'components/msminicartdynamic/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			//'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/web/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'snippetsPath' => $corePath . 'elements/snippets/',
		), $config);

		//$this->modx->addPackage('msminicartdynamic', $this->config['modelPath']);
		//$this->modx->lexicon->load('msminicartdynamic:default');
	}
        
        
        /**
                * 
                * @param type $id
                * @return string
                */
        public function getMsCart($id) {

                $cart = $_SESSION['minishop2']['cart'];
                
                if (empty($cart)) return;
                
                if ($id == 'get') return $cart;
                
                foreach ($cart as $k => $v) {
                        if (in_array($id, $v)) {
                                return array(
                                        'key_d' => $k,
                                        'id_d' => $v['id'],
                                        'count_d' => $v['count'],
                                );
                        }
                }
                
                return '';
        }
        
        /**
                * 
                * @param type $action
                * @param type $act
                * @return type
                */
        public function parseCart($action) {
                
                $success = array();
                
                if (!empty($action))
                        $cart = $this->getMsCart ('get');
                
                if ($cart) {
                
                        foreach ($cart as $k => $v) {

                                $obj = $this->modx->getObject('msProduct', $v['id']);
                                if ($obj) 
                                        $pagetitle = $obj->get('pagetitle');

                                $success['success'] = true;
                                $success['data'] = array(
                                        'key_d' => $k,
                                        'id_d' => $v['id'],
                                        'name_d' => $pagetitle,
                                        'count_d' => $v['count'],
                                        'price_d' => $v['price'],
                                        'sum_d' => $v['count'] * $v['price'],
                                );

                                $tpl .= $this->modx->getChunk($_SESSION['dynamicChunk']['tpl'], $success['data']);
                        }
                        
                        unset($cart);

                        //$tplChange = $this->modx->getChunk($_SESSION['dynamicChunk']['tplChange'], $success['data']);
                        $success['data']['tpl'] = $tpl;
                        $success['data']['tplChange'] = $tplChange;

                        return $this->modx->toJSON($success);
                }
                else {
                        $success['success'] = false;
                        $success['data'] = array(
                            'mesages' => 'error',
                        );
                        return $this->modx->toJSON($success);
                }
        }
}