<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 10.11.19
 * Time: 20:44
 */

namespace DevLab\FAQ\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Validator\EmailAddress;
use Magento\Framework\DataObject;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Area;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class FAQObserver implements ObserverInterface
{
    const XML_PATH_EMAIL_RECIPIENT = 'faq/faq_email/email';

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var EmailAddress
     */
    protected $validatorEmail;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var FAQFactory
     */
    protected $_faq;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * FAQObserver constructor.
     * @param TransportBuilder $transportBuilder
     * @param StoreManagerInterface $storeManager
     * @param EmailAddress $validatorEmail
     */
    public function __construct(
        TransportBuilder $transportBuilder,
        StoreManagerInterface $storeManager,
        EmailAddress $validatorEmail,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->validatorEmail = $validatorEmail;
        $this->_transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // send email to admin with customer name & his faq (question)
        $customer = $observer->getData('customer');
        $faq = $observer->getData('faq');

        $full_name = $customer['firstname'] . ' ' . $customer['lastname'];
        $question = $faq['question'];
        $email = $customer['email'];

        $storeScope = ScopeInterface::SCOPE_STORE;

        //checking email is valid then send email
        if ($this->validatorEmail->isValid($email)) {
            $customerObject = new DataObject();

            $templateParams = [
                'full_name' => $full_name,
                'email' => $email,
                'question' => $question
            ];
            $customerObject->setData($templateParams);

            $this->_transportBuilder->setTemplateIdentifier(
                'devlab_faq_email_template'
            )->setTemplateOptions(
                [
                    'area' => Area::AREA_FRONTEND,
                    'store' => $this->storeManager->getStore()->getId(),
                ]
            )->setTemplateVars(
                ['data' => $customerObject]
            )->addTo($this->scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT, $storeScope));
            $transport = $this->_transportBuilder->getTransport();
            try {
                $transport->sendMessage();
            } catch (\Exception $e) {
                ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($e->getMessage());
            }
        }
    }
}
