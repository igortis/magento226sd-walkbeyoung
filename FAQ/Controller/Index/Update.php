<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 05.10.19
 * Time: 19:57
 */
namespace DevLab\FAQ\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;

class Update extends \Magento\Framework\App\Action\Action
{
    protected $scopeConfig;

    /** add flush cache */
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
    )
    {
        $this->scopeConfig = $scopeConfig;

        /** add flush cache */
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;

        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $params = $this->getRequest()->getParams();
        $model  = $this->_objectManager->create('DevLab\FAQ\Model\FAQ');

        $model->load( $params['faqid'] );
        $model->setQuestion( $params['question'] );
        $model->save();

        
        /** add flush cache */
        $types = array('db_ddl');
        foreach ($types as $type) {
            $this->_cacheTypeList->cleanType($type);
        }
        foreach ($this->_cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }

        return $resultRedirect->setPath('faq/index/edit');
    }
}
