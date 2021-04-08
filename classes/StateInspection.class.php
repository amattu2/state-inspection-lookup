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
class UnsupportedStateOperationException extends \Exception {}

/**
 * A state inspection class
 */
class StateInspection
{
  /**
   * A endpoint wrapper to return emissions and inspection results
   *
   * @param string VIN number
   * @return array Array<Array<Emissions>, Array<Safety>>
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T14:49:13-040
   */
  public function fetch_all(string $VIN) : array
  {
    // Variables
    $result = Array("Safety" => [], "Emissions" => []);

    // Fetch Safety Inspection
    try {
      $result["Safety"] = $this->fetch_safety($VIN);
    } catch (\Exception $e) {}

    // Fetch Emissions Inspection
    try {
      $result["Emissions"] = $this->fetch_emissions($VIN);
    } catch (\Exception $e) {}

    // Return
    return $result;
  }
}
?>
