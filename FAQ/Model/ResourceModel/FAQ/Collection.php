<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 19:37
 */
namespace DevLab\FAQ\Model\ResourceModel\FAQ;
/**
 *	Subscription	Collection
 */
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
    protected $_idFieldName = 'faq_id';

    public	function	_construct()	{
        $this->_init('DevLab\FAQ\Model\FAQ',
            'DevLab\FAQ\Model\ResourceModel\FAQ');
    }
}



