<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Format
 *
 * @author Andrey
 */
class Import_Theme_Format implements Import_Theme_Item
{
	
	/**
	 * formats - slug
	 * @var type 
	 */
	private $audio_format	= array('lightbox',
									'gallery-post-with-audio');
	private $gallery_format	= array('gallery-post-20',
									'woman-on-the-beach',
									'gallery-post-04',
									'gallery-post-22',
									'gallery-post-15',
									'gallery-post-19',
									'gangster',
									'gallery-post-with-slideshow',
									'gallery-post-08');
	private $video_format	= array('dinner',
									'custom-colors');
	private $image_format	= array();
	
	
	public function import()
	{
		$this->setGalleryPostFormat();
	}
	
	private function setGalleryPostFormat()
	{
		//set default image for slides posts
		$args = array(
			"post_type"			=> array(Custom_Posts_Type_Gallery::POST_TYPE),
			"posts_per_page"	=> "-1"
		);

		$all_gallery_query = new WP_Query($args);

		while ($all_gallery_query->have_posts()) :
			$all_gallery_query->the_post();
			global $post;
			
			if($this->isAudioFormat($post->post_name))
			{
				$format = 'audio';
			}
			elseif($this->isGalleryFormat($post->post_name))
			{
				$format = 'gallery';
			}
			elseif($this->isVideoFormat($post->post_name))
			{
				$format = 'video';
			}
			else // image
			{
				$format = 'image';
			}
			
			set_post_format(get_the_ID(), $format );
			
		endwhile;
	}
	
	private function isAudioFormat($slug)
	{
		return in_array($slug, $this->audio_format);
	}
	
	private function isGalleryFormat($slug)
	{
		return in_array($slug, $this->gallery_format);
	}
	
	private function isVideoFormat($slug)
	{
		return in_array($slug, $this->video_format);
	}
}

?>
