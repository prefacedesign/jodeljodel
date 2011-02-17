<?php

class JjConsoleShell extends Shell {

	function main()
	{
	
		while (1)
		{			
			$answer = $this->in(__('JjConsoleShell::main What is the command to execute? Say "quit" to exit.', true));
			
			if (in_array($answer,array('quit','exit','q')))
				return;
				
			eval($answer);
			$this->out("\n");
		}
	}
}
?>