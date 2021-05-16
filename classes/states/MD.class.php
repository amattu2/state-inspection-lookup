<?php
/*
  Produced 2021
  By https://amattu.com/links/github
  Copy Alec M.
  License GNU Affero General Public License v3.0
*/

// Class Namespace
namespace amattu;

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
  private $date_formats = Array(
    "emissions" => "M j, Y g:ia",
    "safety" => "Y-m-d+",
  );

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

    // Validate Results
    if (!$records || !$document->loadHTML($records)) {
      return $parsed_records;
    }

    // Parse Results
    $path = new \DomXPath($document);
    $nodes = $path->query("//table[@class='results fullWidth']/tr");
    foreach ($nodes as $node) {
      // Variables
      $value = $node->nodeValue;
      $parsed_records[0]["url"] = null;
      $parsed_records[0]["odometer"] = null;

      // Checks
      if (strpos($value, "Test Type") != false) {
        $value = trim(str_replace("Test Type:", "", $value));
        $parsed_records[0]["type"] = $value;
      } else if (strpos($value, "Test Date") != false) {
        $value = trim(str_replace("Test Date:", "", $value));
        $date = InspectionHelper::validate_date($value, $this->date_formats["emissions"]) ? (\DateTime::createFromFormat($this->date_formats["emissions"], $value))->format("Y-m-d") : null;
        $parsed_records[0]["date"] = $date;
      } else if (strpos($value, "Result") != false) {
        $value = trim(str_replace("Result:", "", $value));
        $parsed_records[0]["result"] = $value == "Pass" ? true : false;
      }
    }

    // Return
    return $parsed_records;
  }

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
        "date" => (\DateTime::createFromFormat($this->date_formats["safety"], $record["certificationDate"]))->format("Y-m-d") ?: null,
        "odometer" => $record["odometer"],
        "result" => $record["inspectionResult"] == "pass" ? true : false,
        "url" => null
      );
    }

    // Return
    return $parsed_records;
  }
}
?>
