<?php
// Files
require("classes/inspections.class.php");

// Find Maryland inspections
echo "<h1>Maryland Inspection Lookup</h1>", "<h2>Inspections</h2>", "<pre>";
$records = amattu\Inspections::safety("4JGBB8GB4BA662410", "MD");
print_r($records);
echo "</pre>", "<h2>Emissions</h2>";
$records = amattu\Inspections::emissions("1J8HG48K17C696395", "MD");
echo "</pre>";
