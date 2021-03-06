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
 * State Endpoint Wrapper Interface
 */
interface StateInspectionInterface
{
  /**
   * A endpoint wrapper to return a structured state emissions test result
   * All return attributes are nullable, given that each state returns different information.
   *
   * @param string VIN number
   * @return array Array<Array<?string type, ?string date, ?bool result, ?int odometer, ?string url>, ...>
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
   * @return array Array<Array<?bool result, ?string date, ?int odometer, ?string url>, ...>
   * @return array Structured return result
   * @throws TypeError
   * @throws UnsupportedStateOperationException
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:05:27-040
   */
  public function fetch_safety(string $VIN) : array;
}
?>
