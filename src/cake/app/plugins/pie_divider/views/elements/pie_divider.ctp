<?php

switch ($type[0])
{
	case 'buro':
		switch ($type[1])
		{
			case 'form':
				echo $this->Buro->sform(array(), array('model' => 'PieDivider.PieDivider'));
					
					echo $this->Buro->input(
						array(),
						array(
							'fieldName' => 'id',
							'type' => 'hidden'
						)
					);
					
					echo $this->Bl->pDry(__d('content_stream', 'PieDivider instructions', true));
					
					echo $this->Buro->submit(array(), array('cancel' => true));
					
				echo $this->Buro->eform();
			break;
			
			case 'view':
				echo $this->Bl->br();
				echo $this->Bl->hr();
				echo $this->Bl->br();
			break;
		}
	break;
}