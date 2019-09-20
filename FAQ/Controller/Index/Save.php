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
use DevLab\FAQ\Model\CustomersEntityFactory;
use DevLab\FAQ\Model\ResourceModel\CustomersEntity\Collection;
use DevLab\FAQ\Model\ResourceModel\CustomersEntity\CollectionFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Customer\Model\Customer;
use Magento\Customer\Model\Session;
use Magento\Framework\App\ObjectManager;

class Save extends Action
{

    protected $_modelFAQFactory;
    protected $_modelCustomersEntityFactory;
    protected $_resultPageFactory;
    protected $_sessionManager;
    private $collectionFactory;


    public function __construct(
        Context $context,
        FAQFactory $modelFAQFactory,
        CustomersEntityFactory $modelCustomersEntityFactory,
        PageFactory  $resultPageFactory,
        CollectionFactory $collectionFactory,
        SessionManagerInterface $sessionManager

    )
    {
        parent::__construct($context);
        $this->_modelFAQFactory = $modelFAQFactory;
        $this->_modelCustomersEntityFactory = $modelCustomersEntityFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
        $this->_sessionManager = $sessionManager;
     }
    public function getCustomersEntity()
    {
        return $this->collectionFactory->create()->getItems();
    }

    public function execute()
    {



        /** data from customer_entity  */
        $collection = $this->getCustomersEntity();

        $resultRedirect     = $this->resultRedirectFactory->create();
        $FAQModel  = $this->_modelFAQFactory->create();
        /** Get data from form*/
        $data               = $this->getRequest()->getPost();
        $date               = date('Y-m-d h:i:sa');



        /** Start new code */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn() == true) {


            /** check field is not null */
            if ( $data['question'] !="") {
                /** save custom data */
                $this->messageManager->addSuccess(__('This user can add question because he is registred'));
                $FAQModel->setData('question', $data['question']);
                /** status disable */
                $FAQModel->setData('status', 0);
                $FAQModel->setData('customer_id', $customerSession->getCustomer()->getId());
            } else {
                $this->messageManager->addSuccess(__('Field Question is empty. Please add some worlds.'));
            }

            /**
            $FAQModel->setData('name', $customerSession->getCustomer()->getName());
            */
            $FAQModel->save();
            $this->_redirect('faq/index/index');
        }
        else {
            $this->messageManager->addSuccess(__('This user can`t add question because he is not registred'));
            $this->_redirect('faq/index/index');
        }

/**
        $customer_check = $objectManager->get('Magento\Customer\Model\Customer');
        $customer_check->setWebsiteId($website_id);
        $customer_check->load('CUSTOMER_ID');

        if ( $customer_check->getId() ) {
            // the customer already exist
            $this->messageManager->addSuccess(__('Your question has been saved Not'));
        } else {
            // does not exist
            $this->messageManager->addSuccess(__('This user is NOT registred Ok'));
        }

*/
        /**
        foreach ($collection as $item):
            if ($data['email'] == $item->getEmail() ){

                $FAQModel->setData('name', $data['name']);
                $FAQModel->setData('email', $data['email']);
                $FAQModel->setData('question', $data['question']);
                $FAQModel->setData('creation_time', $date);

                $FAQModel->save();

                $this->_redirect('faq/index/index');
                $this->messageManager->addSuccess(__('Your question has been saved'));
                $my_count_foreach = 1;
            }

        endforeach;
        */
        /** if user is not registered */
        /**
        if ( $my_count_foreach == 0  ){
            $this->_redirect('faq/index/index');
            $this->messageManager->addSuccess(__('This user is NOT registred'));
        }
        */
        /** ($data['email'] != $item->getEmail() */

    }
}
