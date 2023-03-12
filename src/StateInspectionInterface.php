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

/**
 * A interface to define the methods that each state class must implement
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
  public function fetch_emissions(string $VIN): array;

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
  public function fetch_safety(string $VIN): array;
}
