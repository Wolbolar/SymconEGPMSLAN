<?
class EGPMSLAN extends IPSModule
{
	public function Create()
	{
		parent::Create();
		$this->RegisterPropertyString("Host", "");
		$this->RegisterPropertyString("Passwort", "");
		$this->RegisterPropertyInteger("UpdateInterval", 15);
	}
	public function ApplyChanges()
	{
		parent::ApplyChanges();
		//IP Prüfen
		$ip = $this->ReadPropertyString('Host');
		$passwort = $this->ReadPropertyString('Passwort');
		if (!filter_var($ip, FILTER_VALIDATE_IP) === false && $passwort !== "")
		{
			$this->SetStatus(102); //IP Adresse ist gültig -> aktiv
		}
		elseif ($passwort == "")
		{
			$this->SetStatus(203); //Passwort Feld ist leer
		}
		elseif (filter_var($ip, FILTER_VALIDATE_IP) === false)
		{
			$this->SetStatus(203); //IP Adresse ist ungültig
		}
		$this->RegisterTimer('INTERVAL', $this->ReadPropertyInteger('UpdateInterval'), 'EGPMSLAN_getStatus($id)');

		$state1 = $this->RegisterVariableBoolean("STATE1", "Status Dose 1", "~Switch", 1);
		$this->EnableAction("STATE1");
		$state1 = $this->RegisterVariableBoolean("STATE2", "Status Dose 2", "~Switch", 1);
		$this->EnableAction("STATE2");
		$state1 = $this->RegisterVariableBoolean("STATE3", "Status Dose 3", "~Switch", 1);
		$this->EnableAction("STATE3");
		$state1 = $this->RegisterVariableBoolean("STATE4", "Status Dose 4", "~Switch", 1);
		$this->EnableAction("STATE4");
	}
	protected function RegisterTimer($ident, $interval, $script) {
		$id = @IPS_GetObjectIDByIdent($ident, $this->InstanceID);
		if ($id && IPS_GetEvent($id)['EventType'] <> 1) {
			IPS_DeleteEvent($id);
			$id = 0;
		}
		if (!$id) {
			$id = IPS_CreateEvent(1);
			IPS_SetParent($id, $this->InstanceID);
			IPS_SetIdent($id, $ident);
		}
		IPS_SetName($id, $ident);
		IPS_SetHidden($id, true);
		IPS_SetEventScript($id, "\$id = \$_IPS['TARGET'];\n$script;");
		if (!IPS_EventExists($id)) throw new Exception("Ident with name $ident is used for wrong object type");
		if (!($interval > 0)) {
			IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, 1);
			IPS_SetEventActive($id, false);
		} else {
			IPS_SetEventCyclic($id, 0, 0, 0, 0, 1, $interval);
			IPS_SetEventActive($id, true);
		}
	}
	public function RequestAction($ident, $value)
	{
		switch ($ident)
		{
			case 'STATE1':
				if($value == true)
				{
					$this->PowerOn(1);
				}
				else
				{
					$this->PowerOff(1);
				}
				break;
			case 'STATE2':
				if($value == true)
				{
					$this->PowerOn(2);
				}
				else
				{
					$this->PowerOff(2);
				}
				break;
			case 'STATE3':
				if($value == true)
				{
					$this->PowerOn(3);
				}
				else
				{
					$this->PowerOff(3);
				}
				break;
			case 'STATE4':
				if($value == true)
				{
					$this->PowerOn(4);
				}
				else
				{
					$this->PowerOff(4);
				}
				break;
		}
	}
	const ON = 1;
	const OFF = 0;
	const TIMEOUT = 1000;

	protected function Logout()
	{
		$ip = $this->ReadPropertyString('Host');
		$html = $this->postRequest('http://'.$ip.'/login.html', array('pw' => ''));
		if (strstr($html, "EnerGenie Web:"))
			$result=TRUE;
		else
			$result=FALSE;

		return $result;
	}

	protected function Login()
	{
		$ip = $this->ReadPropertyString('Host');
		$passwort = $this->ReadPropertyString('Passwort');
		$html = $this->postRequest('http://'.$ip.'/login.html', array('pw' => $passwort));
		if ($html=="" OR strstr($html, "EnerGenie Web:"))
			$result=FALSE;
		else
			$result=TRUE;

		return $result;
	}

	protected function lastChange()
	{
		$lastchange1 = IPS_GetVariable($this->GetIDForIdent('STATE1'))["VariableChanged"];
		$lastchange2 = IPS_GetVariable($this->GetIDForIdent('STATE2'))["VariableChanged"];
		$lastchange3 = IPS_GetVariable($this->GetIDForIdent('STATE3'))["VariableChanged"];
		$lastchange4 = IPS_GetVariable($this->GetIDForIdent('STATE4'))["VariableChanged"];
		$currenttime = time();
		$lastswitch = $currenttime - $lastchange1;
		return $lastswitch;
	}

	//Get State
	public function getStatus()
	{
		if ($this->Login())
		{
			$ip = $this->ReadPropertyString('Host');
			$html = $this->getRequest('http://'.$ip.'/energenie.html', array());
			preg_match_all('/var sockstates \= \[([0-1],[0,1],[0,1],[0,1])\]/', $html, $matches);
			if(!isset($matches[1][0])) { return false; }
			$states = explode(',', $matches[1][0]);
			$this->Logout();

			if ($states[0] == 0)
			{
				SetValueBoolean($this->GetIDForIdent('STATE1'), false);
			}
			if ($states[0] == 1)
			{
				SetValueBoolean($this->GetIDForIdent('STATE1'), true);
			}
			if ($states[1] == 0)
			{
				SetValueBoolean($this->GetIDForIdent('STATE2'), false);
			}
			if ($states[1] == 1)
			{
				SetValueBoolean($this->GetIDForIdent('STATE2'), true);
			}
			if ($states[2] == 0)
			{
				SetValueBoolean($this->GetIDForIdent('STATE3'), false);
			}
			if ($states[2] == 1)
			{
				SetValueBoolean($this->GetIDForIdent('STATE3'), true);
			}
			if ($states[3] == 0)
			{
				SetValueBoolean($this->GetIDForIdent('STATE4'), false);
			}
			if ($states[3] == 1)
			{
				SetValueBoolean($this->GetIDForIdent('STATE4'), true);
			}
			return array(1=>$states[0], 2=>$states[1], 3=>$states[2], 4=>$states[3]);
		}
		else
			return false;
	}

	/**
	 * Do the switch
	 */
	protected function doSwitch($switches)
	{
		if ($this->Login())
		{
			foreach($switches as $port => $state)
			{
				$ports = array(1 => '', 2 => '', 3 => '', 4 => '');
				$ports[$port] = $state;
				$params = array();
				foreach($ports as $port => $state)
				{
					if(in_array($state, array(self::ON, self::OFF)))
					{
						$params['cte'.$port] = $state;
					}
				}
				$this->postRequest('http://'.$this->ReadPropertyString('Host'), $params);
			}
			$this->Logout();
		}
	}

	protected function postRequest($url, $fields)
	{
		$fields_string_array = array();
		foreach((array)$fields as $key=>$value)
		{
			$fields_string_array[] = $key.'='.$value;
		}
		$fields_string = join('&', $fields_string_array);
		//open connection
		$ch = curl_init();

		// configure
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::TIMEOUT);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, self::TIMEOUT);
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_USERAGENT, "IPSymcon");
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

		//execute post
		$result = curl_exec($ch);
		//$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		//close connection
		curl_close($ch);

		return $result;

	}

	protected function getRequest($url, $fields)
	{
		$fields_string_array = array();
		foreach((array)$fields as $key=>$value)
		{
			$fields_string_array[] = $key.'='.$value;
		}
		$fields_string = join('&', $fields_string_array);
		//open connection
		$ch = curl_init();

		// configure
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, self::TIMEOUT);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS, self::TIMEOUT);
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url . ($fields_string != '' ? '?' . $fields_string : ''));

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		// provide html
		return $result;
	}

	public function PowerOn(int $slot)
	{
		//$switchstate = $this->getStatus();
		switch ($slot)
		{
			case 1:
				$switchslots = array(
					1 => self::ON
				);
				break;

			case 2:
				$switchslots = array(
					2 => self::ON
				);
				break;

			case 3:
				$switchslots = array(
					3 => self::ON
				);
				break;

			case 4:
				$switchslots = array(
					4 => self::ON
				);
				break;
		}

		$slotIdent = "STATE".$slot;
		// Puffer damit nicht sofort hintereinander geschaltet wird
		$lastswitch = $this->lastChange();
		if ($lastswitch <10)
		{
			$waitswitch = (10 - $lastswitch) * 100;
			IPS_Sleep($waitswitch);
			SetValueBoolean($this->GetIDForIdent($slotIdent), true);
			return $this->doSwitch($switchslots);
		}
		else
		{
			SetValueBoolean($this->GetIDForIdent($slotIdent), true);
			return $this->doSwitch($switchslots);
		}
	}
	public function PowerOff(int $slot)
	{
		//$switchstate = $this->getStatus();
		switch ($slot)
		{
			case 1:
				$switchslots = array(
					1 => self::OFF
				);
				break;

			case 2:
				$switchslots = array(
					2 => self::OFF
				);
				break;

			case 3:
				$switchslots = array(
					3 => self::OFF
				);
				break;

			case 4:
				$switchslots = array(
					4 => self::OFF
				);
				break;
		}

		$slotIdent = "STATE".$slot;
		// Puffer damit nicht sofort hintereinander geschaltet wird
		$lastswitch = $this->lastChange();
		if ($lastswitch <10)
		{
			$waitswitch = (10 - $lastswitch) * 100;
			IPS_Sleep($waitswitch);
			SetValueBoolean($this->GetIDForIdent($slotIdent), false);
			return $this->doSwitch($switchslots);
		}
		else
		{
			SetValueBoolean($this->GetIDForIdent($slotIdent), false);
			return $this->doSwitch($switchslots);
		}

	}
}
?>
