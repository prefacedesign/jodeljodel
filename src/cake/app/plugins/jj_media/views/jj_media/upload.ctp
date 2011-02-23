<?php
	
	if ($saved)
		$url = $this->Bl->fileURL($saved, $version);
	
	echo json_encode(compact('error', 'validationErrors', 'saved', 'url', 'filename'));