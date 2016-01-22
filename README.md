# IPSymconEGPMSLAN

Modul für IP-Symcon ab Version 4. Ermöglicht das Senden von Befehlen an die Steckdose von Gembird EnerGenie EG-PMS2-LAN.
Beta Test

## Dokumentation

**Inhaltsverzeichnis**

1. [Funktionsumfang](#1-funktionsumfang)  
2. [Voraussetzungen](#2-voraussetzungen)  
3. [Installation](#3-installation)
4. [Funktionsreferenz](#4-funktionsreferenz)
5. [Konfiguration] (#5-konfiguration)  
6. [Anhang](#6-anhang)  

## 1. Funktionsumfang

Mit Steckdosenleiste von Gembird EnerGenie EG-PMS-LAN läst sich über LAN anschließen, die 4 Steckdosen Ports der Leiste können einzeln ein / ausgeschaltet werden.
!! Aufgrund von Einschränkungen der Steckdose und um stabil zu funktionieren kann die Steckdose momentan nur alle 10 Sekunden ein oder aus geschaltet werden.

## 2. Voraussetzungen

 - IPS 4.x
 - Steckdosenleiste Gembird EnerGenie EG-PMS-LAN

## 3. Installation

### a. Laden des Moduls

   In der *IP Symcon Management Console* unter *Kern Instanzen* über *Modules* in IP-Symcon (Ver. 4.x) folgende URL hinzufügen:
	
    `https://github.com/Wolbolar/SymconEGPMSLAN.git`  

### b. Einrichtung in IPS

   In IP-Symcon das gewünschte Device anlegen. Als Hersteller ist Gembird auszuwählen.
	

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

## 7. Anhang

###  a. Funktionen:

#### EG-PMS-LAN:

`EGPMSLAN_PowerOn(integer $InstanceID, integer $Port)`
Einschalten des Steckdosenports $Port (1,2,3,4)

`EGPMSLAN_PowerOff(integer $InstanceID, integer $Port)`
Ausschalten des Steckdosenports $Port (1,2,3,4)


###  b. GUIDs und Datenaustausch:

#### EGPMSLAN:

GUID: `{0113804D-EE66-48B9-8FF8-F81E4A5BAAEB}` 

