<?php

class Spriter_JS
{
	private $_defaultSpriteName = 'sprite.js';
	private $_options = array(
		'addTryCatch' => true,
		'dev' => true,
		'sef' => true, // Wrap sprite in Self Executing Function
	);


	public function __construct($config = array())
	{
		$this->_options = array_merge($this->_options, $config);
	}

	public function get($folder = './', $spriteName = false)
	{
		try 
		{
			if (!$spriteName) $spriteName = $this->_defaultSpriteName;
			if ($this->_options['dev'] &&
				$this->_getLastModFile($folder) != $folder . '/' .$spriteName &&
				$this->make($folder, $spriteName, false))
				{
					$spriteName .= '?' . date("ymdHis");
				}
			
			return $spriteName;
		}
		catch (Exception $e)
		{
			return false;
		}
	}


	public function make($folder = './', $spriteName = false, $logs = true)
	{
		try 
		{
			if(!is_dir($folder))
				throw new Exception("invalid directory name");
			
			$spriteName = (!$spriteName) ? $this->_defaultSpriteName : $spriteName;
			$files = scandir($folder);
			$contentStart = "// last updated " . date("Y-m-d H:i:s") . "\n\n";
			$content = '';

			foreach ($files as $value) 
			{
				if($value == '.' || $value == '..' || substr($value, strlen($value) - 3) != '.js' || $spriteName == $value) continue;

				$filePath = $folder . '/' . $value;

				if ($logs) echo $filePath . '<br /><br />';
				
				$preFile = '// file ' . $value . " start\n\n";
				$preFile .= ($this->_options['addTryCatch']) ? "try { \n" : '';
				
				$postFile = ($this->_options['addTryCatch']) ? "} catch (e) { if (console && console.log)  console.log('error ' + e + ' in file " . $value . "'); }\n\n" : '';
				$postFile .= "// file " . $value . " end\n\n";
				
				$content .= $preFile . file_get_contents ( $filePath )."\n" . $postFile;
			}
			if($content == '')
				throw new Exception("no js files if folder " . $folder);
				
			$content = ($this->_options['sef']) ? "(function( $ ) {\n\n" . $content . "\n})( jQuery );" : $content;
			
			file_put_contents( $folder . '/' . $spriteName, $contentStart . $content );
			if ($logs) 
				echo 'spriting folder ' . $folder . ' success';
			return true;
		} 
		catch (Exception $e)
		{
			if ($logs) 
				echo 'sprite making error: ' . $e->getMessage() . '<br /><br />';
			else
				return false;
		}
	}


	private function _getLastModFile($dir)
	{
		$files = glob($dir . "/*.js");
		if (!count($files))
			throw new Exception("no js files if folder " . $folder);
		$files = array_combine($files, array_map("filemtime", $files));
		// echo '<pre>';
		// print_r($files);
		@arsort($files);
		// print_r(key($files));

		return @key($files);
	}
}