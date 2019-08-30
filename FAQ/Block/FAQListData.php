<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 22:13
 */
namespace DevLab\FAQ\Block;

use Magento\Framework\View\Element\Template;
/**
use DevLab\FAQ\Model\ResourceModel\FAQ\Collection;
use DevLab\FAQ\Model\ResourceModel\FAQ\CollectionFactory;
*/
/** colection fron Grid - join two tables devlab_faq ang customer_entity */
use DevLab\FAQ\Model\ResourceModel\FAQ\Grid\Collection;
use DevLab\FAQ\Model\ResourceModel\FAQ\Grid\CollectionFactory;

class FAQListData extends Template
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
     * @return \DevLab\FAQ\Model\FAQ[]
     */
    public function getFAQ()
    {
        return $this->collectionFactory->create()->getItems();
    }
}