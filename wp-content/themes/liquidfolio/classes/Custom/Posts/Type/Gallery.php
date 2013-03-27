<?php

// Custom_Posts_Type_Gallery
class Custom_Posts_Type_Gallery extends Custom_Posts_Type_Default
{
	const POST_TYPE = 'qd_galleries';
	const TAXONOMY = 'qd_galleries_cat';
	
	protected $post_slug_option	= '_slug_gallery';
	protected $tax_slug_option	= '_slug_gallery_cat';
	// galleries
	// gallery
	protected $post_type_name	= self::POST_TYPE;
	
	protected $taxonomy_name = self::TAXONOMY;

	const DEFAULT_TAX_SLUG = 'qd_gallery_cat';
	
	const DEFAULT_POST_SLUG = 'qd_gallery';
	
	
	
	function __construct()
	{
		$this->setDefaultPostSlug(self::DEFAULT_POST_SLUG);
		$this->setDefaultTaxSlug(self::DEFAULT_TAX_SLUG);
		parent::__construct();
	}
	
	protected function init()
	{
		register_post_type($this->getPostTypeName(), array(
					'labels'				=> $this->getPostLabeles(),
					'public'				=> true,
					'show_ui'				=> true,
					'_builtin'				=> false,
					'capability_type'		=> 'post',
					'_edit_link'			=> 'post.php?post=%d',
					'rewrite'				=> array("slug" =>  $this->getPostSlug()), 
					'hierarchical'			=> false,
					'menu_icon'				=> get_template_directory_uri() . '/backend/img/i_galleries.png',
					'query_var'				=> true,
					'publicly_queryable'	=> true,
					'exclude_from_search'	=> false,
					'supports'				=> array('title', 'editor', 'thumbnail', 'excerpt', 'comments')
		));
		add_post_type_support( $this->getPostTypeName(), 'post-formats', array( 'gallery', 'audio','video' ) );

		register_taxonomy($this->getTaxonomyName(),$this->getPostTypeName(),
					array(
					'hierarchical'			=> true,
					'labels'				=> $this->getTaxLabels(),
					'show_ui'				=> true,
					'query_var'				=> true,
					'rewrite'				=> array('slug' => $this->getTaxSlug()),
		));
	}
	////////////////////////////////////////////
						public function run()
						{
							add_filter("manage_edit-{$this->getPostTypeName()}_columns", array(&$this, "qd_post_type_columns"));
							add_filter('wp_insert_post_data', array($this, 'default_comments_off'));
							add_action("manage_posts_custom_column", array(&$this, "qd_post_type_custom_columns"));
							add_action('restrict_manage_posts', array(&$this, 'qd_post_type_restrict_manage_posts'));							
							add_action('request', array(&$this, 'thgalleries_request'));
							add_action('init', array(&$this, "thGalleriesInit"));
							$this->addCustomMetaBox( new Custom_MetaBox_Item_Gallery($this->getTaxonomyName()) );

						}

						function thGalleriesInit()
						{
							global $thgalleries;
							$thgalleries = $this;
						}

						function thgalleries_request($request)
						{
							if (is_admin()
									&& $GLOBALS['PHP_SELF'] == '/wp-admin/edit.php'
									&& isset($request['post_type'])
									&& $request['post_type'] == $this->getPostTypeName())
							{
								$qd_portoflios_cat = (isset($request[$this->getTaxonomyName()]) ? $request[$this->getTaxonomyName()] : NULL);
								$term = get_term($qd_portoflios_cat, $this->getTaxonomyName());
								$request['term'] = isset($term->slug);
							}
							return $request;
						}

						function qd_post_type_restrict_manage_posts()
						{
							global $typenow;

							if ($typenow == $this->getPostTypeName())
							{


								$filters = array($this->getTaxonomyName());

								foreach ($filters as $tax_slug)
								{
									// retrieve the taxonomy object
									$tax_obj = get_taxonomy($tax_slug);
									$tax_name = $tax_obj->labels->name;
									// retrieve array of term objects per taxonomy
									$terms = get_terms($tax_slug);

									// output html for taxonomy dropdown filter
									echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
									echo "<option value=''>Show All $tax_name</option>";
									$qd_slider_tax_slug = (isset($_GET[$tax_slug]) ? $_GET[$tax_slug] : NULL);
									foreach ($terms as $term)
									{
										// output each select option line, check against the last $_GET to show the current option selected
										echo '<option value=' . $term->slug, $qd_slider_tax_slug == $term->slug ? ' selected="selected"' : '', '>' . $term->name . ' (' . $term->count . ')</option>';
									}
									echo "</select>";
								}
							}
						}
						
	
	
	////////////////////////////////////////////
	//
	function qd_post_type_columns($columns)
	{
		$columns = array(
			"cb" => "<input type=\"checkbox\" />",
			"title" => __("Gallery Item Title", 'liquidfolio'),
			"thgalleries_preview" => __("Image preview", 'liquidfolio'),
			"thgalleries_categories" => __("Assign to Galleries Category(s)", 'liquidfolio')
		);

		return $columns;
	}

	function qd_post_type_custom_columns($column)
	{
		global $post;
		switch ($column)
		{
			case "thgalleries_preview":
				?>
				<?php if (has_post_thumbnail()) : ?>
					<a href="post.php?post=<?php echo $post->ID ?>&action=edit"><?php get_theme_post_thumbnail($post->ID, 'recent_posts'); ?></a>
					<?php
				endif;
				break;

			case "thgalleries_categories":
				$kgcs = get_the_terms(0, $this->getTaxonomyName());
//				$kgcs = get_the_terms(0, $this->getTaxonomyName());
				if (!empty($kgcs))
				{
					$kgcs_html = array();
					foreach ($kgcs as $kgc)
						array_push($kgcs_html, $kgc->name);

					echo implode($kgcs_html, ", ");
				}
				break;
		}
	}

	protected function getPostLabeles()
	{
		$labels = array(
			'name'				=> _x('Galleries', 'post type general name', 'liquidfolio'),
			'all_items'			=> _x('Gallery Posts', 'post type general name', 'liquidfolio'),
			'singular_name'		=> _x('Gallery', 'post type singular name', 'liquidfolio'),
			'add_new'			=> _x('Add New', 'item', 'liquidfolio'),
			'add_new_item'		=> __('Add New Item', 'liquidfolio'),
			'edit_item'			=> __('Edit Item', 'liquidfolio'),
			'new_item'			=> __('New Item', 'liquidfolio'),
			'view_item'			=> __('View Item', 'liquidfolio'),
			'search_items'		=> __('Search Items', 'liquidfolio'),
			'not_found'			=> __('No items found', 'liquidfolio'),
			'not_found_in_trash' => __('No items found in Trash', 'liquidfolio'),
			'parent_item_colon'	=> ''
		);
		
		return $labels;
	}

	protected function getTaxLabels()
	{
		$labels = array(
			'name'					=> _x('Gallery Categories', 'taxonomy general name', 'liquidfolio'),
			'singular_name'			=> _x('Gallery Category', 'taxonomy singular name', 'liquidfolio'),
			'search_items'			=> __('Search Galleries Categories', 'liquidfolio'),
			'popular_items'			=> __('Popular Galleries Categories', 'liquidfolio'),
			'all_items'				=> __('All Galleries Categories', 'liquidfolio'),
			'parent_item'			=> null,
			'parent_item_colon'		=> null,
			'edit_item'				=> __('Edit Galleries Category', 'liquidfolio'),
			'update_item'			=> __('Update Galleries Category', 'liquidfolio'),
			'add_new_item'			=> __('Add New Galleries Category', 'liquidfolio'),
			'new_item_name'			=> __('New Galleries Category Name', 'liquidfolio'),
			'add_or_remove_items'	=> __('Add or remove Galleries Categories', 'liquidfolio'),
			'choose_from_most_used' => __('Choose from the most used Galleries Categories', 'liquidfolio'),
			'separate_items_with_commas' => __('Separate Galleries Categories with commas', 'liquidfolio'),
		);
		return $labels;
	}
}

// Replace the standard meta box callback with our own
	add_action( 'add_meta_boxes', 'gal_add_meta_boxes' );
	function gal_add_meta_boxes(  )
	{
		if ( ! get_post_type_object( 'qd_galleries' ) ) {
			// It's a comment or a link, or something else
			return;
		}
		remove_meta_box( 'formatdiv', 'qd_galleries', 'side' );
		add_meta_box( 'gal_formatdiv', _x( 'Format','post format','liquidfolio' ), 'gal_post_format_meta_box', 'qd_galleries', 'side', 'core' );
	}

	// This is almost a duplicate of the original meta box
	function gal_post_format_meta_box( $post, $box ) {
		if ( current_theme_supports( 'post-formats' ) && post_type_supports( $post->post_type, 'post-formats' ) ) :
		$post_formats = get_theme_support( 'post-formats' );

		// This is our extra code
		// If the post type has registered post formats, use those instead
		if ( is_array( $GLOBALS['_wp_post_type_features'][$post->post_type]['post-formats'] ) ) {
			$post_formats = $GLOBALS['_wp_post_type_features'][$post->post_type]['post-formats'];
		}

		if ( is_array( $post_formats[0] ) ) :
			$post_format = get_post_format( $post->ID );
			if ( !$post_format )
				$post_format = '0';
			$post_format_display = get_post_format_string( $post_format );
			// Add in the current one if it isn't there yet, in case the current theme doesn't support it
			if ( $post_format && !in_array( $post_format, $post_formats[0] ) )
				$post_formats[0][] = $post_format;
		?>
		<div id="post-formats-select">
			<input type="radio" name="post_format" class="post-format" id="post-format-image" value="image" <?php checked( $post_format, '0' ); ?> /> <label for="post-format-image"><?php _e('Image','liquidfolio'); ?></label>
			<?php foreach ( $post_formats[0] as $format ) : ?>
			<br /><input type="radio" name="post_format" class="post-format" id="post-format-<?php echo esc_attr( $format ); ?>" value="<?php echo esc_attr( $format ); ?>" <?php checked( $post_format, $format ); ?> /> <label for="post-format-<?php echo esc_attr( $format ); ?>"><?php echo esc_html( get_post_format_string( $format ) ); ?></label>
			<?php endforeach; ?><br />
		</div>
		<?php endif; endif;
	}					
?>
