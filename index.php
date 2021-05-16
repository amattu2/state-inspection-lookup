<?php
// Files
require("classes/Inspections.class.php");
require("classes/StateInspection.class.php");
require("interfaces/StateInspection.interface.php");
require("classes/states/MD.class.php");

// Find inspections
$example_vin = $_GET["vin"] ?: "1J8HG48K17C696395";
$example_state = $_GET["state"] ?: "MD";
$example_type = $_GET["type"] ?: "all";

// Lookup Inspection Type
if ($example_type == "all") {
	$all = amattu\Inspections::all($example_vin, $example_state);
	echo "<h1>Inspection Lookup</h1>", "<h2>Safety</h2>", "<pre>";
	print_r($all["Safety"]);

	echo "</pre>", "<h2>Emissions</h2>", "<pre>";
	print_r($all["Emissions"]);
	echo "</pre>";
} else if ($example_type == "safety") {
	echo "<h1>Inspection Lookup</h1>", "<h2>Safety</h2>", "<pre>";
	$records = amattu\Inspections::safety($example_vin, $example_state);
	print_r($records);
} else if ($example_type == "emissions") {
	echo "<h1>Inspection Lookup</h1>", "<h2>Emissions</h2>", "<pre>";
	$records = amattu\Inspections::emissions($example_vin, $example_state);
	print_r($records);
	echo "</pre>";
}
