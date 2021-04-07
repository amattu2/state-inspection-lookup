<?php
// Files
require("classes/inspections.class.php");

// Find Maryland inspections
echo "<h1>Maryland Inspection Lookup</h1>", "<pre>";
$records = amattu\Inspections::all("4JGBB8GB4BA662410", "MD");
print_r($records);
echo "</pre>";
