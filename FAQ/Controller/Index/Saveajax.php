<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 11.10.19
 * Time: 9:29
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

class Saveajax extends Action
{

    protected $_modelFAQFactory;
    protected $_modelCustomersEntityFactory;
    //protected $_resultPageFactory;
    protected $_sessionManager;
    private $collectionFactory;

    // sendmail
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;

    public function __construct(
        Context $context,
        FAQFactory $modelFAQFactory,
        CustomersEntityFactory $modelCustomersEntityFactory,
        PageFactory  $resultPageFactory,
        CollectionFactory $collectionFactory,
        SessionManagerInterface $sessionManager,

        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $loggerInterface,
        array $data = []

    )
    {
        parent::__construct($context);
        $this->_modelFAQFactory = $modelFAQFactory;
        $this->_modelCustomersEntityFactory = $modelCustomersEntityFactory;
        $this->_resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
        $this->_sessionManager = $sessionManager;

        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->messageManager = $context->getMessageManager();

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
        /** Get data from form*/
        $data               = $this->getRequest()->getPost();
        //$date               = date('Y-m-d h:i:sa');

        /** Start new code */
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $customerSession = $objectManager->create('Magento\Customer\Model\Session');
        if ($customerSession->isLoggedIn() == true) {

            /** check field is not null */
            if ( $data['question'] !="") {
                /** save custom data */
                $this->messageManager->addSuccess(__('This user can add questiosaveajax/n because he is registred'));

                // new code
                $servername = "localhost";
                $database = "magento226";
                $username = "root";
                $password = "root25";

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $database);

                //variable
                $question = $data['question'];
                $custid = $customerSession->getCustomer()->getId();
                $status = 0;

                // Check connection
                if (!$conn) {
                    $this->messageManager->addSuccess(__('Connected is not successfully')) . mysqli_connect_error();
                }

                $this->messageManager->addSuccess(__('Connected successfully'));
                /** $question, $answer, $custid, $status */
                $sql = "INSERT INTO devlab_faq (question, customer_id, status) VALUES ('$question', '$custid', '$status')";
                if (mysqli_query($conn, $sql)) {
                    $this->messageManager->addSuccess(__('New record created successfully'));
                    // Send email to administrator from Registred user
                    try
                    {
                        $this->_inlineTranslation->suspend();
                        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;

                        // Name and email from Registred user
                        $sender = [
                            'name' => $customerSession->getCustomer()->getFirstname(),
                            'email' => $customerSession->getCustomer()->getEmail()
                        ];


                        $transport = $this->_transportBuilder
                            ->setTemplateIdentifier('devlab_faq_email_template')
                            ->setTemplateOptions(
                                [
                                    'area' => 'frontend',
                                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                                ]
                            )
                            ->setTemplateVars([
                                'question' => $data['question']
                            ])
                            ->setFrom($sender)
                            //->addTo($sentToEmail,$sentToName)
                            ->addTo('igortis140a@ukr.net','To')
                            ->getTransport();

                        $transport->sendMessage();

                        $this->_inlineTranslation->resume();
                        $this->messageManager->addSuccess('Email sent successfully');
                        $this->_redirect('faq/index/index');

                    } catch(\Exception $e){
                        $this->messageManager->addError($e->getMessage());
                        $this->_logLoggerInterface->debug($e->getMessage());
                        exit;
                    }

                } else {
                    $this->messageManager->addSuccess(__('Error')) . mysqli_error($conn);
                }
                mysqli_close($conn);


            } else {
                $this->messageManager->addSuccess(__('Field Question is empty. Please add some worlds.'));
            }

            $this->_redirect('faq/index/index');

        }
        else {
            $this->messageManager->addSuccess(__('This user can`t add question because he is not registred'));

            $this->_redirect('faq/index/index');

        }


    }
}

//**
/* $this->_redirect('faq/index/index');
*/