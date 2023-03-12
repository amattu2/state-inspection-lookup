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

/**
 * Virginia State Inspection Wrapper
 *
 * @extends StateInspectionBase
 * @implements StateInspectionInterface
 */
class VA extends StateInspectionBase implements StateInspectionInterface
{
  // Class Variables
  private $endpoints = [];

  /**
   * @see StateInspectionInterface::fetch_safety
   */
  public function fetch_safety(string $VIN): array
  {
    throw new UnsupportedStateOperationException("This state does not support safety inspection results");
  }

  /**
   * @see StateInspectionInterface::fetch_emissions
   * @see DOMDocument
   */
  public function fetch_emissions(string $VIN): array
  {
    throw new UnsupportedStateOperationException("This state does not support emissions results");
  }
}
