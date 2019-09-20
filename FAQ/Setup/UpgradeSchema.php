<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 11.08.19
 * Time: 16:38
 */

namespace DevLab\FAQ\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('devlab_faq'),
                'customer_id',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'comment' => 'Customer Id'
                ]
            );
        }
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $setup->getConnection()->dropColumn(
                $setup->getTable('devlab_faq'),'name');
        }
        if (version_compare($context->getVersion(), '1.0.3', '<')) {
            $setup->getConnection()->dropColumn(
                $setup->getTable('devlab_faq'),'email');

            $setup->getConnection()->dropColumn(
                $setup->getTable('devlab_faq'),'creation_time');

        }
        if (version_compare($context->getVersion(), '1.0.4', '<')) {
            $setup->getConnection()->addColumn(
                $setup->getTable('devlab_faq'),
                'status',
                [
                    'type' => Table::TYPE_SMALLINT,
                    'nullable' => true,
                    'comment' => 'Status'
                ]
            );
        }

        $setup->endSetup();
    }
}
