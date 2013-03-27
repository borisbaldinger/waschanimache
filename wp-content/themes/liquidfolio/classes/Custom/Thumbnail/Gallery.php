<?php

class Custom_Thumbnail_Gallery extends Custom_Thumbnail_Post
{
	/**
	 * Page width
	 * @var int 
	 */
	private $page_width;
	
	/**
	 * Page height
	 * @var int
	 */
	private $page_height;
	
	private $gallery_page_id;
	
	/**
	 * gallery multiplicity meta key suffix
	 */
	const MULTIPLICITY = '_multiplicity';
	
	const META_PAGE_WIDTH = '_page_width';
	const META_PAGE_HEIGHT  = '_page_height';
	
	const GLOBAL_PAGE_WIDTH		= '_global_page_width';
	const GLOBAL_PAGE_HEIGHT	= '_global_page_height';
	
	static function getInstance()
	{
		if (is_null(self::$instance))
		{
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	
	/**
	 * 
	 * @param type $id Gallery custom post type ID
	 * @param type $page_w Gallery Page width
	 * @param type $page_h Gallery Page height
	 * @param type $gallery_page_id Gallery Page ID 
	 */
	public function getThumbnail($id, $page_w, $page_h, $gallery_page_id = '')
	{
		$this->setPageWidth($page_w);
		$this->setPageHeight($page_h);
		$this->setGalleryPageId($gallery_page_id);
		
		parent::getThumbnail($id);
	}
	
	
	protected function getClearedHTML($id, $size_name)
	{
		$html = get_the_post_thumbnail($id, $size_name);
		$prefix = Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX;
		
		/**
		 * @todo add correct class name
		 */

		if(preg_match("/^{$prefix}/", $size_name))
		{
			$html = $this->addClass($html, 'custom_black_white_thumbnail');
		}
		else
		{
			$html = $this->addClass($html, 'custom_colored_thumbnail');
		}
		
		$this->removeSizeValues($html);
		
		return $html;
	}
	
	/**
	 * Removind default image element width and height values
	 * @param string $html
	 * @return string updated IMG HTML element
	 */
	private function removeSizeValues(&$html)
	{
		$html = preg_replace(array('/\swidth="\d+"/', '/\sheight="\d+"/'), '', $html);
	}
	
	/**
	 * Adding class to img html element
	 * @param string $img_html image html element
	 * @param string $class class name to add
	 * @return string
	 */
	private function addClass($img_html, $class)
	{
		if(class_exists('DOMDocument') && $img_html != '')
		{
			$dom = new DOMDocument();
			$dom->loadHTML( $img_html );

			$images = $dom->getElementsByTagName('img');

			foreach ($images as $image) {
				// the existing classes already on the images
				$existing_classes = $image->getAttribute('class');

				// the existing classes plus the new class
				$class_names_to_add = $existing_classes . ' ' . $class;

				// Adding updated class list
				$image->setAttribute('class', $class_names_to_add);
			}
			// Removing not needed elements after saveHTML
			$img_html = preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $dom->saveHTML());
		}
		return $img_html;
	}
	
	protected function getSizeNameForPost()
	{
			return "multiplicity-gallery-{$this->getPostID()}-{$this->getGalleryPageId()}";
	}
	
	/**
	 * Select gallery multiplicity and page size and return multiplied values
	 * @return array ex: array('width'=>'250', 'height'=>'250')
	 */
	protected function getPostThumbnaiSize()
	{
		// 1|1 1|2 2|1 2|2
		$multiplicity = get_post_meta($this->getPostID(), SHORTNAME . self::MULTIPLICITY, true);
		
		if(!$multiplicity)
		{
			$multiplicity = '1|1';
		}
		
		list($width_multiplicity, $height_multiplicity) = explode('|', $multiplicity);

		return array(
			self::WIDTH		=> $this->getPageWidth() * $width_multiplicity * 2,
			self::HEIGHT	=> $this->getPageHeight() * $height_multiplicity * 2,
		);
	}
	
	/**
	 * Set page width
	 * @param int $page_w page width
	 */
	private function setPageWidth($page_w)
	{
		$this->page_width = (int) $page_w;
	}

	/**
	 * Set page height
	 * @param int $page_h page height
	 */
	private function setPageHeight($page_h)
	{
		$this->page_height = (int) $page_h;
	}
	
	/**
	 * Get page width
	 * @param int page width
	 */	
	private function getPageWidth()
	{
		return $this->page_width;
	}
	
	/**
	 * Get page height
	 * @param intpage height
	 */
	private function getPageHeight()
	{
		return $this->page_height;
	}
	
		/**
	 * Create HTML with two images if it able
	 * @param int $post_id ID of post owns thubnails
	 * @param string $size_name image size to show
	 * @return string - html
	 */
	protected function getEffectedHTML($post_id, $size_name)
	{
		if($this->isGDActive())
		{
			if($this->isAbleToCreate())
			{
				$html = 			
						$this->getClearedHTML($post_id, $size_name).
						$this->getClearedHTML($post_id, Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX . $size_name);
				
			}
			else
			{
				$html = $this->getClearedHTML($post_id, 'full').
						$this->getClearedHTML($post_id, $this->getDefaultEffectedSizeName());
			}
		}
		else
		{
			$html = $this->getClearedHTML($post_id, $size_name);
		}
		return $html;		
		
	}
	
	private function setGalleryPageId($galleryID)
	{
		$this->gallery_page_id = (int) $galleryID;
	}
	
	private function getGalleryPageId()
	{
		return $this->gallery_page_id;
	}
}
?>