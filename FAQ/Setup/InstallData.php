<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 30.07.19
 * Time: 21:09
 */
namespace DevLab\FAQ\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $setup->getConnection()->insert(
            $setup->getTable('devlab_faq'),
            [
                'name' => 'igor'

            ]
        );

        $setup->getConnection()->insert(
            $setup->getTable('devlab_faq'),
            [

                'email'=> 'igor@mail.com'

            ]
        );

        $setup->getConnection()->insert(
            $setup->getTable('devlab_faq'),
            [

                'question' =>'What do you do?'
            ]
        );


        $setup->endSetup();
    }
}