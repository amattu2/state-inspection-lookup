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
 * A generalized U.S. state vehicle safety inspection record lookup
 */
class Inspections {
  // Class Variables
  private static $states = null;
  private static $vin_length = 17;
  public CONST ISO_3166_2_supported_states = Array(
    "MD"
  );

  /**
   * Class State Initialization
   *
   * @throws None
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:11:14-040
   */
  private function setup_classes()
  {
    self::$states = Array(
      "MD" => new MD(),
    );
  }

  /**
   * Fetch All State Inspection Records
   *
   * @param string VIN number
   * @param string ISO_3166-2:US state abbreviation
   * @return array <See StateInspectionInterface>
   * @throws TypeError
   * @throws UnsupportedStateException
   * @throws InvalidVINLengthException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:15:26-040
   */
  public static function all(string $VIN, string $state) : array
  {
    // Checks
    if (!self::$states) {
      self::setup_classes();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::$vin_length) {
      throw new InvalidVINLengthException("The provided VIN is not a valid length");
    }

    // Fetch Records
    return self::$states[$state]->fetch_all($VIN);
  }

  /**
   * Fetch State Safety Inspection Records
   *
   * @param string VIN number
   * @param string U.S. state
   * @return array <See StateInspectionInterface>
   * @throws TypeError
   * @throws UnsupportedStateException
   * @throws InvalidVINLengthException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T17:20:43-040
   */
  public static function safety(string $VIN, string $state) : array
  {
    // Checks
    if (!self::$states) {
      self::setup_classes();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::$vin_length) {
      throw new InvalidVINLengthException("The provided VIN is not a valid length");
    }

    // Fetch Records
    return self::$states[$state]->fetch_safety($VIN);
  }

  /**
   * Fetch Emissions Records
   *
   * @param string VIN number
   * @param string U.S. state
   * @return array <See StateInspectionInterface>
   * @throws TypeError
   * @throws UnsupportedStateException
   * @throws InvalidVINLengthException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T17:19:39-040
   */
  public static function emissions(string $VIN, string $state) : array
  {
    // Checks
    if (!self::$states) {
      self::setup_classes();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::$vin_length) {
      throw new InvalidVINLengthException("The provided VIN is not a valid length");
    }

    // Fetch Records
    return self::$states[$state]->fetch_emissions($VIN);
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

  /**
   * Perform HTTP Post Request
   *
   * @param string url
   * @param array post params
   * @return ?string result body
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-03-31T11:11:18-040
   */
  public static function http_post(string $endpoint, array $fields) : ?string
  {
    // cURL Initialization
    $handle = curl_init();
    $field_string = "";
    $result = "";
    $error = 0;
    foreach($fields as $k => $v) { $field_string .= $k ."=". $v . "&"; }
    rtrim($field_string, "&");

    // Options
    curl_setopt($handle, CURLOPT_URL, $endpoint);
    curl_setopt($handle, CURLOPT_POST, count($fields));
    curl_setopt($handle, CURLOPT_POSTFIELDS, $field_string);
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
    return $result && !$error ? $result : "";
  }

  /**
   * Validate a string against a date format
   *
   * @param string date string
   * @param string date format
   * @return bool valid
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-08T09:55:55-040
   */
  public static function validate_date(string $date, string $format = 'Y-m-d') : bool {
    // Variables
    $d = \DateTime::createFromFormat($format, $date);

    // Return
    return $d && $d->format($format) === $date;
  }
}
?>
