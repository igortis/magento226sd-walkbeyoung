<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.07.19
 * Time: 21:46
 */
namespace	DevLab\FAQ\Model\ResourceModel;
class	CustomersEntity	extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb	{
    public	function	_construct()	{
        $this->_init('customer_entity',	'entity_id');
    }
}