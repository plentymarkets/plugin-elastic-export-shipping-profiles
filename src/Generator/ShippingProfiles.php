<?php

namespace ElasticExportShippingProfiles\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\ItemShippingProfiles\Contracts\ItemShippingProfilesRepositoryContract;
use Plenty\Modules\Item\ItemShippingProfiles\Models\ItemShippingProfiles;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;

/**
 * Class ShippingProfiles
 * @package ElasticExportShippingProfiles\Generator
 */
class ShippingProfiles extends CSVPluginGenerator
{
    use Loggable;

    const DELIMITER = "|";

    const ENCLOSURE = "'";

    /**
     * @var ElasticExportCoreHelper
     */
    private $elasticExportHelper;

    /**
     * @var ElasticExportStockHelper
     */
    private $elasticExportStockHelper;

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
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);

        $this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);

        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

        $this->setDelimiter(self::DELIMITER);

        $this->setEnclosure(self::ENCLOSURE);

        $rows = [];

        if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
        {
            // Initiate the counter for the variations limit
            $limitReached = false;
            $limit = 0;

            do
            {
                // Stop writing if limit is reached
                if($limitReached === true)
                {
                    break;
                }

                // Get the data from Elastic Search
                $resultList = $elasticSearch->execute();

                if(!is_null($resultList['error']) && count($resultList['error']) > 0)
                {
                    $this->getLogger(__METHOD__)->error('ElasticExportShippingProfiles::log.occurredElasticSearchErrors', [
                        'Error message' => $resultList['error'],
                    ]);
                }

                if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
                {
                    $previousId = null;

                    foreach ($resultList['documents'] as $variation)
                    {
                        // Stop and set the flag if limit is reached
                        if($limit == $filter['limit'])
                        {
                            $limitReached = true;
                            break;
                        }

                        try
                        {
                            // Shipping profiles are available directly on the item
                            if($previousId === null || $previousId != $variation['data']['item']['id'])
                            {
                                // Create the rows with shipping profiles for an item
                                $previousId = $variation['data']['item']['id'];

                                // If filtered by stock is set and stock is negative, then skip the variation
                                if($this->elasticExportStockHelper->isFilteredByStock($variation, $filter) === true)
                                {
                                    continue;
                                }

                                $row = [
                                    'item_id' => $previousId,
                                ];

                                foreach($this->getShippingProfilesList($previousId) as $key => $id)
                                {
                                    if($key == 0)
									{
										$row['parcel_service_preset_id'] = $id;
									}
									else
									{
										$row['parcel_service_preset_id'.$key] = $id;
									}
                                }

                                // Add the shipping profiles
                                $rows[] = $row;

                                // Count the item line
                                $limit += 1;
                            }
                        }
                        catch(\Throwable $throwable)
                        {
                            $this->getLogger(__METHOD__)->error('ElasticExportShippingProfiles::logs.fillRowError', [
                                'Error message ' => $throwable->getMessage(),
                                'Error line'     => $throwable->getLine(),
                                'ItemId'         => $variation['data']['item']['id'],
                            ]);
                        }
                    }
                }

            } while ($elasticSearch->hasNext());
        }

        // Create the header of the CSV file
        $this->addCSVContent($this->head());

        // Print the list of items with their shipping profiles
        foreach($rows as $row)
        {
            $this->addCSVContent($this->row(array_values($row)));
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

		for($i = 0; $i <= $this->columns; $i++)
		{
			if($i == 0)
			{
				$row[] = 'parcel_service_preset_id';
			}
			else
			{
				$row[] = 'parcel_service_preset_id' . (string) $i;
			}
		}

        return $row;
    }

    /**
     * Get row and update the missing columns.
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
     * @param  int $itemId
     * @return array
     */
    private function getShippingProfilesList(int $itemId):array
    {
        $shippingProfiles = [];

        /**
         * @var ItemShippingProfilesRepositoryContract $itemShippingProfilesRepository
         */
        $itemShippingProfilesRepository = pluginApp(ItemShippingProfilesRepositoryContract::class);

        if($itemShippingProfilesRepository instanceof ItemShippingProfilesRepositoryContract)
        {
            $itemShippingProfilesList = $itemShippingProfilesRepository->findByItemId($itemId);

            foreach($itemShippingProfilesList as $itemShippingProfile)
            {
                if($itemShippingProfile instanceof ItemShippingProfiles)
                {
                    // Add the id of the shipping profile
                    $shippingProfiles[] = $itemShippingProfile->profileId;
                }
            }

            $this->maxColumns(count($shippingProfiles));
        }

        return $shippingProfiles;
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
}
