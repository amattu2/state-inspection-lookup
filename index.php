<?php
// Files
require("classes/Inspections.class.php");
require("classes/StateInspection.class.php");
require("interfaces/StateInspection.interface.php");
require("classes/states/MD.class.php");

// Find inspections
$example_vin = $_GET["vin"] ?: "1J8HG48K17C696395";
$example_state = $_GET["state"] ?: "MD";
$all = amattu\Inspections::all($example_vin, $example_state);

echo "<h1>Inspection Lookup</h1>", "<h2>Inspections</h2>", "<pre>";
//$records = amattu\Inspections::safety("4JGBB8GB4BA662410", "MD");
print_r($all["Safety"]);
echo "</pre>", "<h2>Emissions</h2>", "<pre>";
//$records = amattu\Inspections::emissions("1J8HG48K17C696395", "MD");
print_r($all["Emissions"]);
echo "</pre>";
