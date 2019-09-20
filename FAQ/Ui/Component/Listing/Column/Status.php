<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 15.09.19
 * Time: 22:38
 */
namespace DevLab\FAQ\Ui\Component\Listing\Column;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Enable')], ['value' => 0, 'label' => __('Disable')]];
    }
}
