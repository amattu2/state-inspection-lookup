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

use TypeError;

// Exception Classes
class UnsupportedStateOperationException extends \Exception
{}

/**
 * A base class for state inspection states
 */
class StateInspectionBase
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
  public function fetch_all(string $VIN): array
  {
    // Variables
    $result = ["Safety" => [], "Emissions" => []];

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
