<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.07.19
 * Time: 21:47
 */
namespace DevLab\FAQ\Model\ResourceModel\CustomersEntity;
/**
 *	Subscription	Collection
 */
class	Collection	extends
    \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     *	Initialize	resource	collection
     *
     *	@return	void
     */
    public	function	_construct()	{
        $this->_init('DevLab\FAQ\Model\CustomersEntity',
            'DevLab\FAQ\Model\ResourceModel\CustomersEntity');
    }
}