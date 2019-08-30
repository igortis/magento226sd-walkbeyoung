<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 19:27
 */
namespace	DevLab\FAQ\Controller\Index;
class	Redirect	extends	\Magento\Framework\App\Action\Action
{
    public	function	execute()
    {
        $this->_redirect('testimonials');
    }
}