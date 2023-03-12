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

require "states/MD.php";
require "states/VA.php";

use TypeError;

// Exception Classes
class UnsupportedStateException extends \Exception
{}
class InvalidVINLengthException extends \Exception
{}

/**
 * A generalized U.S. state vehicle safety inspection record lookup
 */
class Inspections
{
  // Class Variables
  private static $states = null;
  private const VIN_LENGTH = 17;
  public CONST ISO_3166_2_supported_states = [
    "MD",
  ];

  /**
   * Class State Initialization
   *
   * @author Alec M. <https://amattu.com>
   * @date 2021-04-07T11:11:14-040
   */
  private static function setup_classes()
  {
    self::$states = [
      "MD" => new MD(),
    ];
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
  public static function all(string $VIN, string $state): array
  {
    // Checks
    if (!self::$states) {
      self::setup_classes();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::VIN_LENGTH) {
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
  public static function safety(string $VIN, string $state): array
  {
    // Checks
    if (!self::$states) {
      self::setup_classes();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::VIN_LENGTH) {
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
  public static function emissions(string $VIN, string $state): array
  {
    // Checks
    if (!self::$states) {
      self::setup_classes();
    }
    if (!array_key_exists($state, self::$states)) {
      throw new UnsupportedStateException("The provided state is not currently supported");
    }
    if (strlen($VIN) !== self::VIN_LENGTH) {
      throw new InvalidVINLengthException("The provided VIN is not a valid length");
    }

    // Fetch Records
    return self::$states[$state]->fetch_emissions($VIN);
  }
}
