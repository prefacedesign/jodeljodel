<?php
	
	switch($type[0])
	{
		case 'cork':
			if (!isset($type[1]))
			{
				echo $this->Bl->paraDry(explode("\n", $this->Text->autoLink($data['TextTextCork']['text'])));
			}
			else if ($type[1] == 'form')
			{
				echo 'Write here the cork form';
			}
		break;
	}
?>
