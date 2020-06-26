<?php
/**
 * Created by PhpStorm.
 * User: Raibel
 * Date: 10/27/2018
 * Time: 4:20 PM
 */

namespace Botta\CigarCatalog\Model\Export;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Ui\Model\Export\MetadataProvider;

class ConvertToCsv
{
    public function __construct(
        Filesystem $filesystem,
        Filter $filter,
        MetadataProvider $metadataProvider,
        $pageSize = 200
    ) {
        $this->filter = $filter;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $this->metadataProvider = $metadataProvider;
        $this->pageSize = $pageSize;
    }

    public function getCsvFile($selectedColumns)
    {
        $component = $this->filter->getComponent();

        $name = md5(microtime());
        $file = 'export/'. $component->getName() . $name . '.csv';

        $this->filter->prepareComponent($component);
        $this->filter->applySelectionOnTargetProvider();
        $dataProvider = $component->getContext()->getDataProvider();
        $fields = $this->getFields($component, $selectedColumns);
        $options = $this->metadataProvider->getOptions();

        $this->directory->create('export');
        $stream = $this->directory->openFile($file, 'w+');
        $stream->lock();
        $stream->writeCsv($this->getHeaders($component, $selectedColumns));
        $i = 1;
        $searchCriteria = $dataProvider->getSearchCriteria()
            ->setCurrentPage($i)
            ->setPageSize($this->pageSize);
        $totalCount = (int) $dataProvider->getSearchResult()->getTotalCount();
        while ($totalCount > 0) {
            $items = $dataProvider->getSearchResult()->getItems();
            foreach ($items as $item) {
                $this->metadataProvider->convertDate($item, $component->getName());
                $stream->writeCsv($this->metadataProvider->getRowData($item, $fields, $options));
            }
            $searchCriteria->setCurrentPage(++$i);
            $totalCount = $totalCount - $this->pageSize;
        }
        $stream->unlock();
        $stream->close();

        return [
            'type' => 'filename',
            'value' => $file,
            'rm' => true  // can delete file after use
        ];
    }

    protected function getFields($component, $selectedColumns)
    {
        $fields = $this->metadataProvider->getFields($component);

        return array_intersect($fields, $selectedColumns);
    }

    protected function getHeaders($component, $selectedColumns)
    {
        $columnsComponent = $this->getColumnComponent($component);
        $headers = [];

        foreach ($columnsComponent->getChildComponents() as $column) {
            if ($column->getData('config/label') && $column->getData('config/dataType') !== 'actions' && in_array($column->getName(), $selectedColumns)) {
                $headers[] = $column->getData('config/label');
            }
        }

        return $headers;
    }

    protected function getColumnComponent($component)
    {
        foreach ($component->getChildComponents() as $childComponent) {
            if ($childComponent instanceof \Magento\Ui\Component\Listing\Columns) {
                return $childComponent;
            }
        }

        throw new \Exception('No columns found');
    }
}