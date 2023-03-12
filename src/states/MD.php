<?php
/*
 * Produced: Sun Mar 12 2023
 * Author: Alec M.
 * GitHub: https://amattu.com/links/github
 * Copyright: (C) 2023 Alec M.
 * License: License GNU Affero General Public License v3.0
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Class Namespace
namespace amattu2;

/**
 * Maryland State Inspection Wrapper
 *
 * @extends StateInspectionBase
 * @implements StateInspectionInterface
 */
class MD extends StateInspectionBase implements StateInspectionInterface
{
  // Class Variables
  private $endpoints = [
    "emissions" => "https://mva.mdveip.com/",
    "safety" => "https://egov.maryland.gov/msp/vsi/api/Lookup/Inspections?vehicleVin=%s",
  ];
  private $date_formats = [
    "emissions" => "M j, Y g:ia",
    "safety" => "Y-m-d+",
  ];

  /**
   * @see StateInspectionInterface::fetch_emissions
   * @see DOMDocument
   */
  public function fetch_emissions(string $VIN): array
  {
    // Fetch Records
    libxml_use_internal_errors(true);
    $document = new \DOMDocument();
    $records = Utils::http_post($this->endpoints["emissions"],
      ["vin" => $VIN]
    ) ?: "";
    $parsed_records = [];

    // Validate Results
    if (!$records || !$document->loadHTML($records)) {
      return $parsed_records;
    }

    // Parse Results
    $parsed_records[0]["url"] = null;
    $parsed_records[0]["odometer"] = null;
    $path = new \DomXPath($document);
    $nodes = $path->query("//table[@class='results fullWidth']/tr");
    foreach ($nodes as $node) {
      // Variables
      $value = $node->nodeValue;

      // Checks
      if (strpos($value, "Test Type") != false) {
        $value = trim(str_replace("Test Type:", "", $value));
        $parsed_records[0]["type"] = $value;
      } else if (strpos($value, "Test Date") != false) {
        $value = trim(str_replace("Test Date:", "", $value));
        $date = Utils::validate_date($value, $this->date_formats["emissions"]) ? (\DateTime::createFromFormat($this->date_formats["emissions"], $value))->format("Y-m-d") : null;
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
  public function fetch_safety(string $VIN): array
  {
    // Fetch Records
    $endpoint = sprintf($this->endpoints["safety"], $VIN);
    $records = json_decode(Utils::http_get($endpoint), true) ?: [];
    $parsed_records = [];

    // Parse Results
    foreach ($records as $record) {
      $parsed_records[] = [
        "date" => (\DateTime::createFromFormat($this->date_formats["safety"], $record["certificationDate"]))->format("Y-m-d") ?: null,
        "odometer" => $record["odometer"],
        "result" => $record["inspectionResult"] == "pass" ? true : false,
        "url" => null,
      ];
    }

    // Return
    return $parsed_records;
  }
}
