<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 03.08.19
 * Time: 18:20
 */
namespace DevLab\FAQ\Controller\Adminhtml\FAQ;

use Magento\Framework\Controller\ResultFactory;

class NewAction extends \Magento\Backend\App\Action
{
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}