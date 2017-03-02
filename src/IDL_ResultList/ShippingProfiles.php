<?php

namespace ElasticExportShippingProfiles\IDL_ResultList;

use Plenty\Modules\Item\DataLayer\Contracts\ItemDataLayerRepositoryContract;
use Plenty\Modules\Item\DataLayer\Models\RecordList;


/**
 * Class ShippingProfiles
 * @package ElasticExportShippingProfiles\IDL_ResultList
 */
class ShippingProfiles
{
    /**
     * Creates and retrieves the extra needed data from ItemDataLayer.
     *
     * @param array $itemIds
     * @param array $filter
     * @return RecordList|string
     */
    public function getResultList($itemIds, array $filter = [])
    {
        if(is_array($itemIds) && count($itemIds) > 0)
        {
            $searchFilter = array(
                'itemBase.hasId' => array(
                    'itemId' => $itemIds
                )
            );

            if(array_key_exists('variationStock.netPositive' ,$filter))
            {
                $searchFilter['variationStock.netPositive'] = $filter['variationStock.netPositive'];
            }
            elseif(array_key_exists('variationStock.isSalable' ,$filter))
            {
                $searchFilter['variationStock.isSalable'] = $filter['variationStock.isSalable'];
            }

            $resultFields = array(
                'itemBase'=> array(
                    'id',

                ),
                'itemShippingProfilesList' => array(
                    'id',
                    'name',
                    'backendName',
                    'tags',
                ),
            );

            $params = array(
                'group_by' => array(
                    'groupBy.itemId'
                )
            );

            $itemDataLayer = pluginApp(ItemDataLayerRepositoryContract::class);
            /**
             * @var ItemDataLayerRepositoryContract $itemDataLayer
             */
            $itemDataLayer = $itemDataLayer->search($resultFields, $searchFilter, $params);

            return $itemDataLayer;
        }

        return '';
    }
}