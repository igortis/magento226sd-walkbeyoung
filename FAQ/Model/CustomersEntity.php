<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.07.19
 * Time: 21:42
 */
namespace DevLab\FAQ\Model;
class	CustomersEntity	extends	\Magento\Framework\Model\AbstractModel	{
public	function	_construct()	{
$this->_init('DevLab\FAQ\Model\ResourceModel\CustomersEntity');
}
}