<?php

	class TagCovers extends Tag {

		protected $allows_close = true;
		public $tokenize = true;

		function generate()
		{

			$token = '$value' . Koken::$tokens[1];
			$ref = '$value' . Koken::$tokens[0];

			if (isset($this->parameters['limit']) && is_numeric($this->parameters['limit']))
			{
				$limit = "\$arr = array_slice({$token}['album']['covers'], 0, {$this->parameters['limit']});";
			}
			else
			{
				$limit = "\$arr = {$token}['album']['covers'];";
			}
			return <<<OUT
<?php

	if (isset({$token}['album']) && isset({$token}['album']['covers']) && count({$token}['album']['covers'] ) > 0):

		$ref = array();
		$limit
		{$ref}['covers'] =& \$arr;
		{$ref}['__loop__'] =& \$arr;
?>
OUT;
		}
	}