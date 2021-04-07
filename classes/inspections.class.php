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
class InvalidVINLengthException extends \Exception {}

/**
 * State Endpoint Wrapper Interface
 */
interface StateInterface
{
  /**
   * A endpoint wrapper to return a structured state inspection search result
   *
   * @param string $VIN
   * @return array Array<Array<string pass, ?string url>>
   * @return array Structured return result
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:05:27-040
   */
  public function fetch_records(string $VIN) : array;
}

/**
 * A generalized U.S. state vehicle safety inspection record lookup
 */
class Inspections {
  // Class Variables
  private $states = null;
  private $vin_length = 17;

  /**
   * Class Constructor
   *
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:11:14-040
   */
  public function __construct()
  {
    $this->states = Array(
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
  public function records(string $VIN, string $state) : array
  {
    // Checks
    if (!array_key_exists($state, $this->states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== $this->vin_length) {
      throw new InvalidVINLengthException("The provided VIN is not a valid length");
    }

    // Fetch Records
    return $this->states[$state]->fetch_records($VIN);
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


?>
