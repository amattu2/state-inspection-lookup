<?php
/*
  Produced 2021
  By https://amattu.com/links/github
  Copy Alec M.
  License GNU Affero General Public License v3.0
*/

// Class Namespace
namespace amattu;

// Exception Classes
class UnsupportedStateException extends \Exception {}
class UnsupportedStateOperationException extends \Exception {}
class InvalidVINLengthException extends \Exception {}

/**
 * State Endpoint Wrapper Interface
 */
interface StateInterface
{
  /**
   * A endpoint wrapper to return emissions and inspection results
   *
   * @param string VIN number
   * @return array [description]
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T14:49:13-040
   */
  public function fetch_all(string $VIN) : array;

  /**
   * A endpoint wrapper to return a structured state emissions test result
   * All return attributes are nullable, given that each state returns different information.
   * 
   * @param string VIN number
   * @return array [description]
   * @throws TypeError
   * @throws UnsupportedStateOperationException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T14:51:13-040
   */
  public function fetch_emissions(string $VIN) : array;

  /**
   * A endpoint wrapper to return a structured state safety inspection search result
   * All return attributes are nullable, given that each state returns different information.
   *
   * @param string VIN number
   * @return array Array<Array<?bool pass, ?string url>>
   * @return array Structured return result
   * @throws TypeError
   * @throws UnsupportedStateOperationException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:05:27-040
   */
  public function fetch_safety(string $VIN) : array;
}

/**
 * A generalized U.S. state vehicle safety inspection record lookup
 */
class Inspections {
  // Class Variables
  private static $states = null;
  private static $vin_length = 17;

  /**
   * Class State Initialization
   *
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:11:14-040
   */
  private function setup_states()
  {
    self::$states = Array(
      "MD" => new MD(),
    );
  }

  /**
   * Fetch Inspection Records
   *
   * @param string VIN
   * @param string U.S. state
   * @return array
   * @throws TypeError
   * @throws UnsupportedStateException
   * @throws InvalidVINLengthException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:15:26-040
   * @see StateInterface::fetch_records
   */
  public static function all(string $VIN, string $state) : array
  {
    // Checks
    if (!self::$states) {
      self::setup_states();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::$vin_length) {
      throw new InvalidVINLengthException("The provided VIN is not a valid length");
    }

    // Fetch Records
    return self::$states[$state]->fetch_records($VIN);
  }

  public static function safety() : array
  {

  }

  public static function emissions() : array
  {

  }
}

/**
 * A general Inspection helper class
 */
class InspectionHelper
{
  /**
   * Perform a HTTP Get request
   *
   * @param string URL
   * @return ?string result body
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-03T19:16:29-040
   */
  public static function http_get(string $endpoint) : ?string
  {
    // cURL Initialization
    $handle = curl_init();
    $result = null;
    $error = 0;

    // Options
    curl_setopt($handle, CURLOPT_URL, $endpoint);
    curl_setopt($handle, CURLOPT_HTTPGET, 1);
    curl_setopt($handle, CURLOPT_FAILONERROR, 1);
    curl_setopt($handle, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($handle, CURLOPT_MAXREDIRS, 2);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($handle, CURLOPT_TIMEOUT, 10);

    // Fetch Result
    $result = curl_exec($handle);
    $error = curl_errno($handle);

    // Return
    curl_close($handle);
    return $result && !$error ? $result : null;
  }
}

/**
 * Maryland State Inspection Wrapper
 *
 * @implements StateInterface
 */
class MD implements StateInterface
{
  // Class Variables
  private $endpoints = Array(
    "emissions" => "http://mva.mdveip.com/",
    "inspection" => "https://egov.maryland.gov/msp/vsi/api/Lookup/Inspections?vehicleVin=%s",
  );

  /**
   * @see StateInterface::fetch_records
   */
  public function fetch_safety(string $VIN) : array
  {
    // Variables
    $endpoint = sprintf($this->endpoint, $VIN);

    // Fetch Records
    $records = json_decode(InspectionHelper::http_get($endpoint), true) ?: [];
    $parsed_records = Array();

    /**
     * tbd
     */

    // Return
    return $parsed_records;
  }
}
?>
