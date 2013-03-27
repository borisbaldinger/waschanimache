<?php
/**
 * Create croped image if able and black\white images to
 */
class Custom_Thumbnail_Post extends Custom_Thumbnail
{
	
	/**
	 * Meta box data names
	 */
	const META_SIZE_TYPE		= '_post_size_type';
	const META_POST_WIDTH		= '_post_width';
	const META_POST_HEIGHT		= '_post_height';
	
	/**
	 * Admin theme post size settings
	 */
	const GLOBAL_POST_WIDTH		= '_global_post_width';
	const GLOBAL_POST_HEIGHT	= '_global_post_height';
	
	/**
	 * Width & height default values in px;
	 */
	const DEFAULT_WIDTH = 250;
	const DEFAULT_HEIGHT = 250;
	
	
	
	/**
	 * ID of Current Post
	 * @var int
	 */
	protected $post_id;
	
	/**
	 * flag does effected image create
	 * @var boolean
	 */
	protected $able_to_create = true;


	static protected $instance = NULL;
	
	function __construct()
	{
		;
	}
	
	
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
	 * Check is able to create croped images and black-white images with similar size
	 * if unable create images whith given parameters
	 * then create black'white from default thumbnail size
	 * 
	 * new meta data saved to meta '_wp_attachment_metadata'
	 * @param int $id ID of post
	 * @return boolean
	 */
	public function getThumbnail($id = null)
	{
		$post_id = is_null($id)?get_the_ID():$id;
		$thum_id = get_post_thumbnail_id($post_id);
		if ($post_id && $thum_id)
		{
			$this->setPostID($id);
			
			$size_name = $this->getSizeNameForPost();
		
			if (!is_array($attachment_meta = wp_get_attachment_metadata($thum_id)) && !empty($attachment_meta))
				return false;
			
			$this->setCurrentAttachmentMeta($attachment_meta);
			
			if ($this->isAbsentThumbnailSize($size_name)  || $this->isSizeChanged($size_name))
			{
				
				/**
				 * if size not changed and default black_thumb exist no need to recreate it again
				 */
				if(!$this->isSizeChanged($size_name) && $this->isDefaultEffectedThumbnailExist())
				{
					$this->setUnableToCreate();
					echo $this->getEffectedHTML($post_id, $size_name);
					return;
				}
				
				require_once ABSPATH . 'wp-admin/includes/media.php';
				require_once ABSPATH . 'wp-admin/includes/image.php';
				
				if ( is_array($theme_size = $this->getPostThumbnaiSize()) )
				{
					// add to global vars
					if($this->addToWPImageSizes($size_name, $theme_size))
					{
						if($file_path = $this->getOriginThumbnailFilePath())
						{
							if($this->isSizeChanged($size_name) /*&& $this->needRemoveOld($size_name)*/)
							{
								$this->removeOldImage($size_name);
							}
							
							/**
							 * generate attachment data and add part of it to old meta
							 */
							$new_meta_date = wp_generate_attachment_metadata($thum_id, $file_path);

							/**
							 * Add to old meta new 'sizes'
							 */
							$old_meta = $this->getCurrentAttachmentMeta();
							
							/**
							 * new images was created successfully
							 */
							if(isset($new_meta_date['sizes'][$size_name]))
							{
								$theme_size_meta = $new_meta_date['sizes'][$size_name];
								
								if(isset($old_meta['sizes']))
								{
									$old_meta['sizes'][$size_name] = $theme_size_meta;
									
									$this->unsetDefaultSizeName($old_meta);
										
									if($this->isGDActive())
									{
										if($effected = $this->addThumbnailWithEffect($theme_size_meta, $old_meta['file']))
										{
											$old_meta['sizes'][Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX . $size_name] = $effected;
										}
									}
									wp_update_attachment_metadata($thum_id, $old_meta);
								}
							}
							/*
							 * New images wasn't created
							 */
							else
							{
								$this->setUnableToCreate();
								if($this->isGDActive())
								{
									/**
									 * creating effected thumbnail using 'full'(original size) image
									 */
									if($default_thumbnail_with_effect = $this->createDefaultImageWithEffect($thum_id))
									{
										/**
										 * removing OLD SIZE IF EXIST
										 */
										$this->unsetOldSizeName($old_meta);
										
										/**
										 * addming new meta data to old meta array
										 */
										$old_meta['sizes'][$this->getDefaultEffectedSizeName()] = $default_thumbnail_with_effect;
										wp_update_attachment_metadata($thum_id, $old_meta);
									}
								}
								// save as it was
							}
						}
						$this->removeFromWPImagesSize($size_name);
					}
				}
			}
			echo $this->getEffectedHTML($post_id, $size_name);
		}
		
//		echo $this->getClearedHTML($post_id, $size_name);
	}
	
	/**
	 * create images by default thumbnail image and save it
	 * @param int $thum_id ID of thumbnail
	 */
	protected function createDefaultImageWithEffect($thum_id)
	{
		 $meta = wp_get_attachment_metadata($thum_id);
		 if(isset($meta['file']))
		 {
			 preg_match('/^\d{4}\/\d{2}/', $meta['file'], $matches);
			 
			 if($matches && isset($matches[0]))
			 {
				 
				$upload = wp_upload_dir($matches[0]);
				
				if($upload && $upload['error'] === false)
				{
					$thumbnail_path = $upload['basedir'] . DIRECTORY_SEPARATOR . $meta['file'];
					
					if(file_exists($thumbnail_path))
					{
						$thumbnail_width = $meta[self::WIDTH];
						$thumbnail_height = $meta[self::HEIGHT];
						
						$effected = Custom_Thumbnail_Effect_BlackWhite::getInstance()
										->setSRC($thumbnail_path)
										->setWidth($thumbnail_width)
										->setHeight($thumbnail_height)
										->run();
						
						if($effected)
						{
							return array(
										'file'			=> Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX . basename($meta['file']),
										self::WIDTH		=> $meta[self::WIDTH],
										self::HEIGHT	=> $meta[self::HEIGHT],
									);
						}
					}
				}
			 }
		 }
		 return false;
	}
	
	/**
	 * Remove old image croped and black\white
	 * @param string $size_name size name of images thet need to delete
	 */
	protected function removeOldImage($size_name)
	{
		if($path = $this->getResizedThumbnailFilePath($size_name))
		{
			$info = pathinfo($path);
			$dirname =  $info['dirname'];
				
			if(file_exists($path) && is_writeable($path) && is_writeable($dirname))
			{
				unlink($path);
			}
		}
		// effected 
		if($path = $this->getResizedThumbnailFilePath(Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX . $size_name))
		{
			$info = pathinfo($path);
			$dirname =  $info['dirname'];
				
			if(file_exists($path) && is_writeable($path) && is_writeable($dirname))
			{
				@unlink($path);
			}
		}
		// effected default full image
		if($path = $this->getResizedThumbnailFilePath($this->getDefaultEffectedSizeName()))
		{
			$info = pathinfo($path);
			$dirname =  $info['dirname'];
				
			if(file_exists($path) && is_writeable($path) && is_writeable($dirname))
			{
				unlink($path);
			}
		}
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
				$html = <<<HTML
					<div class="gallery_thumbnail" data-id="{$this->getPostID()}">
						{$this->getClearedHTML($post_id, $size_name)}
						{$this->getClearedHTML($post_id, Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX . $size_name)}
					</div>
HTML;
			}
			else
			{
				$html = <<<HTML
					<div class="gallery_thumbnail" data-id="{$this->getPostID()}">
						{$this->getClearedHTML($post_id, 'full')}
						{$this->getClearedHTML($post_id, $this->getDefaultEffectedSizeName())}
					</div>
HTML;
			}
		}
		else
		{
			$html = $this->getClearedHTML($post_id, $size_name);
		}
		return $html;		
		
	}
	
	/**
	 * create black\white image 
	 * @param array $meta array of parameters of original image
	 * @param string $orig_file original file, for getting it dir.
	 * @return mixed array if success? false if fail
	 */
	protected function addThumbnailWithEffect($meta, $orig_file = '')
	{
		$upload_dir			= wp_upload_dir();
		$orig_file_pathinfo = pathinfo($orig_file);
		
		if($orig_file_pathinfo && isset($upload_dir['basedir']) && $meta['file'])
		{
			/*
			 * Getting path to original file, for update oldmeta data array
			 */
//			$upload_path = $upload_dir['path'];
			$upload_path		= $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $orig_file_pathinfo['dirname'] ;
			$new_thumbanil_path = $upload_path . DIRECTORY_SEPARATOR . $meta['file'];
			
			$effected = Custom_Thumbnail_Effect_BlackWhite::getInstance()
						->setSRC($new_thumbanil_path)
						->setWidth($meta[self::WIDTH])
						->setHeight($meta[self::HEIGHT])
						->run();
			if($effected)
			{
				return array(
							'file'			=> Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX.$meta['file'],
							self::WIDTH		=> $meta[self::WIDTH],
							self::HEIGHT	=> $meta[self::HEIGHT],
						);
			}
		}
		return false;
	}
	
	/**
	 * Generate size name for thumbnail based on post id width & height
	 * @param array $size
	 * @return string
	 */
	protected function getSizeNameForPost()
	{
			return "gallery-{$this->getPostID()}";
	}
	
	/**
	 * Select from custom or meta thumbnails size and return its value
	 * @return array array('width'=>'250', 'height'=>'250')
	 */
	protected function getPostThumbnaiSize()
	{
		
		if($this->isCustomSizeUsing())
		{
			$width	= (int) get_post_meta($this->getPostID(), SHORTNAME . self::META_POST_WIDTH, true);
			$height	= (int) get_post_meta($this->getPostID(), SHORTNAME . self::META_POST_HEIGHT, true);
		}
		else
		{
			$width	= (int) get_option(SHORTNAME . self::GLOBAL_POST_WIDTH);
			$height	= (int) get_option(SHORTNAME . self::GLOBAL_POST_HEIGHT);
		}
		
		if(!$width || $width < 0 )
		{
			$width	= self::DEFAULT_WIDTH;
		}
		
		if(!$height || $height < 0)
		{
			$height	= self::DEFAULT_HEIGHT;
		}
		
		return array(
			self::WIDTH		=> $width,
			self::HEIGHT	=> $height,
				);
	}
	
		/**
	 * Compare current meta image size with old meta data
	 * @param string $size_name
	 * @return boolean 
	 */
	protected function isSizeChanged($size_name)
	{
		$current_attachment_meta = $this->getCurrentAttachmentMeta();
		if(is_array($current_attachment_meta) && isset($current_attachment_meta['sizes'])	)
		{
			/**
			 * if post size exist
			 */
			if(key_exists($size_name, $current_attachment_meta['sizes']))
			{
				$size_meta = $current_attachment_meta['sizes'][$size_name];
				if($theme_size = $this->getPostThumbnaiSize())
				{
					if($theme_size[self::WIDTH] != $size_meta[self::WIDTH] 
						|| $theme_size[self::HEIGHT] != $size_meta[self::HEIGHT])
					{
						return true;
					}
				}
			}
			/**
			 * id default effected full size image exist
			 */
			elseif(key_exists($this->getDefaultEffectedSizeName(), $current_attachment_meta['sizes']))
			{
				$size_meta = $current_attachment_meta['sizes'][$this->getDefaultEffectedSizeName()];
				
				if($theme_size = $this->getPostThumbnaiSize())
				{
					if($theme_size[self::WIDTH] < $size_meta[self::WIDTH] 
						|| $theme_size[self::HEIGHT] < $size_meta[self::HEIGHT])
					{
						return true;
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * Check is custom thumbnail size using
	 * @return boolean
	 */
	private function isCustomSizeUsing()
	{
		return get_post_meta($this->getPostID(), SHORTNAME. self::META_SIZE_TYPE, true)  == 'custom';
	}
	
	/**
	 * Setter
	 * @param int $id
	 */
	protected function setPostID($id)
	{
		$this->post_id = $id;
	}
	
	/**
	 * Get current post ID
	 * @return int
	 */
	protected function getPostID()
	{
		return $this->post_id;
	}
	
	/**
	 * check is GD library installed
	 * @return boolean
	 */
	protected function isGDActive()
	{
		return extension_loaded('gd') && function_exists('gd_info');
		
	}
	
	/**
	 * Check is new image was created succesfuly
	 * @return boolean
	 */
	protected function isAbleToCreate()
	{
		return $this->able_to_create;
	}
	
	/**
	 * set flag thet new images creqation fail
	 */
	protected function setUnableToCreate()
	{
		$this->able_to_create = false;
	}
	
	/**
	 * check is 'black_thumbnail' size exist in thumbnailsizes
	 * @return boolean
	 */
	protected function isDefaultEffectedThumbnailExist()
	{
		$meta = $this->getCurrentAttachmentMeta();
		if(isset($meta['sizes'][$this->getDefaultEffectedSizeName()]))
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Get size name of full size effected image 
	 * @return string
	 */
	protected function getDefaultEffectedSizeName()
	{
		return Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX . 'full';
	}
	
	/**
	 * Removing custom post size name records from attachment meta dta
	 * @param array $meta attachment meta
	 */
	protected function unsetOldSizeName(&$meta)
	{
		unset($meta['sizes'][ $this->getSizeNameForPost()]);
		unset($meta['sizes'][Custom_Thumbnail_Effect_BlackWhite::FILE_PREFFIX .  $this->getSizeNameForPost()]);
	}
	
	/**
	 * Removing default(black_full) post size name record from attachment meta dta
	 * @param type $meta
	 */
	protected function unsetDefaultSizeName(&$meta)
	{
		unset($meta['sizes'][$this->getDefaultEffectedSizeName()]);
	}
	
	
}
?>