<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 29.07.19
 * Time: 13:02
 */
namespace DevLab\FAQ\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;


class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('devlab_faq'))
            ->addColumn(
                'faq_id',
                Table::TYPE_SMALLINT,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true],
                'FAQ ID'
            )
            ->addColumn('name', Table::TYPE_TEXT, 150, ['nullable' => false], 'User\'s name')
            ->addColumn('email', Table::TYPE_TEXT, 150, ['nullable' => false], 'User\'s email')
            ->addColumn('question', Table::TYPE_TEXT, '2M', [], 'FAQ Question')
            ->addColumn('answer', Table::TYPE_TEXT, '2M', [], 'FAQ Answer')
            ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
            ->setComment('FAQ');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }

}