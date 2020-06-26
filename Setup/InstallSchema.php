<?php

namespace Botta\CigarCatalog\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @var SchemaSetupInterface
     */
    private $setup;

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->setup = $setup;

        $setup->startSetup();

        $this->createTableStatus();
        $this->createMainTable();

        $setup->endSetup();
    }

    private function createTableStatus()
    {
        $table = $this->setup->getConnection()->newTable(
            $this->setup->getTable('botta_cigar_catalog_subscription_status')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'unsigned' => true,
                'primary' => true,
                'nullable' => false
            ],
            'Primary Key'
        )->addColumn(
            'name',
            Table::TYPE_TEXT,
            50,
            [
                'nullable' => false
            ],
            'Name'
        );

        $this->setup->getConnection()->createTable($table);

        foreach (['Pending', 'Approved', 'Rejected'] as $index => $name) {
            $this->setup->getConnection()->insert(
                $this->setup->getTable('botta_cigar_catalog_subscription_status'),
                [
                    'id' => $index + 1,
                    'name' => $name
                ]
            );
        }
    }

    private function createMainTable()
    {
        $table = $this->setup->getConnection()->newTable(
            $this->setup->getTable('botta_cigar_catalog_subscription')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            [
                'unsigned' => true,
                'primary' => true,
                'identity' => true,
                'nullable' => false
            ],
            'Primary Key'
        )->addColumn(
            'full_name',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'Full name'
        )->addColumn(
            'email',
            Table::TYPE_TEXT,
            100,
            [
                'nullable' => false
            ],
            'Email'
        )->addColumn(
            'address',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'Address'
        )->addColumn(
            'city',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'City'
        )->addColumn(
            'state',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'State'
        )->addColumn(
            'postcode',
            Table::TYPE_TEXT,
            255,
            [
                'nullable' => false
            ],
            'Postal Code'
        )->addColumn(
            'comments',
            Table::TYPE_TEXT,
            null,
            [
                'nullable' => true
            ],
            'Comments'
        )->addColumn(
            'request_status_id',
            Table::TYPE_INTEGER,
            null,
            [
                'unsigned' => true,
                'nullable' => false,
                'default' => 1
            ],
            'Request Status'
        )->addColumn(
            'created_at',
            Table::TYPE_DATETIME,
            null,
            [
                'nullable' => false
            ]
        )->addColumn(
            'updated_at',
            Table::TYPE_DATETIME,
            null,
            [
                'nullable' => false
            ]
        )->addForeignKey(
            $this->setup->getFkName(
                $this->setup->getTable('botta_cigar_catalog_subscription_status'),
                'id',
                $this->setup->getTable('botta_cigar_catalog_subscription'),
                'request_status_id'
            ),
            'request_status_id',
            $this->setup->getTable('botta_cigar_catalog_subscription_status'),
            'id',
            Table::ACTION_CASCADE
        );

        $this->setup->getConnection()->createTable($table);
    }
}