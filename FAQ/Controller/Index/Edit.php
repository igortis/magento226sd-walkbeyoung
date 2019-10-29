<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 07.10.19
 * Time: 21:35
 */
namespace DevLab\FAQ\Controller\Index;

use \Magento\Framework\App\Action\Action;

class Edit extends Action
{
    /** @var  \Magento\Framework\View\Result\Page */
    protected $resultPageFactory;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(\Magento\Framework\App\Action\Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}