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

		$corePath = $this->modx->getOption('msminicartdynamic_core_path', $config,
            $this->modx->getOption('core_path') . 'components/msminicartdynamic/');
		$assetsUrl = $this->modx->getOption('msminicartdynamic_assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/msminicartdynamic/');
		$connectorUrl = $assetsUrl . 'connector.php';

		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'jsUrl' => $assetsUrl . 'js/web/',
			'connectorUrl' => $connectorUrl,

			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'snippetsPath' => $corePath . 'elements/snippets/',
		), $config);
	}
        
        
    /**
    *
    * @param type $id
    * @return string
    */
    public function getMsCart($id) {
        $cart = $_SESSION['minishop2']['cart'];
        if (empty($cart))
            return false;

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
                $t = array();
                $t = $this->getPathImg($v['id'], $_SESSION['dynamicChunk']['img']);

                $success['success'] = true;
                $success['data'] = array(
                    'key_d' => $k,
                    'id_d' => $v['id'],
                    'name_d' => $t['title'],
                    'count_d' => $v['count'],
                    'price_d' => $v['price'],
                    'sum_d' => $v['count'] * $v['price'],
                    'img_d' => $t['img_path'],
                );

                $tpl .= $this->modx->getChunk($_SESSION['dynamicChunk']['tpl'], $success['data']);
            }
            unset($cart);
            $success['data']['tpl'] = $tpl;

            return $this->modx->toJSON($success);

        } else {
            $success['success'] = false;
            $success['data'] = array(
                'mesages' => 'error',
            );
            return $this->modx->toJSON($success);
        }
    }


    /**
     * @param $id
     * @param $img
     * @return array
     */
	public function getPathImg($id, $img) {
		$response = array();
        
        $objProduct = $this->modx->getObject('msProduct', $id);
        if ($objProduct)
            $response['title'] = $objProduct->get('pagetitle');
		
		$q = $this->modx->newQuery('msProductFile');
        $q->where(array(
            'product_id' => $id,
            'path' => $id . $img,
            'rank' => 0,
        ));
        $images = $this->modx->getIterator('msProductFile', $q);
        $images->rewind();
		if ($images->valid()) {
            foreach ($images as $img) {
                $imgArray = $img->toArray();
                $response['img_path'] = $imgArray['url'];
            }
        } else {
            $response['img_path'] = $img;
            if (!empty($img))
                $this->modx->log(MODX::LOG_LEVEL_ERROR, 'Not true set the picture size ' . $img);
        }
        return $response;
	}
}