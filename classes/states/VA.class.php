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
 * Virginia State Inspection Wrapper
 *
 * @extends StateInspection
 * @implements StateInspectionInterface
 */
class VA extends StateInspection implements StateInspectionInterface
{
  // Class Variables
  private $endpoints = Array();

  /**
   * @see StateInspectionInterface::fetch_safety
   */
  public function fetch_safety(string $VIN) : array
  {
    throw new UnsupportedStateOperationException("This state does not support safety inspection results");
  }

  /**
   * @see StateInspectionInterface::fetch_emissions
   * @see DOMDocument
   */
  public function fetch_emissions(string $VIN) : array
  {
    throw new UnsupportedStateOperationException("This state does not support emissions results");
  }
}
?>
