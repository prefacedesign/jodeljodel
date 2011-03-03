<?php
	$url = $dlurl = '';
	
	if ($saved)
	{
		$url = $this->Bl->fileURL($saved, $version);
		$dlurl = $this->Bl->fileURL($saved, $version, true);
	}
	
	echo json_encode(compact('error', 'validationErrors', 'saved', 'url', 'dlurl', 'filename'));