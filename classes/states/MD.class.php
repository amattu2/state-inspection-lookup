<?php
/**
 * Maryland State Inspection Wrapper
 *
 * @extends StateInspection
 * @implements StateInspectionInterface
 */
class MD extends StateInspection implements StateInspectionInterface
{
  // Class Variables
  private $endpoints = Array(
    "emissions" => "http://mva.mdveip.com/",
    "safety" => "https://egov.maryland.gov/msp/vsi/api/Lookup/Inspections?vehicleVin=%s",
  );

  /**
   * @see StateInspectionInterface::fetch_safety
   */
  public function fetch_safety(string $VIN) : array
  {
    // Fetch Records
    $endpoint = sprintf($this->endpoints["safety"], $VIN);
    $records = json_decode(InspectionHelper::http_get($endpoint), true) ?: [];
    $parsed_records = Array();

    // Parse Results
    foreach ($records as $record) {
      $parsed_records[] = Array(
        "date" => $record["date"], /* TBD: Parse proprietary format */
        "result" => $record["result"],
        "link" => null
      );
    }

    // Return
    return $parsed_records;
  }

  /**
   * @see StateInspectionInterface::fetch_emissions
   * @see DOMDocument
   */
  public function fetch_emissions(string $VIN) : array
  {
    // Fetch Records
    libxml_use_internal_errors(true);
    $document = new \DOMDocument();
    $records = InspectionHelper::http_post($this->endpoints["emissions"],
      Array("vin" => $VIN)
    ) ?: "";
    $parsed_records = Array();

    // Parse Results
    $document->loadHTML($records);
    echo $records;

    // temp
    return [];
  }
}
?>
