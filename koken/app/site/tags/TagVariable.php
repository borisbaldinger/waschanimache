<?php

	class TagVariable extends Tag {

		function generate()
		{

			Koken::$template_variable_keys[] = $this->parameters['name'];
			$value = '"' . $this->parameters['value'] . '"';
			$value = preg_replace_callback('/{([a-z._\[\]0-9]+)}/', array($this, 'attr_replace'), $value);

			return <<<DOC
<?php Koken::\$template_variables['{$this->parameters['name']}'] = $value; ?>
DOC;
		}

	}