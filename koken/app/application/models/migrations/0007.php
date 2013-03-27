<?php

	$path = FCPATH . DIRECTORY_SEPARATOR . '.htaccess';

	if (file_exists($path))
	{
		$htaccess = create_htaccess();
		file_put_contents($path, $htaccess);
	}

	$done = true;