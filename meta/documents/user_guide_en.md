# ElasticExportShippingProfiles plugin user guide

<div class="container-toc"></div>

## 1 Registering with Shipping Profiles

ElasticExportShippingProfiles is an in-house plentymarkets plugin intended to provide a list with the shipping profiles available for the given items.

## 2 Setting up the data format ShippingProfiles-Plugin in plentymarkets

The plugin Elastic Export is required to use this format.

Refer to the [Exporting data formats for price search engines](https://knowledge.plentymarkets.com/en/basics/data-exchange/exporting-data#30) page of the manual for further details about the individual format settings.

The following table lists details for settings, format settings and recommended item filters for the format **ShippingProfiles-Plugin**.
<table>
    <tr>
        <th>
            Settings
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Settings
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            Choose <b>ShippingProfiles-Plugin</b>.
        </td>
    </tr>
    <tr>
        <td>
            Provisioning
        </td>
        <td>
            Choose <b>URL</b>.
        </td>
    </tr>
    <tr>
        <td>
            File name
        </td>
        <td>
            The file name must have the ending <b>.csv</b> or <b>.txt</b>.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Item filter
        </td>
    </tr>
    <tr>
        <td>
            Active
        </td>
        <td>
            Choose <b>active</b>.
        </td>
    </tr>
    <tr>
        <td>
            Markets
        </td>
        <td>
            Choose one or multiple order referrer. The chosen order referrer has to be active at the variation for the item to be exported.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Format settings
        </td>
    </tr>
    <tr>
        <td>
            Order referrer
        </td>
        <td>
            Choose the order referrer that should be assigned during the order import.
        </td>
    </tr>
    <tr>
        <td>
            Preview text
        </td>
        <td>
            This option is not relevant for this format.
        </td>
    </tr>
    <tr>
        <td>
            Image
        </td>
        <td>
            This option is not relevant for this format.
        </td>
    </tr>
    <tr>
        <td>
            Offer price
        </td>
        <td>
            This option is not relevant for this format.
        </td>
    </tr>
    <tr>
        <td>
            VAT note
        </td>
        <td>
            This option is not relevant for this format.
        </td>
    </tr>
    <tr>
        <td>
            Override item availability
        </td>
        <td>
            This option is not relevant for this format.
        </td>
    </tr>
</table>


## 3 Overview of available columns

<table>
    <tr>
        <th>
            Column name
        </th>
        <th>
            Explanation
        </th>
    </tr>
    <tr>
        <td>
            item_id
        </td>
        <td>
            <b>Required</b><br>
            <b>Content:</b> The variation id of the main variation.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id1
        </td>
        <td>
            <b>Content:</b> The <b>first ShippingProfile</b> of the item. The <b>ShippingProfile</b> within <b>Item » Edit item » Global » Shipping profiles</b>, if it exists.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id2
        </td>
        <td>
            <b>Content:</b> The <b>second ShippingProfile</b> of the item. The <b>ShippingProfile</b> within <b>Item » Edit item » Global » Shipping profiles</b>, if it exists.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id3
        </td>
        <td>
            <b>Content:</b> The <b>third ShippingProfile</b> of the item. The <b>ShippingProfile</b> within <b>Item » Edit item » Global » Shipping profiles</b>, if it exists.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id4
        </td>
        <td>
            <b>Content:</b> The <b>fourth ShippingProfile</b> of the item. The <b>ShippingProfile</b> within <b>Item » Edit item » Global » Shipping profiles</b>, if it exists.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id5
        </td>
        <td>
            <b>Content:</b> The <b>fifth ShippingProfile</b> of the item. The <b>ShippingProfile</b> within <b>Item » Edit item » Global » Shipping profiles</b>, if it exists.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id&lt;&lt;index&gt;&gt;
        </td>
        <td>
            <b>Content:</b> The <b>index based ShippingProfile</b> of the item. The <b>ShippingProfile</b> within <b>Item » Edit item » Global » Shipping profiles</b>, if it exists.
        </td>
    </tr>
</table>

## 4 License

This project is licensed under the GNU AFFERO GENERAL PUBLIC LICENSE.- find further information in the [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-shipping-profiles/blob/master/LICENSE.md).
