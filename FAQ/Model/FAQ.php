<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 19:32
 */
namespace DevLab\FAQ\Model;
class	FAQ	extends	\Magento\Framework\Model\AbstractModel	{
    public	function	_construct()	{
        $this->_init('DevLab\FAQ\Model\ResourceModel\FAQ');
    }
}