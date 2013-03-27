<?php

class Darkroom {

	public static $presets = array(
		'tiny' => array(
			'width' => 60,
			'height' => 60,
			'quality' => 80,
			'sharpness' => 0.75
		),
		'small' => array(
			'width' => 100,
			'height' => 100,
			'quality' => 80,
			'sharpness' => 0.75
		),
		'medium' => array(
			'width' => 480,
			'height' => 480,
			'quality' => 85,
			'sharpness' => 0.5
		),
		'medium_large' => array(
			'width' => 800,
			'height' => 800,
			'quality' => 85,
			'sharpness' => 0.5
		),
		'large' => array(
			'width' => 1024,
			'height' => 1024,
			'quality' => 85,
			'sharpness' => 0.5
		),
		'xlarge' => array(
			'width' => 1600,
			'height' => 1600,
			'quality' => 90,
			'sharpness' => 0.25
		),
		'huge' => array(
			'width' => 2048,
			'height' => 2048,
			'quality' => 90,
			'sharpness' => 0
		)
	);

	////
	// The workhorse develop function
	////
	static function develop($options) {

		$defaults = array(
			'square' => false,
			'force' => false,
			'hires' => false,
			'source_width' => false,
			'source_height' => false
		);

		$o = array_merge($defaults, $options);

		$old_mask = umask(0);

		if ($o['hires'])
		{
			$o['width'] *= 2;
			$o['height'] *= 2;
			$o['quality'] /= 2;
		}

		list($im_version,$imagick) = self::processing_library_version();

		if (!$o['source_width'] || !$o['source_height'])
		{
			list($o['source_width'], $o['source_height']) = getimagesize($o['source']);
		}

		if ($o['width'] == $o['source_width'] && $o['height'] == $o['source_height'] && !$o['force']) {
			copy($o['source'], $o['destination']);
			return;
		}

		$original_aspect = $o['source_width']/$o['source_height'];
		$new_aspect = $o['width']/$o['height'];

		if ($o['sharpening'] > 0 && version_compare($im_version, '6.2.9', '>='))
		{
			$sigma = $o['sharpening'];
			if ($sigma < 1)
			{
				$sigma = 1;
			}
			else
			{
				$sigma = sqrt($sigma);
			}
		}
		else
		{
			$o['sharpening'] = false;
		}

		if (version_compare($im_version, '6.0.0'))
		{
			$strip = ' -strip';
		}
		else if (!$imagick)
		{
			$strip = '';
		}

		if ($imagick)
		{
			$image = new Imagick();
		}

		if ($o['square'])
		{
			$resize_h = $resize_w = 0;

			if ($original_aspect >= $new_aspect) {
				$resize_h = $o['height'];
				$size_str = 'x' . $o['height'];
				$int_w = ($o['source_width']*$o['height'])/$o['source_height'];
				$int_h = $o['height'];
				$pos_x = $int_w * ($o['focal_x']/100);
				$pos_y = $o['height'] * ($o['focal_y']/100);
				$hint_w = $int_w;
				$hint_h = $o['height'];
			} else {
				$resize_w = $o['width'];
				$size_str = $o['width'] . 'x';
				$int_h = ($o['source_height']*$o['width'])/$o['source_width'];
				$int_w = $o['width'];
				$pos_x = $o['width'] * ($o['focal_x']/100);
				$pos_y = $int_h * ($o['focal_y']/100);
				$hint_w = $o['width'];
				$hint_h = $int_w;
			}

			$crop_y = $pos_y - ($o['height']/2);
			$crop_x = $pos_x - ($o['width']/2);

			if ($crop_y < 0) {
				$crop_y = 0;
			} else if (($crop_y+$o['height']) > $int_h) {
				$crop_y = $int_h - $o['height'];
			}
			if ($crop_x < 0) {
				$crop_x = 0;
			} else if (($crop_x+$o['width']) > $int_w) {
				$crop_x = $int_w - $o['width'];
			}

			if ($imagick)
			{
				$image->setSize($hint_w, $hint_h);
				$image->readImage($o['source']);
				$image->stripImage();
				$image->setImageCompressionQuality($o['quality']);
				$image->scaleImage($resize_w, $resize_h, $bestfit);
				$image->cropImage($o['width'], $o['height'], $crop_x, $crop_y);
				$image->setImagePage($o['width'], $o['height'], 0, 0);
			}
			else
			{
				$cmd = MAGICK_PATH_FINAL . $strip . " -size {$hint_w}x{$hint_h} \"{$o['source']}\" -depth 8 -density 72 -quality {$o['quality']} -resize $size_str -crop {$o['width']}x{$o['height']}+{$crop_x}+{$crop_y}";
				if ($im_major_version == 4) {
					$cmd .= ' +repage';
				} else {
					$cmd .= ' -page 0+0';
				}
			}
		}
		else
		{
			$bestfit = true;
			if ($o['width'] == 0 || $o['height'] == 0)
			{
				$hint_w = $hint_h = max($o['width'], $o['height']);
				$o['width'] = max($o['width'], 0);
				$o['height'] = max($o['height'], 0) . '^';
				$bestfit = false;
			}
			else
			{
				if ((($original_aspect >= $new_aspect && $o['width'] > $o['source_width']) || ($original_aspect < $new_aspect && $o['height'] > $o['source_height'])) && !$o['force']) {
					copy($o['source'], $o['destination']);
					return;
				}

				$hint_w = $o['width'];
				$hint_h = $o['height'];
			}

			if ($imagick)
			{
				$image->setSize($hint_w, $hint_h);
				$image->readImage($o['source']);
				$image->stripImage();
				$image->setImageCompressionQuality($o['quality']);
				$image->scaleImage( $o['width'], $o['height'], $bestfit);
			}
			else
			{
				$cmd = MAGICK_PATH_FINAL . $strip . " -size {$hint_w}x{$hint_h} \"{$o['source']}\" -depth 8 -density 72 -quality {$o['quality']} -resize {$o['width']}x{$o['height']}";
			}

		}

		if ($o['sharpening'] > 0)
		{
			// Set radius to 0 to let IM decide the best value based on sigma
			$o['sharpening'] = 0;
			if ($imagick)
			{
				$image->unsharpMaskImage( $o['sharpening'], $sigma, 1, 0 );
			}
			else
			{
				$cmd .= " -unsharp {$o['sharpening']}x{$sigma}+1.0+0";
			}
		}


		if ($imagick)
		{
			$image->writeImage( $o['destination'] );
			$image->clear();
			$image->destroy();
		}
		else
		{

			$cmd .= " \"{$o['destination']}\"";
			exec($cmd);
		}
	}

	////
	// Check ImageMagick version
	////
	static function processing_library_version() {

		$version_string = $imagick = false;
		if (in_array('imagick', get_loaded_extensions()))
		{
			$im = new Imagick;
			$v = $im->getVersion();
			$version_string = $v['versionString'];
			$imagick = true;
		}
		else if (function_exists('exec') && (DIRECTORY_SEPARATOR == '/' || (DIRECTORY_SEPARATOR == '\\' && MAGICK_PATH_FINAL != 'convert'))) {
			exec(MAGICK_PATH_FINAL . ' -version', $out);
			$version_string = $out[0];
		}

		if ($version_string)
		{
			preg_match('/\d+\.\d+\.\d+([^\s]+)?/', $version_string, $matches);
			$version = $matches[0];
			return array($version, $imagick);
		}
		else
		{
			return false;
		}
	}
}

