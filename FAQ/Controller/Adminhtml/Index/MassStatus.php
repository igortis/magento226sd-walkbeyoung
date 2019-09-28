<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 13.09.19
 * Time: 15:47
 */
namespace DevLab\FAQ\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use DevLab\FAQ\Model\ResourceModel\FAQ\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Cache\Frontend\Pool;


/**
 * Class MassDisable
 */
class MassStatus extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /** add flush cache */
    protected $cacheTypeList;
    protected $cacheFrontendPool;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory,
                                \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
                                \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;

        /** add flush cache */
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $statusValue = $this->getRequest()->getParam('status');
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setStatus($statusValue);
            $item->save();
        }

        /** add flush cache */
        $types = array('db_ddl');
        foreach ($types as $type) {
            $this->_cacheTypeList->cleanType($type);
        }
        foreach ($this->_cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }


        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('faq/');
    }
}
