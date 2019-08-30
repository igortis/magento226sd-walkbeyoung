<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 31.07.19
 * Time: 21:01
 */
namespace	DevLab\FAQ\Block;
use	Magento\Framework\View\Element\Template;
class	FAQ	extends	Template
{
    public	function	getBaseUrl()
    {
        return	$this->getUrl('faq/index/save');
    }
}