<?php
class Gallery
{
	private $gallery_id;
	private $gallery_page_id;
	private $post;

	function __construct($id,$gallery_page_id=0)
	{
		$this->setId($id);
		$this->setPageId($gallery_page_id);
		$this->setPostData();
	}

	public function getTitle()
	{
		return $this->getPost()->post_title;
	}

	public function getContent()
	{
		return qd_the_content($this->getPost()->post_content);
	}

	public function getDate()
	{
		$date =  $this->getPost()->post_date;
		return date_i18n(get_option('date_format'), strtotime($date));
	}

	public function displayPageLink()
	{
		return (boolean) get_post_meta($this->getID(), SHORTNAME . '_show_link', true);
	}


	public function getColor()
	{
		$gallery_color = get_post_meta($this->getID(), SHORTNAME . '_post_color', true);
		if($gallery_color && $gallery_color !='#')
		{
			return $gallery_color;
		}
		
		$format = get_post_format($this->getID());

		switch ($format):
			case 'image':
				return get_option(SHORTNAME."_gallery_image_color");
				break;
			case 'gallery':
				return get_option(SHORTNAME."_gallery_slideshow_color");
				break;
			case 'video':
				return get_option(SHORTNAME."_gallery_video_color");
				break;
			case 'audio':
				return get_option(SHORTNAME."_gallery_audio_color");
				break;
		endswitch;
		
		
	}

	public function getFormat()
	{
		return get_post_meta($this->getID(), 'post_format', true);
	}

	public function getLinkURL()
	{
		return get_post_meta($this->getID(), SHORTNAME . '_show_link', true);
	}
	public function getLinkTarget()
	{
		if (get_post_meta($this->getID(), SHORTNAME . '_show_link_target', true)) {
		return "target='_blank'" ;
		}
	}
	public function getLinkText()
	{
		return get_post_meta($this->getID(), SHORTNAME . '_show_link_text', true);
	}

	public function getGalleryCategories()
	{
		return get_the_term_list($this->getID(), Custom_Posts_Type_Gallery::TAXONOMY,'',' / ','');;
	}

	public function getThumbnail()
	{
		return  wp_get_attachment_url( get_post_thumbnail_id($this->getID()));
	}

	public function getGalleryImages()
	{
		$images = array();
		$gallery_images = get_post_meta($this->getID(), SHORTNAME . '_project_slider', true);

		if($gallery_images && is_array($gallery_images) && count($gallery_images))
		{
			foreach ($gallery_images as $img)
			{
				$images[] = '<img src="'.array_shift($img).'" />';
			}
			return $images;
		}
		return array(get_the_post_thumbnail($this->getID(), 'full'));
	}

	public function getFancyBoxImages()
	{
		$images = array();
		$gallery_images = get_post_meta($this->getID(), SHORTNAME . '_project_slider', true);
		
		$color = get_post_meta($this->getID(), SHORTNAME . '_post_color', true);
		if ( get_post_format($this->getID()) ) {
			$post_format = get_post_format($this->getID());
		} else {
			$post_format = '';
		}
		if(!($color && $color !='#'))
		{
			$color = get_option(SHORTNAME.'_gallery_'.$post_format.'_color');
		}
		
		
		if($gallery_images && is_array($gallery_images) && count($gallery_images))
		{
			foreach ($gallery_images as $img)
			{

				$images[] = '<a class="fancybox" href="'.array_shift($img).'" data-fancybox-group="gallery" title="'.$this->getTitle().'" data-script="fancybox"></a>';
			}
			return $images;
		}

		return array('<a class="fancybox" href="'.wp_get_attachment_url( get_post_thumbnail_id($this->getID()) ).'" data-fancybox-group="gallery" data-fancybox-color="'.$color.'" title="'.$this->getTitle().'" data-script="fancybox"></a>');
	}


	public function getGalleryImagesSrc()
	{
		$images = array();
		$gallery_images = get_post_meta($this->getID(), SHORTNAME . '_project_slider', true);
		if($gallery_images && is_array($gallery_images) && count($gallery_images))
		{
			foreach ($gallery_images as $img)
			{
				$images[] = array_shift($img);
			}
			return $images;
		}

		return array(wp_get_attachment_url( get_post_thumbnail_id($this->getID())));
	}
	
	public function getGalleryFullscreenOptionName()
	{
		if(get_post_meta($this->getID(), SHORTNAME . '_gallery_lightbox_setting', true) == 'custom')
		{
			// Gallery post value
			$optionName = get_post_meta($this->getID(), SHORTNAME . '_gallery_fullscreen_image_type', true);
		}
		else
		{
			// Page with gallery value
			$optionName = get_post_meta($this->getPageID(), SHORTNAME . '_page_fullscreen_image_type', true);
		}
		
		return $optionName;
	}

	public function displayFacebook()
	{
		return (boolean) get_post_meta($this->getID(), SHORTNAME . '_show_facebook', true);
	}

	public function displayTwitter()
	{
		return (boolean) get_post_meta($this->getID(), SHORTNAME . '_show_twitter', true);
	}

	public function displayGoogle()
	{
		return (boolean) get_post_meta($this->getID(), SHORTNAME . '_show_google_plus', true);
	}

	public function displayPinterest()
	{
		return (boolean) get_post_meta($this->getID(), SHORTNAME . '_show_pinterest', true);
	}

	private function getID()
	{
		return $this->gallery_id;
	}

	private function setId($id)
	{
		$this->gallery_id = (int) $id;
	}
	
	private function getPageID()
	{
		return $this->gallery_page_id;
	}

	private function setPageId($gallery_page_id)
	{
		$this->gallery_page_id = (int) $gallery_page_id;
	}

	private function setPostData()
	{
		$this->post = get_post($this->getID());
	}

	private function getPost()
	{
		return $this->post;
	}
}
?>