<?php

/**
 *
 * Copyright 2010-2012, Preface Design LTDA (http://www.preface.com.br")
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2010-2011, Preface Design LTDA (http://www.preface.com.br)
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link          https://github.com/prefacedesign/jodeljodel Jodel Jodel public repository 
 */


class DashBoardShell extends Shell
{
	function main()
	{
		$this->args = array();
		$this->out();
		$this->out('Warning: automatically calling the synching shell.');
		$this->out('To avoid this message, just call the synching shell directly, typing:');
		$this->out('./cake dashboard synch');
		$this->out('./cake dashboard synch force-update');
		$this->out();
		$this->in('Press ENTER to continue...');
		$this->synch();
	}
	
	function synch()
	{
		$force_update = false;
		if (isset($this->args[0]) && $this->args[0] == 'force-update')
			$force_update = true;
#		else
#			$force_update = $this->in('Force update for all dashboard entries?', array('y', 'n'), 'n') == 'y';

		$modules = Configure::read('jj.modules');
		
		foreach ($modules as $name => $module)
		{
			if (!isset($module['plugged']) || !in_array('dashboard', $module['plugged']))
				continue;

			$this->out('Synching dashboard for ' . $name);

			$Model =& ClassRegistry::init($module['model']);
			if (!$Model->Behaviors->attached('DashDashboardable'))
			{
				$this->out("  {$module['model']} has not DashDashboardable behavior attached!");
				$this->out('Synch failed');
			}
			else
			{
				extract($Model->synchronizeWithDashboard($force_update));
				$this->out("  Removed entries: " . count($childless));
				$this->out("  Updated entries: " . count($outdated));
				$this->out("  Created entries: " . count($doesnt_have));
				$this->out('Synch done.');
			}

			$this->out();
		}
	}
}
