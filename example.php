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

// Files
require "vendor/autoload.php";

// Find inspections
$example_vin = $_GET["vin"] ?? "1J8HG48K17C696395";
$example_state = $_GET["state"] ?? "MD";
$example_type = $_GET["type"] ?? "all";

// Lookup Inspection Type
if ($example_type == "all") {
  $all = amattu2\Inspections::all($example_vin, $example_state);
  echo "<h1>Inspection Lookup</h1>", "<h2>Safety</h2>", "<pre>";
  print_r($all["Safety"]);

  echo "</pre>", "<h2>Emissions</h2>", "<pre>";
  print_r($all["Emissions"]);
  echo "</pre>";
} else if ($example_type == "safety") {
  echo "<h1>Inspection Lookup</h1>", "<h2>Safety</h2>", "<pre>";
  $records = amattu2\Inspections::safety($example_vin, $example_state);
  print_r($records);
} else if ($example_type == "emissions") {
  echo "<h1>Inspection Lookup</h1>", "<h2>Emissions</h2>", "<pre>";
  $records = amattu2\Inspections::emissions($example_vin, $example_state);
  print_r($records);
  echo "</pre>";
}
