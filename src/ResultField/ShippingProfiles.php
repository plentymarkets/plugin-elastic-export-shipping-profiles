<?php

namespace ElasticExportShippingProfiles\ResultField;

use Plenty\Modules\Cloud\ElasticSearch\Lib\ElasticSearch;
use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\Helper\Services\ArrayHelper;

/**
 * Class ShippingProfiles
 * @package ElasticExportShippingProfiles\ResultField
 */
class ShippingProfiles extends ResultFields
{
    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

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
     * Creates the fields set to be retrieved from ElasticSearch.
     *
     * @param array $formatSettings
     * @return array
     */
    public function generateResultFields(array $formatSettings = []):array
    {
        $this->setOrderByList(['item.id', ElasticSearch::SORTING_ORDER_ASC]);

        // Fields
        $fields = [
            [
                //item
                'item.id',

                //variation
                'id',
                'variation.stockLimitation',
            ]
        ];

        return $fields;
    }
}
