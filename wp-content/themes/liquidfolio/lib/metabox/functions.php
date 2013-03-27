<?php

// add select_sidebar rendering function.
add_action( 'cmb_render_select_sidebar', 'render_select_sidebar', 10, 2 );

/**
 * Render select_sidebar element
 * @param array $field [name, desc, id ...]
 * @param string $current_meta_value current element value
 */
function render_select_sidebar($field, $current_meta_value )
{
	$sidebars = getSidebarsList();
	if (is_array($sidebars) && !empty($sidebars))
	{
		$html = "<select name=".$field['id']." id=".$field['id'].">";
		foreach ($sidebars as $sidebar)
		{
			if ($current_meta_value == $sidebar['value'])
			{
				$html .= "<option value=".$sidebar['value']." selected='selected'>".$sidebar['name']."</option>\n";
			}
			else
			{
				 $html .= "<option value=".$sidebar['value']." >".$sidebar['name']."</option>\n";
			}
		}
	}
	echo $html;
}

add_filter( 'cmb_meta_boxes', 'lf_metaboxes' );



function getSidebarsList()
{
	$sidebar_list = array();
	$sidebar_list[] = array('name'=>'Use global sidebar', 'value'=>'""');
	$sidebars = Sidebar_Generator::get_sidebars();
	if (is_array($sidebars) && !empty($sidebars))
	{
		foreach ($sidebars as $class=>$name)
		{
			$sidebar_list[] = array('name'=>$name, 'value'=>$class);
		}
	}
	return $sidebar_list;
}

/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function lf_metaboxes( array $meta_boxes ) {

	$meta_boxes[] = array(
		'id'         => 'post_sidebar',
		'title'      => __('Custom sidebar','liquidfolio'),
		'pages'      => array('page','post',Custom_Posts_Type_Gallery::POST_TYPE), // Page type
		'context'    => 'side',
		'priority'   => 'low',
		'show_names' => false, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __('Sidebar','liquidfolio'),
				'desc'    => __('Sidebar to display','liquidfolio'),
				'id'      => SHORTNAME . '_page_sidebar',
				'type'    => 'select_sidebar',
            ),
		),
	);
	
	$meta_boxes[] = array(
		'id'       => 'gallery-slider',
		'title'    => __('Slideshow Settings', 'liquidfolio'),
		'pages'    => array('post',Custom_Posts_Type_Gallery::POST_TYPE),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __('The Slides', 'liquidfolio'),
				'id'   => SHORTNAME . '_project_slider',
				'type' => 'portfolio',
				'std'  => '',
				'desc' => __('Add slides to gallery slider', 'liquidfolio')
				)
			)
	);
	
	$meta_boxes[] = array(
		'id'       => 'hide-descriptions-and-title',
		'title'    => __('Displaing post details in blog', 'liquidfolio'),
		'pages'    => array('post',Custom_Posts_Type_Gallery::POST_TYPE),
		'context'  => 'normal',
		'priority' => 'high',
		'show_names' => true,
		'fields'   => array(
			array(
				//'name' => __('The Slides', 'liquidfolio'),
				'id'   => SHORTNAME . '_display_post_details_in_blog',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use global', 'value' => 'global', ),
					array( 'name' => 'Use custom', 'value' => 'custom', ),
				),
			),
			array(
				'name'    => 'Hide title',
				//'desc'    => 'Hide title',
				'id'      => SHORTNAME . '_hide_post_title',
				'type'    => 'checkbox',
				'std' => false,
			),
			array(
				'name'    => 'Hide description',
				//'desc'    => 'Hide description',
				'id'      => SHORTNAME . '_hide_post_desc',
				'type'    => 'checkbox',
				'std' => false,
			),
		)
	);

	$meta_boxes[] = array(
		'id'       => 'post-video',
		'title'    => __('Video Settings', 'liquidfolio'),
		'pages'    => array('post', Custom_Posts_Type_Gallery::POST_TYPE),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __('Video URL', 'liquidfolio'),
				'id'   => SHORTNAME . '_post_video_url',
				'type' => 'video_url',
				'std'  => '',
				'desc' => __('Youtube or Vimeo video URL', 'liquidfolio')
//				'desc' => __('Supported formats: WebMv, OGV and M4V', 'liquidfolio')
				)
			)
	);
	$meta_boxes[] = array(
		'id'       => 'post-audio',
		'title'    => __('Audio Settings', 'liquidfolio'),
		'pages'    => array('post', Custom_Posts_Type_Gallery::POST_TYPE),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __('Audio URL', 'liquidfolio'),
				'id'   => SHORTNAME . '_post_audio_url',
				'type' => 'audio_url',
				'std'  => '',
				'desc' => __('Supported formats: MP3, M4A and OGA', 'liquidfolio')
				)
			)
	);
	$meta_boxes[] = array(
		'id'       => 'post-link',
		'title'    => __('Link Settings', 'liquidfolio'),
		'pages'    => array('post'),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __('Link URL', 'liquidfolio'),
				'id'   => SHORTNAME . '_post_link_url',
				'type' => 'text',
				'std'  => '',				
				'desc' => __('Write your custom URL', 'liquidfolio')
				)
			)
	);
	$meta_boxes[] = array(
		'id'       => 'post-tweet',
		'title'    => __('Twitter Settings', 'liquidfolio'),
		'pages'    => array('post'),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __('Tweet URL', 'liquidfolio'),
				'id'   => SHORTNAME . '_post_tweet',
				'type' => 'text',
				'std'  => '',				
				'desc' => __('Insert direct URL to your tweet', 'liquidfolio')
				)
			)
	);
	$meta_boxes[] = array(
		'id'       => 'post-quote',
		'title'    => __('Quote Settings', 'liquidfolio'),
		'pages'    => array('post'),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => __('The Quote', 'liquidfolio'),
				'id'   => SHORTNAME . '_post_quote',
				'type' => 'textarea',
				'std'  => '',				
				'desc' => __('Write  quote', 'liquidfolio')
				),
			array(
				'name' => __('The Quote Author', 'liquidfolio'),
				'id'   => SHORTNAME . '_post_quote_author',
				'type' => 'text',
				'std'  => '',				
				'desc' => __('Write  quote author', 'liquidfolio')
				)
			)
	);





	$meta_boxes[] = array(
		'id'         => 'post_size',
		'title'      => 'Post listing size',
		'pages'      => array('post'), // Page type
		'context'    => 'side',
		'priority'   => 'low',
		'show_names' => false, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => '',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_size',
				'options' => array(
					array( 'name' => 'Normal', 'value' => '', ),
					array( 'name' => 'Small', 'value' => 'small_post_size', ),
				),
				'std'	  => 'small_post_size',
				'type'    => 'select',
            ),

		),
	);

	$meta_boxes[] = array(
		'id'         => 'gallery_color',
		'title'      => 'Color Settings',
		'pages'      => array('page', 'post', Custom_Posts_Type_Gallery::POST_TYPE), // Page type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				/**
				 * @todo add colore correct text
				 */
				'name'    => 'Post color',
				'desc'    => 'Custom color for post elements',
				'id'      => SHORTNAME . '_post_color',
				'type'    => 'colorpicker',
				'std'     => '',
            ),
		),
	);
	$meta_boxes[] = array(
		'id'         => 'post_background',
		'title'      => 'Background Settings',
		'pages'      => array('page','post', Custom_Posts_Type_Gallery::POST_TYPE), // Page type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Custom background',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_background_settings',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use global', 'value' => 'global', ),
					array( 'name' => 'Use Custom', 'value' => 'custom', ),
					),
				),
			array(
				/**
				 * @todo add colore correct text
				 */
				'name'    => 'Custom background',
				'desc'    => 'Custom background color',
				'id'      => SHORTNAME . '_post_background_color',
				'type'    => 'colorpicker',
				'std'     => '',
            ),
			
			array(
				'name'    => 'Custom background image','liquidfolio',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_background_custom',
				'type'    => 'file',				
			),
			
			array(
				'name'    => 'Custom background repeat',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_background_repeat',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Repat', 'value' => 'repeat', ),
					array( 'name' => 'No repeat', 'value' => 'no-repeat', ),
					array( 'name' => 'Repeat horizontally', 'value' => 'repeat-x', ),
					array( 'name' => 'Repeat vertically', 'value' => 'repeat-y', ),
					),
				),
			array(
				'name'    => 'Custom background attachment',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_background_attachment',
				'type'    => 'select',				
				'options' => array(
					array( 'name' => 'Inherit', 'value' => '', ),
					array( 'name' => 'Fixed', 'value' => 'fixed', ),
					array( 'name' => 'Scroll', 'value' => 'scroll', ),										
					),
				),			
		array(
				'name'    => 'Custom background horizontal position',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_background_x',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Left', 'value' => '0', ),
					array( 'name' => 'Center', 'value' => '50%', ),
					array( 'name' => 'Right', 'value' => '100%', ),					
					),
				),
		array(
				'name'    => 'Custom background vertical position',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_background_y',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Top', 'value' => '0', ),
					array( 'name' => 'Middle', 'value' => '50%', ),
					array( 'name' => 'Bottom', 'value' => '100%', ),					
					),
				),
			),
		);
	
	
	$meta_boxes[] = array(
		'id'         => 'gallery_audio_background',
		'title'      => 'Lightbox Background Settings for Audio post format',
		'pages'      => array(Custom_Posts_Type_Gallery::POST_TYPE), // Page type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Custom background',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_audio_background_settings',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use global', 'value' => 'global', ),
					array( 'name' => 'Use Custom', 'value' => 'custom', ),
					),
				),
			array(
				/**
				 * @todo add colore correct text
				 */
				'name'    => 'Custom background',
				'desc'    => 'Custom background color',
				'id'      => SHORTNAME . '_post_audio_background_color',
				'type'    => 'colorpicker',
				'std'     => '#363636',
            ),
			
			array(
				'name'    => 'Custom background image','liquidfolio',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_audio_background_custom',
				'type'    => 'file',				
			),
			
			array(
				'name'    => 'Custom background repeat',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_audio_background_repeat',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Repat', 'value' => 'repeat', ),
					array( 'name' => 'No repeat', 'value' => 'no-repeat', ),
					array( 'name' => 'Repeat horizontally', 'value' => 'repeat-x', ),
					array( 'name' => 'Repeat vertically', 'value' => 'repeat-y', ),
					),
				),
			array(
				'name'    => 'Custom background attachment',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_audio_background_attachment',
				'type'    => 'select',				
				'options' => array(
					array( 'name' => 'Inherit', 'value' => '', ),
					array( 'name' => 'Fixed', 'value' => 'fixed', ),
					array( 'name' => 'Scroll', 'value' => 'scroll', ),										
					),
				),			
		array(
				'name'    => 'Custom background horizontal position',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_audio_background_x',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Left', 'value' => '0', ),
					array( 'name' => 'Center', 'value' => '50%', ),
					array( 'name' => 'Right', 'value' => '100%', ),					
					),
				),
		array(
				'name'    => 'Custom background vertical position',
				'desc'    => '',
				'id'      => SHORTNAME . '_post_audio_background_y',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Top', 'value' => '0', ),
					array( 'name' => 'Middle', 'value' => '50%', ),
					array( 'name' => 'Bottom', 'value' => '100%', ),					
					),
				),
			),
		);
	
	$meta_boxes[] = array(
		'id'         => 'contact_second',
		'title'      => 'Contact info second content box settings',
		'pages'      => array('page'), // Page type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
				array(					
					'name'    => 'Show second content box',
					'desc'    => '',
					'id'      => SHORTNAME . '_contact_second_show',
					'type'    => 'checkbox',
					'std' => false,
				),
				array(					
					'name'    => 'Custom color',
					'desc'    => '',
					'id'      => SHORTNAME . '_post_color2',
					'type'    => 'colorpicker',
					'std'     => '#A05FEF',
				),
				array(					
					'name'    => 'Box title',
					'desc'    => '',
					'id'      => SHORTNAME . '_contact_second_title',
					'type'    => 'text_medium',
					'std'     => '',
				),
				array(					
						'name'    => 'Box content',
						'desc'    => '',
						'id'      => SHORTNAME . '_contact_second_cont',
						'type'    => 'wysiwyg',
						'std'     => '',
					),
			),
		);
	
	
		$meta_boxes[] = array(
		'id'         => 'contact_location_point',
		'title'      => 'Google map location pin',
		'pages'      => array('page'), // Page type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Location pin image',
				'desc'    => '',
				'id'      => SHORTNAME . '_map_location_settings',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use global', 'value' => 'global', ),
					array( 'name' => 'Use Custom', 'value' => 'custom', ),
					),
				),
			array(
				'name'    => __('Custom Google map location image','liquidfolio'),
				'desc'    => '',
				'id'      => SHORTNAME . '_map_location_custom',
				'type'    => 'file',
				),
			),
		);
		
		
		

	


	// Custom page lightBox
	$meta_boxes[] = array(
		'id'         => 'gallery_template',
		'title'      => 'Gallery Options',
		'pages'      => array(  'page'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __('Select a gallery category','liquidfolio'),
				'desc'    => '',
				'id'      => SHORTNAME . '_gallery_cat',
				'type'    => 'taxonomy_multiselect',
				'taxonomy' => Custom_Posts_Type_Gallery::TAXONOMY,
				'multiple_size' => 6
			),
			array(
				'name'    => __('Disable filters','liquidfolio'),
				'desc'    => '',
				'id'      => SHORTNAME . '_gallery_filters',
				'type'    => 'checkbox',
				'std' => false,
			),
		),
	);

	// Custom page lightBox
	$meta_boxes[] = array(
		'id'         => 'page_lightbox_title_option',
		'title'      => 'Showing Gallery Title Option',
		'pages'      => array('page'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __('Show Gallery Title','liquidfolio'),
				'desc'    => 'Check/Uncheck to show/hide gallery information on mouse in',
				'id'      => SHORTNAME . '_show_title_on_page',
				'type'    => 'checkbox',
				'std'     => false
			),
		),
	);

	// Custom page lightBox
	$meta_boxes[] = array(
		'id'         => 'page_lightbox_type',
		'title'      => 'Type of lightbox for page galleries',
		'pages'      => array('page'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Gallery Lightbox type',
				'desc'    => 'Choose Page Lightbox Type for opening Galleries.',
				'id'      => SHORTNAME . '_page_lightbox_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Fullscreen', 'value' => 'fullscreen', ),
					array( 'name' => 'Small', 'value' => 'small', ),
					array( 'name' => 'Single page', 'value' => 'permalink', ),
				),
			),
			array(
				'name'    => 'Fullsreen lightbox options',
				'desc'    => 'Choose way to display image.',
				'id'      => SHORTNAME . '_page_fullscreen_image_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Fullscreen scale',	'value' => '', ),
					array( 'name' => 'Scale by one side',	'value' => 'scaleByOneSide', ),
					array( 'name' => 'Original Size',		'value' => 'originalSize', ),
				),
			),
		),
	);
	
	
	// Custom page lightBox
	$meta_boxes[] = array(
		'id'         => 'gallery_lightbox_type',
		'title'      => 'Type of lightbox for gallery',
		'pages'      => array(Custom_Posts_Type_Gallery::POST_TYPE),			// Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Showing lightbox settings',
				'desc'    => 'Choose Custom to redefine page setting',
				'id'      => SHORTNAME . '_gallery_lightbox_setting',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use page', 'value' => 'global', ),
					array( 'name' => 'Use Custom', 'value' => 'custom', ),
				),
			),
			array(
				'name'    => 'Gallery Lightbox type',
				'desc'    => 'Choose Lightbox Type for opening Gallery.',
				'id'      => SHORTNAME . '_gallery_lightbox_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Fullscreen', 'value' => 'fullscreen', ),
					array( 'name' => 'Small', 'value' => 'small', ),
					array( 'name' => 'Single page', 'value' => 'permalink', ),
				),
			),
			
			array(
				'name'    => 'Fullsreen lightbox options',
				'desc'    => 'Choose way to display image.',
				'id'      => SHORTNAME . '_gallery_fullscreen_image_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Fullscreen scale',	'value' => '', ),
					array( 'name' => 'Scale by one side',	'value' => 'scaleByOneSide', ),
					array( 'name' => 'Original Size',		'value' => 'originalSize', ),
				),
			),
		),
	);


	// Custom page lightBox
	$meta_boxes[] = array(
		'id'         => 'gallery_lightbox_title_option',
		'title'      => 'Showing Gallery Title Option',
		'pages'      => array(Custom_Posts_Type_Gallery::POST_TYPE),			// Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => 'Showing settings',
				'desc'    => 'Choose Custom to redefine page setting',
				'id'      => SHORTNAME . '_show_gallery_title_type',
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use page', 'value' => 'global', ),
					array( 'name' => 'Use Custom', 'value' => 'custom', ),
				),
			),
			array(
				'name'    => __('Show Gallery Title','liquidfolio'),
				'desc'    => 'Check/Uncheck to show/hide gallery information on mouse in',
				'id'      => SHORTNAME . '_show_gallery_title',
				'type'    => 'checkbox',
				'std'     => false
			),
		),
	);




	$meta_boxes[] = array(
		'id'         => 'page_size_option',
		'title'      => 'Page Size Options',
		'pages'      => array('page'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'name'    => 'Gallery thumbnail size type',
				'desc'    => '('.get_option(SHORTNAME . Custom_Thumbnail_Gallery::GLOBAL_PAGE_WIDTH).' X '.get_option(SHORTNAME . Custom_Thumbnail_Gallery::GLOBAL_PAGE_HEIGHT).')',
				'id'      => SHORTNAME . Custom_Thumbnail_Gallery::META_SIZE_TYPE,
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Use global', 'value' => 'global', ),
					array( 'name' => 'Use Custom', 'value' => 'custom', ),
				),
			),
			array(
				'name' => 'Thumbnail width (px)',
				'desc' => 'This post thumbnail width',
				'id'   => SHORTNAME . Custom_Thumbnail_Gallery::META_PAGE_WIDTH,
				'std'  => 250,
				'type' => 'text_small',
			),
			array(
				'name' => 'Thumbnail height (px)',
				'desc' => 'This post thumbnail height',
				'id'   => SHORTNAME . Custom_Thumbnail_Gallery::META_PAGE_HEIGHT,
				'std'  => 250,
				'type' => 'text_small',
			),
		),
	);



	$meta_boxes[] = array(
		'id'         => 'gallery_size_option',
		'title'      => 'Gallery Size Options',
		'pages'      => array( Custom_Posts_Type_Gallery::POST_TYPE), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
		array(
				'name'    => 'Gallery thumbnail multiplicity',
				'desc'    => 'Choose thumbnail size multiplicity',
				'id'      => SHORTNAME . Custom_Thumbnail_Gallery::MULTIPLICITY,
				'type'    => 'select',
				'options' => array(
					array( 'name' => 'Small (1*1)', 'value' => '1|1', ),
					array( 'name' => 'Vertical (1*2)', 'value' => '1|2', ),
					array( 'name' => 'Horizontal (2*1)', 'value' => '2|1', ),
					array( 'name' => 'Large (2*2)', 'value' => '2|2', ),
				),
			),

//			array(
//				'name'    => 'Gallery thumbnail size type',
//				'desc'    => '('.get_option(SHORTNAME . Custom_Thumbnail_Post::GLOBAL_POST_WIDTH).' X '.get_option(SHORTNAME . Custom_Thumbnail_Post::GLOBAL_POST_HEIGHT).')',
//				'id'      => SHORTNAME . Custom_Thumbnail_Post::META_SIZE_TYPE,
//				'type'    => 'select',
//				'options' => array(
//					array( 'name' => 'Use global', 'value' => 'global', ),
//					array( 'name' => 'Use Custom', 'value' => 'custom', ),
//				),
//			),
//			array(
//				'name' => 'Thumbnail width (px)',
//				'desc' => 'This post thumbnail width',
//				'id'   => SHORTNAME . Custom_Thumbnail_Post::META_POST_WIDTH,
//				'std'  => 250,
//				'type' => 'text_small',
//			),
//			array(
//				'name' => 'Thumbnail height (px)',
//				'desc' => 'This post thumbnail height',
//				'id'   => SHORTNAME . Custom_Thumbnail_Post::META_POST_HEIGHT,
//				'std'  => 250,
//				'type' => 'text_small',
//			),
		),
	);

	$meta_boxes[] = array(
		'id'         => 'gallery_lightbox_settings',
		'title'      => 'Gallery Ligtbox Options',
		'pages'      => array( Custom_Posts_Type_Gallery::POST_TYPE), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name'    => __('Visit Website URL','liquidfolio'),
				'desc'    => 'Visit Website URL in lightbox',
				'id'      => SHORTNAME . '_show_link',
				'type'    => 'text',
				'std' => false,
			),			
			array(
				'name'    => __('Visit Website text','liquidfolio'),
				'desc'    => 'Visit Website text in lightbox',
				'id'      => SHORTNAME . '_show_link_text',
				'type'    => 'text',
				'std' => __('Visit Website','liquidfolio'),
			),
			array(
				'name'    => __('Visit Website target','liquidfolio'),
				'desc'    => 'Open in new window',
				'id'      => SHORTNAME . '_show_link_target',
				'type'    => 'checkbox',
				'std' => false,
			),
			array(
				'name'    => __('Twitter','liquidfolio'),
				'desc'    => 'Show Twitter button on gallery lightbox',
				'id'      => SHORTNAME . '_show_twitter',
				'type'    => 'checkbox',
				'std' => false,
			),			
			array(
				'name'    => __('Google Plus','liquidfolio'),
				'desc'    => 'Show Google Plus button on gallery lightbox',
				'id'      => SHORTNAME . '_show_google_plus',
				'type'    => 'checkbox',
				'std' => false,
			),
			array(
				'name'    => __('Pinterest','liquidfolio'),
				'desc'    => 'Show Pinterest button on gallery lightbox',
				'id'      => SHORTNAME . '_show_pinterest',
				'type'    => 'checkbox',
				'std' => false,
			),
			array(
				'name'    => __('Facebook','liquidfolio'),
				'desc'    => 'Show Facebook button on gallery lightbox',
				'id'      => SHORTNAME . '_show_facebook',
				'type'    => 'checkbox',
				'std' => false,
			),

		),
	);
	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}
/**
 * Metaboxes script
 */
function metaboxes_script() {
    if ( is_admin() ) {
		
        $script = <<< EOF
<script type='text/javascript'>
  
</script>
EOF;
        echo $script;
		
    }
}
add_action('admin_footer', 'metaboxes_script');
?>