# User Guide für das ElasticExportShippingProfiles Plugin

<div class="container-toc"></div>

## 1 Bei Shipping Profiles registrieren

Shipping Profiles ist ein hauseigenes plentymarkets Plugin, das eine Liste von Versandprofilen für die Artikel zur Verfügung stellt.

## 2 Das Format ShippingProfiles-Plugin in plentymarkets einrichten

Um dieses Format nutzen zu können, benötigen Sie das Plugin Elastic Export.

Auf der Handbuchseite [Daten exportieren](https://www.plentymarkets.eu/handbuch/datenaustausch/daten-exportieren/#4) werden die einzelnen Formateinstellungen beschrieben.

In der folgenden Tabelle finden Sie spezifische Hinweise zu den Einstellungen, Formateinstellungen und empfohlenen Artikelfiltern für das Format **ShippingProfiles-Plugin**.
<table>
    <tr>
        <th>
            Einstellung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Einstellungen
        </td>
    </tr>
    <tr>
        <td>
            Format
        </td>
        <td>
            <b>ShippingProfiles-Plugin</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Bereitstellung
        </td>
        <td>
            <b>URL</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Dateiname
        </td>
        <td>
            Der Dateiname muss auf <b>.csv</b> oder <b>.txt</b>.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Artikelfilter
        </td>
    </tr>
    <tr>
        <td>
            Aktiv
        </td>
        <td>
            <b>Aktiv</b> wählen.
        </td>
    </tr>
    <tr>
        <td>
            Märkte
        </td>
        <td>
            Eine oder mehrere Auftragsherkünfte wählen. Die gewählten Auftragsherkünfte müssen an der Variante aktiviert sein, damit der Artikel exportiert wird.
        </td>
    </tr>
    <tr>
        <td class="th" colspan="2">
            Formateinstellungen
        </td>
    </tr>
    <tr>
        <td>
            Auftragsherkunft
        </td>
        <td>
            Die Auftragsherkunft wählen, die beim Auftragsimport zugeordnet werden soll.
        </td>
    </tr>
    <tr>
        <td>
            Angebotspreis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>
    </tr>
    <tr>
        <td>
            MwSt.-Hinweis
        </td>
        <td>
            Diese Option ist für dieses Format nicht relevant.
        </td>
    </tr>
</table>


## 3 Übersicht der verfügbaren Spalten

<table>
    <tr>
        <th>
            Spaltenbezeichnung
        </th>
        <th>
            Erläuterung
        </th>
    </tr>
    <tr>
        <td>
            item_id
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Die Varianten-ID der Main-Variante.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id1
        </td>
        <td>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Barcode</b>.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id2
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Entsprechend der Formateinstellung <b>Artikelname</b>.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id3
        </td>
        <td>
            <b>Inhalt:</b> Der <b>Name des Herstellers</b> des Artikels. Der <b>Externe Name</b> unter <b>Einstellungen » Artikel » Hersteller</b> wird bevorzugt, wenn vorhanden.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id4
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Beschränkung:</b> max 999.999,99 <br>
            <b>Inhalt:</b> Der <b>Verkaufspreis</b> der Variante.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id5
        </td>
        <td>
            <b>Beschränkung:</b> max 999.999,99 <br>
            <b>Inhalt:</b> Der <b>Verkaufspreis</b> vom Preis-Typ <b>UVP</b> der Variante, wenn dieser höher ist als der Preis.
        </td>
    </tr>
    <tr>
        <td>
            parcel_service_preset_id&lt;&lt;index&gt;&gt;
        </td>
        <td>
            <b>Pflichtfeld</b><br>
            <b>Inhalt:</b> Der ISO-Code der <b>Währung</b> des Preises.
        </td>
    </tr>
</table>

## 4 Lizenz

Das gesamte Projekt unterliegt der GNU AFFERO GENERAL PUBLIC LICENSE – weitere Informationen finden Sie in der [LICENSE.md](https://github.com/plentymarkets/plugin-elastic-export-shipping-profiles/blob/master/LICENSE.md).
