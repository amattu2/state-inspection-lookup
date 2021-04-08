# Introduction
This is a basic library/wrapper for digital vehicle state safety/emissions inspection record lookups. If you need to check the last date(s) a vehicle was state inspected, and you know the state, this library is for you. A few states also support returning information on the last emissions/smog test. Originally designed for integration within a automotive service management SaaS application.

# States Supported
|State|Supported Operations|Notes|
|:-:|:-|:-|
|Maryland|[Emissions/Smog](http://mva.mdveip.com/), [Safety](https://egov.maryland.gov/msp/vsi/api/Lookup/Inspections?vehicleVin=)|Pending further tests, but it appears that MD only keeps the e-inspection record until it expires (6 months)|

# Usage
### Files
Import the three core files
```PHP
require("classes/Inspections.class.php");
require("classes/StateInspection.class.php");
require("interfaces/StateInspection.interface.php");
```

Then import the state (or states) file
```PHP
require("classes/states/MD.class.php");
```

### Functions
##### Inspections::all
Retrieve all inspection types (smog/safety inspections)
```PHP
$all = amattu\Inspections::all("VIN", "STATE_ABBR");
```

`VIN` is the 17 digit VIN number of the vehicle of interest. `STATE_ABBR` is the *2 digit* [ISO-3166-2](https://en.wikipedia.org/wiki/ISO_3166-2:US) state abbreviation.

Returns an array containing `Emissions`, `Safety` multi-dimensional arrays.

##### Inspections::safety
Retrieve all state safety (mechanical) inspection reports.

PHPDoc
```PHP
/**
 * A endpoint wrapper to return a structured state safety inspection search result
 * All return attributes are nullable, given that each state returns different information.
 *
 * @param string VIN number
 * @return array Array<Array<?bool result, ?string date, ?string url>, ...>
 * @return array Structured return result
 * @throws TypeError
 * @throws UnsupportedStateOperationException
 * @author Alec M. <https://amattu.com>
 * @date 2021-04-07T11:05:27-040
 */
```

Usage
```PHP
amattu\Inspections::safety("VIN", "STATE_ABBR");
```

`VIN` is the 17 digit VIN number of the vehicle of interest. `STATE_ABBR` is the *2 digit* [ISO-3166-2](https://en.wikipedia.org/wiki/ISO_3166-2:US) state abbreviation.

Returns the following array:
```PHP
Array
(
  [0] => Array
  (
    [date] => ?string (Format: YYYY-MM-DD)
    [result] => ?bool
    [url] => ?string
  )
)
```

##### Inspections::emissions
Pull all emissions records for a vehicle.

PHPDoc
```PHP
/**
 * A endpoint wrapper to return a structured state emissions test result
 * All return attributes are nullable, given that each state returns different information.
 *
 * @param string VIN number
 * @return array Array<Array<?string type, ?string date, ?bool result, ?string url>, ...>
 * @throws TypeError
 * @throws UnsupportedStateOperationException
 * @author Alec M. <https://amattu.com>
 * @date 2021-04-07T14:51:13-040
 */
```

Usage
```PHP
amattu\Inspections::emissions("VIN", "STATE_ABBR")
```

`VIN` is the 17 digit VIN number of the vehicle of interest. `STATE_ABBR` is the *2 digit* [ISO-3166-2](https://en.wikipedia.org/wiki/ISO_3166-2:US) state abbreviation.

Returns the following array:
```PHP
Array
(
  [0] => Array
  (
    [date] => ?string (Format: YYYY-MM-DD)
    [result] => ?bool
    [type] => ?string
    [url] => ?string
  )
)
```

# To-Do Integrations
A list of potential integrations with state systems. These require advanced parsing or endpoint manipulation to grab the information.

### Safety Inspections
|State|Portal|
|:-|:-:|
|Delaware|[Link](https://dealers.dmv.de.gov/Dealer/VehicleInspection/citizeninspection)|
|California|[Link](https://www.bar.ca.gov/services/Vehicle/PubTstQry.aspx)|
|Virginia|[Link](https://www.virginiavip.org/PublicSite/Pages/VehicleLookup.aspx)|
|Georgia|[Link](https://www.cleanairforce.com/motorists/vir-reprints)|
|Texas|[Link](https://mytxcar.org/txcar_net/SearchVehicleTestHistory.aspx)|

### Emissions Inspections
|State|Portal|
|:-|:-:|

# Notes
https://haynes.com/en-us/tips-tutorials/what-know-about-vehicle-inspections-all-50-states


# Requirements & Dependencies
PHP 7
