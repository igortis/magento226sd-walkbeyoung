<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 05.10.19
 * Time: 20:13
 */
namespace DevLab\FAQ\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;
use Magento\Framework\Session\SessionManagerInterface;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $scopeConfig;
    protected $_sessionManager;

    /** add flush cache */
    protected $cacheTypeList;
    protected $cacheFrontendPool;



    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        SessionManagerInterface $sessionManager
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->_sessionManager = $sessionManager;

        /** add flush cache */
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;

        parent::__construct($context);
    }
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        $resultRedirect = $this->resultRedirectFactory->create();

        $params = $this->getRequest()->getParams();
        $model  = $this->_objectManager->create('DevLab\FAQ\Model\FAQ');

        $model->load( $params['faqid'] );

        /** Check for customer_id*/
        if ( $model['customer_id'] == $customerSession->getCustomer()->getId() ){
            $this->messageManager->addSuccess(__('Delete record registered user'));
            $model->delete();
        }


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
