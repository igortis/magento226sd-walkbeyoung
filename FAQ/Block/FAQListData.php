<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 22:13
 */
namespace DevLab\FAQ\Block;

use Magento\Framework\View\Element\Template;

/** colection fron Grid - join two tables devlab_faq ang customer_entity */
use DevLab\FAQ\Model\ResourceModel\FAQ\Grid\Collection;
use DevLab\FAQ\Model\ResourceModel\FAQ\Grid\CollectionFactory;
use Magento\Framework\Session\SessionManagerInterface;


class FAQListData extends Template
{
    private $collectionFactory;
    protected $_sessionManager;



    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        SessionManagerInterface $sessionManager,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->_sessionManager = $sessionManager;
        /** add flush cache */
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        parent::__construct($context, $data);
    }

    /**
     * @return \DevLab\FAQ\Model\FAQ[]
     */
    public function getFAQfilterbyfield()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');

        if ($customerSession->isLoggedIn() == true) {
            $collection = $this->collectionFactory->create()
                ->addFieldToFilter('customer_id', $customerSession->getCustomer()->getId());
        }
        else {
            $collection = $this->collectionFactory->create()
                ->addFieldToFilter('customer_id', '0');
        }
        
        return $collection->getItems();

    }
    
    public function getFAQ()
    {

       return $this->collectionFactory->create()->getItems();

    }


    public	function	getBaseUpdateUrl()
    {
        return	$this->getUrl('faq/index/update');
    }

    public	function	getBaseDeleteUrl()
    {
        return	$this->getUrl('faq/index/delete');
    }
}
