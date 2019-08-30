<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.07.19
 * Time: 21:11
 */
namespace DevLab\FAQ\Block;

use Magento\Framework\View\Element\Template;
use DevLab\FAQ\Model\ResourceModel\CustomersEntity\Collection;
use DevLab\FAQ\Model\ResourceModel\CustomersEntity\CollectionFactory;

class CustomersEntityListData extends Template
{
    private $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return \DevLab\FAQ\Model\CustomersEntity[]
     */
    public function getCustomersEntity()
    {
        return $this->collectionFactory->create()->getItems();
    }
}