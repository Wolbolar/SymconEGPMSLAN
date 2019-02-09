# IPSymconMyStrom
[![Version](https://img.shields.io/badge/Symcon-PHPModule-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon%20Version-%3E%205.1-green.svg)](https://www.symcon.de/en/service/documentation/installation/)

Module for IP Symcon Version 4 or higher. Allows you to send commands to the Gembird EnerGenie EC-PMS2-LAN socket.

## Documentation

**Table of Contents**

1. [Features](#1-features)
2. [Requirements](#2-requirements)
3. [Installation](#3-installation)
4. [Function reference](#4-functionreference)
5. [Configuration](#5-configuration)
6. [Annex](#6-annex)

## 1. Features

With power strip by Gembird EnerGenie EG-PMS-LAN can connect via LAN, the 4 sockets ports of the bar can be individually switched on / off.
!! Due to power outages and to be stable, the socket can currently only be turned on or off every 10 seconds.

## 2. Requirements

 - IPS 4.x
 - Power strip Gembird EnerGenie EG-PMS-LAN

## 3. Installation

### a. Loading the module

Open the IP Console's web console with _http://<IP-Symcon IP>:3777/console/_.

Then click on the module store icon in the upper right corner.

![Store](img/store_icon.png?raw=true "open store")

In the search field type

```
EGPMSLAN
```  


![Store](img/module_store_search_en.png?raw=true "module search")

Then select the module and click _Install_

![Store](img/install_en.png?raw=true "install")


#### Install alternative via Modules instance

_Open_ the object tree.

![Objektbaum](img/object_tree.png?raw=true "object tree")	

Open the instance _'Modules'_ below core instances in the object tree of IP-Symcon (>= Ver 5.x) with a double-click and press the _Plus_ button.

![Modules](img/modules.png?raw=true "modules")	

![Plus](img/plus.png?raw=true "Plus")	

![ModulURL](img/add_module.png?raw=true "Add Module")
 
Enter the following URL in the field and confirm with _OK_:


```	
https://github.com/Wolbolar/SymconEGPMSLAN
```
    
and confirm with _OK_.    
    
Then an entry for the module appears in the list of the instance _Modules_

By default, the branch _master_ is loaded, which contains current changes and adjustments.
Only the _master_ branch is kept current.

![Master](img/master.png?raw=true "master") 

If an older version of IP-Symcon smaller than version 5.1 (min 4.3) is used, click on the gear on the right side of the list.
It opens another window,

![SelectBranch](img/select_branch_en.png?raw=true "select branch") 

here you can switch to another branch, for older versions smaller than 5.1 (min 4.3) select _Old-Version_ .

### b.  Setup in IP-Symcon

In IP-Symcon add _Instance_ (_rightclick -> add object -> instance_) under the category under which you want to add the EGPMSLAN instance,
and select _Gembird_.
In the configuration form, enter the IP address of the device as well as the MAC address of the device.

Then confirm with _Apply Changes_.

![Apply_Changes](img/apply_changes_en.png?raw=true "Adpply Changes")


## 4. Function reference

### EC-PMS2-LAN

The EC-PMS2-LAN power strip has 4 ports which can be individually switched on / off.

## 5. Configuration:

### EG-PMS-LAN:

| Property      | Type    | Value        | Description                        |
| :-----------: | :-----: | :----------: | :--------------------------------: |
| Host          | string  |              | IP Adresss                         |
| Passwort      | string  |              | Password from the Webinterface     |
| Updateinterval| string  |              | Updateinterval in Seconds          |


## 6. Annex

###  a. Functions:

#### EG-PMS-LAN:

`EGPMSLAN_PowerOn(integer $InstanceID, integer $Port)`

Switching on the socket port $Port (1,2,3,4)

`EGPMSLAN_PowerOff(integer $InstanceID, integer $Port)`

Switching off the socket port $Port (1,2,3,4)


###  b. GUIDs and data exchange:

#### EGPMSLAN:

GUID: `{0113804D-EE66-48B9-8FF8-F81E4A5BAAEB}` 