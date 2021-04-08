<?php
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
