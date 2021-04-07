# Introduction
This is a basic library/wrapper for digital vehicle state safety/emissions inspection record lookups. If you need to check the last date(s) a vehicle was state inspected, and you know the state, this library is for you. A few states also support returning information on the last emissions test. Originally designed for integration within a automotive service management SaaS application.

# States Supported
|State|Supported Operations|Notes|
|:-:|:-|:-|
|Maryland|[Emissions Inspections](http://mva.mdveip.com/), [Safety Inspections](https://egov.maryland.gov/msp/vsi/api/Lookup/Inspections?vehicleVin=)|Pending further tests, but it appears that MD only keeps the e-inspection record until it expires (6 months)|

# Usage
TDB

# To-Do Integrations
### Safety Inspections
A list of potential integrations with state systems. These require advanced parsing or endpoint manipulation to grab the information.

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
