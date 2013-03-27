<?php

class Import_Theme_Meta implements Import_Theme_Item
{
	
	private $meta_images = array();
	
	public function __construct()
	{
		$this->setMetaImages();
	}

	public function import()
	{
		$this->postTypeGallerySetNewImages();
	}
	
	private function postTypeGallerySetNewImages() {
		//set default image for all posts
		$args = array(
			"post_type" => array('post'),
			"posts_per_page" => "-1",
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array('post-format-gallery')
				)
			)
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			update_post_meta(get_the_ID(), SHORTNAME . '_project_slider', $this->getShuffledImages());
		endwhile;
	}
	
	private function getShuffledImages()
	{
		array_shift($this->meta_images);
		return $this->meta_images;
	}
	
	private function setMetaImages()
	{
		$path = get_template_directory_uri() . "/backend/dummy/images/";
		
		$this->meta_images	= array(
									array('slide-img-src' => $path . '0DBCE9.png'),
									array('slide-img-src' => $path . 'A05FEF.png'),
									array('slide-img-src' => $path . 'A273DD.png'),
									array('slide-img-src' => $path . 'AEBB09.png'),
									array('slide-img-src' => $path . 'FE664E.png'),
								);
	}
}