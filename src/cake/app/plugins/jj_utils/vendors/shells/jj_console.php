<?php

class JjConsoleShell extends Shell {

	var $issuedCommands = array();

	function main()
	{
		$command = '';
	
		while (1)
		{			
			$answer = $this->in(__('JjConsoleShell::main What is the command to execute? Say "quit" to exit, "help" to achieve help.', true));
			
			if (substr($answer, -1) == "\\")
			{
				$command .= substr($answer,0,strlen($answer)-1) . "\n";
				do 
				{
					$answer = $this->in('');
					if (substr($answer, -1) == "\\")
					{
						$command .= substr($answer,0,strlen($answer)-1) . "\n";
					}
					else
					{
						$command .= $answer;
					}
				}
				while (substr($answer, -1) == "\\");
			}
			else
				$command .= $answer;
			
			switch ($command)
			{
				case 'help':
					$this->out(__('This is the help', true));
				break;
				
				case 'quit':
				case 'exit':
				case 'q':
					return;
				break;
				
				default:
					$this->out();
					$issuedCommands[] = $command;
					if (substr($command,0,1) == ":")
					{
						$command = substr($command,1);
						$result = eval ('return (' . $command . ');');
						if (is_array($result))
							print_r($result);
						else
							var_dump($result);
					}
					else
					{
						eval ($command . ';');
					}
					
			}
			$this->out("\n");
			$command = '';	
		}
	}
}
?>
