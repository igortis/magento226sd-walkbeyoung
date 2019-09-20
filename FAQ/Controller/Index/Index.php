<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 19:26
 */
namespace DevLab\FAQ\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Page\Config;
use Magento\Store\Model\ScopeInterface;





class Index extends Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;
    protected $scopeConfig;
    protected $pageConfig;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(Context $context,
                                PageFactory $resultPageFactory,
                                ScopeConfigInterface $scopeConfig,
                                Config $pageConfig)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->scopeConfig = $scopeConfig;
        $this->pageConfig = $pageConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage=$this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->set(
            $this->scopeConfig->getValue('faq/general/title', ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->getTitle()->set(
            $this->scopeConfig->getValue('faq/general/keywords', ScopeInterface::SCOPE_STORE)
        );
        $resultPage->getConfig()->getTitle()->set(
            $this->scopeConfig->getValue('faq/general/description', ScopeInterface::SCOPE_STORE)
        );

        return $resultPage;
    }
}
