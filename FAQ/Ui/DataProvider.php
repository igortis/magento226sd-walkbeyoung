<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 03.08.19
 * Time: 18:04
 */
namespace DevLab\FAQ\Ui;

use Magento\Ui\DataProvider\AbstractDataProvider;

class DataProvider extends AbstractDataProvider
{
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    public function getData()
    {
        $result = [];
        foreach ($this->collection->getFAQ() as $item) {
            $result[$item->getFAQ_id()]['general'] = $item->getData();
        }
        return $result;
    }
}