<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 19:35
 */
namespace	DevLab\FAQ\Model\ResourceModel;
class	FAQ	extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb	{
    public	function	_construct()	{
        $this->_init('devlab_faq',	'faq_id');
    }
}