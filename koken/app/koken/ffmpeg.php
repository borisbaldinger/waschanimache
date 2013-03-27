<?php

class FFmpeg {
	var $path;
	var $ffmpeg = 'ffmpeg';
	var $info = null;
	var $duration = 0;
	var $dimensions = 0;

	function ffmpeg($path = false) {
		$this->path = $path;
		$this->ffmpeg = FFMPEG_PATH_FINAL;
		$this->lame = str_replace('ffmpeg', 'lame', FFMPEG_PATH_FINAL);
	}

	function version() {
		if (function_exists('exec') && (DIRECTORY_SEPARATOR == '/' || (DIRECTORY_SEPARATOR == '\\' && $this->ffmpeg != 'ffmpeg'))) {
			exec($this->ffmpeg . ' -version 2>&1', $out);
			if (empty($out)) {
				return false;
			} else {
				if (strpos(strtolower($out[0]), 'ffmpeg') !== false && preg_match('/(\d+.\d+(.\d+)?)/', $out[0], $matches)) {
					return $matches[1];
				} else {
					return false;
				}
			}
		}
		return false;
	}

	function version_lame() {
		if (function_exists('exec') && (DIRECTORY_SEPARATOR == '/' || (DIRECTORY_SEPARATOR == '\\' && $this->lame != 'lame'))) {
			exec($this->lame . ' --help 2>&1', $out);
			if (empty($out)) {
				return false;
			} else {
				if (strpos(strtolower($out[0]), 'lame') !== false && preg_match('/(\d+\.\d+(\.\d+)?)/', $out[0], $matches)) {
					return 'LAME ' . $matches[1];
				} else {
					return false;
				}
			}
		}
		return false;
	}

	function check() {
		return file_exists($this->path);
	}

	function info() {
		exec($this->ffmpeg . " -i {$this->path} 2>&1", $this->info);
	}

	function nadjiVrijednosti($byte1, $byte2)
	{
		$byte1 = hexdec(bin2hex($byte1));
		$byte2 = hexdec(bin2hex($byte2));
		return ($byte1 + ($byte2*256));
	}

	function waveform()
	{
		$target_directory = dirname($this->path) . DIRECTORY_SEPARATOR . basename($this->path) . '_previews' . DIRECTORY_SEPARATOR;
		make_child_dir($target_directory);
		$mp3_tmp = $this->path . '.tmp.mp3';
		$wav_tmp = $this->path . '.wav';

		$waveform = $target_directory . 'waveform.svg';

		exec($this->lame . " {$this->path} -q 9 -m m -b 8 --resample 8 $mp3_tmp && $this->lame --decode $mp3_tmp $wav_tmp");

		unlink($mp3_tmp);

		$filename = $wav_tmp;

		$handle = fopen ($filename, "r");

		//dohvacanje zaglavlja wav datoteke
		$zaglavlje[] = fread ($handle, 4);
		$zaglavlje[] = bin2hex(fread ($handle, 4));
		$zaglavlje[] = fread ($handle, 4);
		$zaglavlje[] = fread ($handle, 4);
		$zaglavlje[] = bin2hex(fread ($handle, 4));
		$zaglavlje[] = bin2hex(fread ($handle, 2));
		$zaglavlje[] = bin2hex(fread ($handle, 2));
		$zaglavlje[] = bin2hex(fread ($handle, 4));
		$zaglavlje[] = bin2hex(fread ($handle, 4));
		$zaglavlje[] = bin2hex(fread ($handle, 2));
		$zaglavlje[] = bin2hex(fread ($handle, 2));
		$zaglavlje[] = fread ($handle, 4);
		$zaglavlje[] = bin2hex(fread ($handle, 4));

		//bitrate wav datoteke
		$peek = hexdec(substr($zaglavlje[10], 0, 2));
		$bajta = $peek / 8;

		//provjera da li se radi o mono ili stereo wavu
		$kanala = hexdec(substr($zaglavlje[6], 0, 2));

		if($kanala == 2){
		  $omjer = 40;
		}
		else{
		  $omjer = 80;
		}

		while(!feof($handle)){
		  $bytes = array();
		  //get number of bytes depending on bitrate
		  for ($i = 0; $i < $bajta; $i++){
		    $bytes[$i] = fgetc($handle);
		  }
		  switch($bajta){
		    //get value for 8-bit wav
		    case 1:
		        $data[] = $this->nadjiVrijednosti($bytes[0], $bytes[1]);
		        break;
		    //get value for 16-bit wav
		    case 2:
		      if(ord($bytes[1]) & 128){
		        $temp = 0;
		      }
		      else{
		        $temp = 128;
		      }
		      $temp = chr((ord($bytes[1]) & 127) + $temp);
		      $data[]= floor($this->nadjiVrijednosti($bytes[0], $temp) / 256);
		      break;
		  }
		  //skip bytes for memory optimization
		  fread ($handle, $omjer);
		}

		// close and cleanup
		fclose($handle);
		unlink($filename);

		$detail = 4;
		$length = ceil(sizeof($data) / $detail);
		// create original image width based on amount of detail

		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . $length . '" height="' . $length . '" viewBox="0 0 ' . $length . ' ' . $length .'">';
		$svg .= '<defs><style type="text/css"><![CDATA[line{stroke:rgb(200,200,200);stroke-width:3;stroke-linecap:round}]]></style></defs>';
		$svg .= '<rect width="' . $length . '" height="' . $length . '" />';

		for($d = 0; $d < sizeof($data); $d += $detail) {
			// relative value based on height of image being generated
			// data values can range between 0 and 255
			$v = (int) ($data[$d] / 255 * $length);
			$x = $d / $detail;
			$top = ceil(0 + ($length - $v));
			$bottom = ceil($length - ($length - $v));
			$svg .= '<line x1="' . $x . '" y1="' . $top . '" x2="' . $x . '" y2="' . $bottom . '" />';
		}

		$svg .= '</svg>';
		$fp = fopen($waveform, 'w');
		fwrite($fp, $svg);
		fclose($fp);

		if (file_exists($waveform))
		{
			return $length;
		}
		else
		{
			return false;
		}
	}

	function create_thumbs()
	{
		$target_directory = dirname($this->path) . DIRECTORY_SEPARATOR . basename($this->path) . '_previews' . DIRECTORY_SEPARATOR;
		make_child_dir($target_directory);
		$duration = $this->duration() - 2;
		$bits = ceil($duration/12);
		if ($bits == 0) {
			$bits = 1;
		}
		$rate = 1/$bits;
		if ($rate < 0.1) {
			$rate = 0.1;
		}

		$i = 1;
		$cmd = array();
		while ($i < $duration) {
			$i_str = str_pad($i, 5, '0', STR_PAD_LEFT);
			$cmd[] = $this->ffmpeg . " -ss $i -i \"{$this->path}\" -vframes 1 -an -f mjpeg \"$i_str.jpg\"";
			$i += $bits;
		}

		chdir($target_directory);
		if (DIRECTORY_SEPARATOR == '\\') {
			foreach($cmd as $c) {
				exec($c);
			}
		} else {
			$cmd = join(' && ', $cmd);
			exec($cmd);
		}

		$files = directory_map($target_directory, true);
		if ($files)
		{
			return $files[0] . ':50:50';
		}
		else
		{
			return null;
		}
	}

	function dimensions() {
		if (is_null($this->info)) {
			$this->info();
		}

		foreach($this->info as $line) {
			if (strpos($line, 'Video:') !== false) {
				preg_match('/([0-9]{2,5})x([0-9]{2,5})/', $line, $matches);
				list(,$w, $h) = $matches;
				$this->dimensions = array($w, $h);
				return $this->dimensions;
			}
		}
	}

	function duration() {
		if ($this->duration > 0) {
			return $this->duration;
		}

		if (is_null($this->info)) {
			$this->info();
		}

		foreach($this->info as $line) {
			if (strpos($line, 'Duration:') !== false) {
				preg_match('/Duration: ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $line, $matches);
				list(,$h, $m, $s) = $matches;
				$this->duration = ($h*60*60) + ($m*60) + $s;
				return $this->duration;
			}
		}
	}
}

?>