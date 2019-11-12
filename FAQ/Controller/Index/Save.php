<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.07.19
 * Time: 21:05
 */
namespace DevLab\FAQ\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use DevLab\FAQ\Model\FAQFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Manager;

class Save extends Action
{

    protected $_modelFAQFactory;
    protected $_resultPageFactory;
    protected $_sessionManager;
    protected $eventManager;


    public function __construct(
        Context $context,
        FAQFactory $modelFAQFactory,
        PageFactory  $resultPageFactory,
        SessionManagerInterface $sessionManager,
        Manager $eventManager

    )
    {
        parent::__construct($context);
        $this->_modelFAQFactory = $modelFAQFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_sessionManager = $sessionManager;
        $this->eventManager = $eventManager;
     }


    public function execute()
    {


        $FAQModel  = $this->_modelFAQFactory->create();
        /** Get data from form*/
        $data = $this->getRequest()->getPost();

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn() == true) {


            /** check field is not null */
            if ( $data['question'] !="") {
                /** save custom data */
                $this->messageManager->addSuccess(__('This user can add question because he is registred'));
                $FAQModel->setData('customer_id', $customerSession->getCustomer()->getId());
                $FAQModel->setData('question', $data['question']);
                $FAQModel->setData('status', 0);
                $FAQModel->save();

                /** Events */
                $this->eventManager->dispatch('devlab_faq_adding', [
                    'customer' => (array)$customerSession->getCustomer()->getData(),
                    'faq' => (array)$FAQModel->getData()
                ]);

                $this->_redirect('faq/index/index');
            } else {
                $this->messageManager->addSuccess(__('Field Question is empty. Please add some worlds.'));
            }

        }
        else {
            $this->messageManager->addSuccess(__('This user can`t add question because he is not registred'));
            $this->_redirect('faq/index/index');
        }


    }
}
