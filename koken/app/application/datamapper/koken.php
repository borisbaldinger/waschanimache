<?php

class DMZ_Koken {
    
	function prepare_for_output($object, $options, $exclude = array(), $booleans = array(), $dates = array())
	{
		if (isset($options['fields']))
		{
			$fields = explode(',', $options['fields']);
		}
		else
		{
			$fields = $object->fields;
		}
		$fields = array_diff($fields, $exclude);
		$public_fields = array_intersect($object->fields, $fields);
		$data = array();
		foreach($public_fields as $name)
		{
			$val = $object->{$name};
			if (in_array($name, $booleans))
			{
				$val = (bool) $val;
			}
			else if (in_array($name, $dates))
			{
				if (is_numeric($val))
				{
					$val = array(
							'datetime' => date('Y/m/d G:i:s', $val),
							'timestamp' => (int) $val
						);
				}
				else
				{
					$val = array('datetime' => null, 'timestamp' => null);
				}	
			}
			else if (is_numeric($val))
			{
				$val = (float) $val;
			}
			$data[$name] = $val;
		}
		return array($data, $fields);
	}

	function paginate($object, $options)
	{
		$final = array();
		if ($options['limit'])
		{		
			$total = $object->get_clone()->count();
			if (isset($options['cap']) && $options['cap'] < $total)
			{
				$total = $options['cap'];
			}
			$final['page'] = (int) $options['page'];
			$final['pages'] = ceil($total/$options['limit']);
			$final['per_page'] = min((int) $options['limit'], $total);
			$final['total'] = $total;
			if ($options['page'] == 1)
			{
				$start = 0;
			}
			else
			{
				$start = ($options['limit']*($options['page']-1));
			}
			$object->limit($options['limit'], $start);
		}
		else
		{
			$final = array(
				'page' => 1,
				'pages' => 1
			);
		}
		return $final;
	}
}

/* End of file pagination.php */
/* Location: ./application/datamapper/pagination.php */