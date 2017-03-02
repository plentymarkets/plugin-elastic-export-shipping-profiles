<?php

namespace ElasticExportShippingProfiles\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\DataLayer\Models\Record;
use Plenty\Modules\Item\DataLayer\Models\RecordList;

/**
 * Class ShippingProfiles
 * @package ElasticExportShippingProfiles\Generator
 */
class ShippingProfiles extends CSVPluginGenerator
{
    /**
     * @var ElasticExportCoreHelper
     */
    private $elasticExportCoreHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * @var int
     */
    private $columns = 5;


    /**
     * ShippingProfiles constructor.
     *
     * @param ArrayHelper $arrayHelper
     */
    public function __construct(ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Generates and populates the data into the CSV file.
     *
     * @param mixed $resultData
     * @param array $formatSettings
     * @param mixed $filter
     */
    protected function generatePluginContent($resultData, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportCoreHelper = pluginApp(ElasticExportCoreHelper::class);

        if(is_array($resultData) && count($resultData['documents']) > 0)
        {
            $this->setDelimiter(";");
            $this->setEnclosure("'");

            //Generates a RecordList form the ItemDataLayer for the given item ids
            $idlResultList = $this->generateIdlList($resultData, $filter);

            if(isset($idlResultList) && $idlResultList instanceof RecordList)
            {
                $rows = [];

                foreach($idlResultList as $item)
                {
                    if(isset($item) && $item instanceof Record)
                    {
                        $row = [
                            'item_id' => $item->itemBase->id,
                        ];

                        foreach($this->getShippingSupportIds($item) as $key => $id)
                        {
                            $row['parcel_service_preset_id' . (string) ($key+1)] = $id;
                        }

                        $rows[] = $row;
                    }
                }
    
                $this->addCSVContent($this->head());
    
                foreach($rows as $row)
                {
                    $this->addCSVContent($this->row(array_values($row)));
                }
            }
        }
    }

    /**
     * Get the head row.
     *
     * @return array
     */
    private function head():array
    {
        $row = ['item_id'];

        for($i = 1; $i <= $this->columns; $i++)
        {
            $row[] = 'parcel_service_preset_id' . (string) $i;
        }

        return $row;
    }

    /**
     * Get row.
     *
     * @param  array $row
     * @return array
     */
    private function row(array $row):array
    {
        for($i = count($row); $i <= $this->columns; $i++)
        {
            $row[] = '';
        }

        return $row;
    }

    /**
     * Get list of supported shipping profile ids for the given item.
     *
     * @param  Record $item
     * @return array<int,int>
     */
    private function getShippingSupportIds(Record $item):array
    {
        $ids = [];

        foreach($item->itemShippingProfilesList as $itemShippingProfile)
        {
            $ids[] = $itemShippingProfile->id;
        }

        $this->maxColumns(count($ids));

        return $ids;
    }

    /**
     * Update maximum number of available columns.
     *
     * @param int $columns
     * @return void
     */
    private function maxColumns(int $columns)
    {
        $this->columns = $columns > $this->columns ? $columns : $this->columns;
    }

    /**
     * Creates a list of Records from the given item ids.
     *
     * @param array $resultData
     * @param array $filter
     * @return RecordList|string
     */
    private function generateIdlList($resultData, $filter)
    {
        // Create a List of all ItemIds
        $itemIdList = array();
        foreach($resultData['documents'] as $item)
        {
            if(!in_array($item['data']['item']['id'], $itemIdList))
            {
                $itemIdList[] = $item['data']['item']['id'];
            }
        }

        // Get the missing fields in ES from IDL(ItemDataLayer)
        if(is_array($itemIdList) && count($itemIdList) > 0)
        {
            /**
             * @var \ElasticExportShippingProfiles\IDL_ResultList\ShippingProfiles $idlResultList
             */
            $idlResultList = pluginApp(\ElasticExportShippingProfiles\IDL_ResultList\ShippingProfiles::class);

            // Return the list of results for the given variation ids
            return $idlResultList->getResultList($itemIdList, $filter);
        }

        return '';
    }
}
