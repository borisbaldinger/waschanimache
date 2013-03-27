<?php	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Data Mapper Configuration
 *
 * Global configuration settings that apply to all DataMapped models.
 */

include(dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR. 'configuration' . DIRECTORY_SEPARATOR . 'database.php');

$config['prefix'] = $KOKEN_DATABASE['prefix'];
$config['join_prefix'] = $KOKEN_DATABASE['prefix'] . 'join_';
$config['error_prefix'] = '<p>';
$config['error_suffix'] = '</p>';
$config['created_field'] = 'created_on';
$config['updated_field'] = 'modified_on';
$config['local_time'] = FALSE;
$config['unix_timestamp'] = TRUE;
$config['lang_file_format'] = 'model_${model}';
$config['field_label_lang_format'] = '${model}_${field}';
$config['auto_transaction'] = FALSE;
$config['auto_populate_has_many'] = FALSE;
$config['auto_populate_has_one'] = FALSE;
$config['all_array_uses_ids'] = FALSE;
// set to FALSE to use the same DB instance across the board (breaks subqueries)
// Set to any acceptable parameters to $CI->database() to override the default.
$config['db_params'] = '';
// Uncomment to enable the production cache
// $config['production_cache'] = 'datamapper/cache';
$config['extensions_path'] = 'datamapper';
$config['extensions'] = array('array', 'koken');

/* End of file datamapper.php */
/* Location: ./application/config/datamapper.php */
