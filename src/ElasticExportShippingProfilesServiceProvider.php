<?php

namespace ElasticExportShippingProfiles;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;


/**
 * Class ElasticExportShippingProfilesServiceProvider
 * @package ElasticExportShippingProfiles
 */
class ElasticExportShippingProfilesServiceProvider extends DataExchangeServiceProvider
{
    /**
     * Abstract function for registering the service provider.
     */
    public function register()
    {

    }

    /**
     * Adds the export format to the export container.
     *
     * @param ExportPresetContainer $container
     */
    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'ShippingProfiles-Plugin',
            'ElasticExportShippingProfiles\ResultField\ShippingProfiles',
            'ElasticExportShippingProfiles\Generator\ShippingProfiles',
            '',
            true
        );
    }
}