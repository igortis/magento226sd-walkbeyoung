<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 03.08.19
 * Time: 18:17
 */

namespace DevLab\FAQ\Controller\Adminhtml\FAQ;

use DevLab\FAQ\Model\FAQFactory;

class Save extends \Magento\Backend\App\Action
{
    private $faqFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        FAQFactory $faqFactory
    ) {
        $this->faqFactory = $faqFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->faqFactory->create()
            ->setData($this->getRequest()->getPostValue()['general'])
            ->save();
        return $this->resultRedirectFactory->create()->setPath('faq/index/index');
    }
}