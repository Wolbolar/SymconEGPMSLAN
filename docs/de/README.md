# IPSymconEGPMSLAN
[![Version](https://img.shields.io/badge/Symcon-PHPModul-red.svg)](https://www.symcon.de/service/dokumentation/entwicklerbereich/sdk-tools/sdk-php/)
[![Version](https://img.shields.io/badge/Symcon%20Version-%3E%205.1-green.svg)](https://www.symcon.de/service/dokumentation/installation/)

Modul für IP-Symcon ab Version 4. Ermöglicht das Senden von Befehlen an die Steckdose von Gembird EnerGenie EG-PMS2-LAN.

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)  
2. [Voraussetzungen](#2-voraussetzungen)  
3. [Installation](#3-installation)  
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration](#5-konfiguartion)  
6. [Anhang](#6-anhang)  
7. [Versions-Historie](#7-versions-historie)

## 1. Funktionsumfang

Mit Steckdosenleiste von Gembird EnerGenie EG-PMS-LAN läst sich über LAN anschließen, die 4 Steckdosen Ports der Leiste können einzeln ein / ausgeschaltet werden.
!! Aufgrund von Einschränkungen der Steckdose und um stabil zu funktionieren kann die Steckdose momentan nur alle 10 Sekunden ein oder aus geschaltet werden.

## 2. Voraussetzungen

 - IPS 4.x
 - Steckdosenleiste Gembird EnerGenie EG-PMS-LAN

## 3. Installation

### a. Laden des Moduls

Die Webconsole von IP-Symcon mit _http://<IP-Symcon IP>:3777/console/_ öffnen. 


Anschließend oben rechts auf das Symbol für den Modulstore klicken

![Store](img/store_icon.png?raw=true "open store")

Im Suchfeld nun

```
EGPMSLAN
```  

eingeben

![Store](img/module_store_search.png?raw=true "module search")

und schließend das Modul auswählen und auf _Installieren_

![Store](img/install.png?raw=true "install")

drücken.


#### Alternatives Installieren über Modules Instanz

Den Objektbaum _Öffnen_.

![Objektbaum](img/objektbaum.png?raw=true "Objektbaum")	

Die Instanz _'Modules'_ unterhalb von Kerninstanzen im Objektbaum von IP-Symcon (>=Ver. 5.x) mit einem Doppelklick öffnen und das  _Plus_ Zeichen drücken.

![Modules](img/Modules.png?raw=true "Modules")	

![Plus](img/plus.png?raw=true "Plus")	

![ModulURL](img/add_module.png?raw=true "Add Module")
 
Im Feld die folgende URL eintragen und mit _OK_ bestätigen:

```
https://github.com/Wolbolar/SymconEGPMSLAN
```  
	
Anschließend erscheint ein Eintrag für das Modul in der Liste der Instanz _Modules_    

Es wird im Standard der Zweig (Branch) _master_ geladen, dieser enthält aktuelle Änderungen und Anpassungen.
Nur der Zweig _master_ wird aktuell gehalten.

![Master](img/master.png?raw=true "master") 

Sollte eine ältere Version von IP-Symcon die kleiner ist als Version 5.1 (min 4.3) eingesetzt werden, ist auf das Zahnrad rechts in der Liste zu klicken.
Es öffnet sich ein weiteres Fenster,

![SelectBranch](img/select_branch.png?raw=true "select branch") 

hier kann man auf einen anderen Zweig wechseln, für ältere Versionen kleiner als 5.1 (min 4.3) ist hier
_Old-Version_ auszuwählen. 


### b. Einrichtung in IP-Symcon
	
In IP-Symcon nun _Instanz hinzufügen_ (_Rechtsklick -> Objekt hinzufügen -> Instanz_) auswählen unter der Kategorie, unter der man die EGPMSLAN hinzufügen will,
und _Gembird_ auswählen.


## 4. Funktionsreferenz

### Steckdosen Ports schalten

Die Steckdosenleiste EG-PMS2-LAN verfügt über 4 Ports diese können einzeln an / ausgeschaltet werden.


## 5. Konfiguration:

### EG-PMS-LAN:

| Eigenschaft   | Typ     | Standardwert | Funktion                           |
| :-----------: | :-----: | :----------: | :--------------------------------: |
| Host          | string  |              | IP Adresse der Steckdosenleiste    |
| Passwort      | string  |              | Passwort vom Webinterface          |
| Updateinterval| string  |              | Updateinterval in Sekunden         |


## 6. Anhang

###  a. Funktionen:

#### EG-PMS-LAN:

`EGPMSLAN_PowerOn(integer $InstanceID, integer $Port)`

Einschalten des Steckdosenports $Port (1,2,3,4)

`EGPMSLAN_PowerOff(integer $InstanceID, integer $Port)`

Ausschalten des Steckdosenports $Port (1,2,3,4)


###  b. GUIDs und Datenaustausch:

#### EGPMSLAN:

GUID: `{0113804D-EE66-48B9-8FF8-F81E4A5BAAEB}` 

## 7. Versions-Historie

- 1.1 @ 10.06.2019 17:57<br>
  - HTTP-Requests wurden ohne TIMEOUT durchgeführt
