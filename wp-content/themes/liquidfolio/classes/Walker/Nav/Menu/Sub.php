<?php
class Walker_Nav_Menu_Sub extends Walker_Nav_Menu
{
	function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
	{
		if (!$element)
		{
			return;
		}

		$id_field = $this->db_fields['id'];

		//display this element
		if (is_array($args[0]))
			$args[0]['has_children'] = !empty($children_elements[$element->$id_field]);

		//Adds the 'parent' class to the current item if it has children		
		if (!empty($children_elements[$element->$id_field]))
			array_push($element->classes, 'dropdown');

		$cb_args = array_merge(array(&$output, $element, $depth), $args);

		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if (($max_depth == 0 || $max_depth > $depth + 1 ) && isset($children_elements[$id]))
		{
			foreach ($children_elements[$id] as $child)
			{

				if (!isset($newlevel))
				{
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge(array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
			}
			unset($children_elements[$id]);
		}

		if (isset($newlevel) && $newlevel)
		{
			//end the child delimiter
			$cb_args = array_merge(array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge(array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
	
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ($color = $this->getColor($item))	? ' data-color="'   . esc_attr($color) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	
	/**
	 * Get item color
	 * @param object $item
	 * @return string
	 */
	function getColor($item)
	{
		switch ($item->type)
		{
			case 'post_type':
				if( $color = $this->getPostColor($item->object_id))
				{
					return $color;
				}
				else
				{
					return $this->getGlobalColor();
				}
				break;
			case 'taxonomy':
				if($color = $this->getCategoryColor($item->object_id))
				{
					return $color;
				}
				return $this->getGlobalColor();
				break;
			default:
				return $this->getGlobalColor();
				break;
		}
	}
	
	/**
	 * Get post meta color value if exist
	 * @param int $post_id post id
	 * @return string
	 */
	function getPostColor($post_id)
	{
		$color = get_post_meta($post_id, SHORTNAME . '_post_color', true);
		
		if($color && $color != '#')
		{
			return $color;
		}
		return '';
	}
	
	/**
	 * Get category  term meta color value if $isCategory === true<br>
	 * or get color of last post category
	 * @param int $id post or category ID
	 * @param boolean $isCategory search color for category or post
	 * @return string
	 */
	function getCategoryColor($id)
	{
		$color = get_tax_meta($id, SHORTNAME . '_cat_color');
		if($color != '#') 
		{
			return $color;
		}
		
		return '';
	}
	
	/**
	 * Global color value (Theme settings) 
	 * @return string
	 */
	function getGlobalColor()
	{
		return get_option(SHORTNAME . '_accent_color');
	}
}
?>