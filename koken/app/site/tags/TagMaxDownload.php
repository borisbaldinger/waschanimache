<?php

	class TagMaxDownload extends Tag {

		protected $allows_close = true;
		public $tokenize = true;

		function generate()
		{

			$token = '$value' . Koken::$tokens[1];
			$ref = '$value' . Koken::$tokens[0];

			return <<<OUT
<?php
	if (isset({$token}['max_download']) && {$token}['max_download']['raw'] !== 'none'):
		$ref =& {$token}['max_download'];

		if ({$ref}['raw'] === 'original')
		{
			{$ref}['link'] = {$token}['original']['url'];
			{$ref}['width'] = {$token}['original']['width'];
			{$ref}['height'] = {$token}['original']['height'];
		}
		else
		{
			if (isset({$token}['presets'][{$ref}['raw']]))
			{
				{$ref}['link'] = {$token}['presets'][{$ref}['raw']]['url'];
				{$ref}['width'] = {$token}['presets'][{$ref}['raw']]['width'];
				{$ref}['height'] = {$token}['presets'][{$ref}['raw']]['height'];
			}
			else
			{
				\$__last = array_pop({$token}['presets']);
				{$ref}['link'] = \$__last['url'];
				{$ref}['width'] = \$__last['width'];
				{$ref}['height'] = \$__last['height'];
			}
			{$ref}['link'] = preg_replace('/\?\d+$/', '.dl', {$ref}['link']);
		}


		{$ref}['title'] =& {$ref}['clean'];
		{$ref}['label'] = preg_replace('/\s.*$/', '', {$ref}['clean']);

		{$ref}['max_download'] =& {$ref};
?>
OUT;
		}
	}