<?php
/**
 * 'Custom Icon' admin menu page
 */
class Admin_Theme_Item_Galleries extends Admin_Theme_Menu_Item
{
	/**
	 * prefix of file icons option
	 */
	const CUSTOM_GALLERY_ICONS = '_custom_gallery_icons';
	
	public function __construct($parent_slug = '')
	{
		$this->setPageTitle('Galleries');
		$this->setMenuTitle('Galleries');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_galleries');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Galleries settings');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Description();
		$option->setName(__('<p>Global sizes for thumbnails. They can be overridden in post/page</p>','liquidfolio'));
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_Text();
		$option->setName('Gallery Thumbnail width(px)')
				->setDescription('Width value for gallery post thumbnails')
				->setId(SHORTNAME . Custom_Thumbnail_Gallery::GLOBAL_PAGE_WIDTH)
				->setStd(Custom_Thumbnail_Gallery::DEFAULT_WIDTH)
				->setElementListClass('short_text');
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Text();
		$option->setName('Gallery Thumbnail height{px}')
				->setDescription('Height value for gallery post thumbnails')
				->setId(SHORTNAME . Custom_Thumbnail_Gallery::GLOBAL_PAGE_HEIGHT)
				->setStd(Custom_Thumbnail_Gallery::DEFAULT_HEIGHT)
				->setElementListClass('short_text');
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName ('Enable prev/next post buttons for gallery')
				->setDescription ('Enable prev/next post buttons for gallery')
				->setCustomized()					
				->setId (SHORTNAME."_show_gallery_navi");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName ('Enable blog link button for gallery')
				->setDescription ('Enable blog link button for gallery')
				->setCustomized()					
				->setId (SHORTNAME."_show_gallery_blog_link");
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_Checkbox();
		$option->setName ('Enable author desciption')
				->setDescription ('Enable author desciption')
				->setCustomized()					
				->setId (SHORTNAME."_show_gallery_author");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Gallery Taxonomy default color')
				->setDescription('Select default color for gallery taxonomy.')
				->setId( SHORTNAME."_default_gallery_tax_color")
				->setStd("#ff664e");
		$this->addOption($option);
		
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Gallery thumbnail background color')
				->setDescription('Select your custom background color for gallery thumbnail.')
				->setId( SHORTNAME."_gallery_thumb_background")
				->setStd("#363636");
		$this->addOption($option);
		
		
		
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Gallery Post Image color')
				->setDescription('Select default color for gallery\'s post type "Image".')
				->setId( SHORTNAME."_gallery_image_color")
				->setStd("#febe36");
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Gallery Post Slideshow color')
				->setDescription('Select default color for gallery\'s post type "Slideshow".')
				->setId( SHORTNAME."_gallery_slideshow_color")
				->setStd("#a05fef");
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Gallery Post Video color')
				->setDescription('Select default color for gallery\'s post type "Video".')
				->setId( SHORTNAME."_gallery_video_color")
				->setStd("#665fef");
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Colorchooser();
		$option->setName('Gallery Post Audio color')
				->setDescription('Select default color for gallery\'s post type "Audio".')
				->setId( SHORTNAME."_gallery_audio_color")
				->setStd("#00c8bd");
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
		$custom_page = new Custom_Posts_Type_Gallery();
		$option = new Admin_Theme_Element_Text();
		$option->setName('Gallery Post slug')
				->setDescription('Please type your custom slug for gallery\'s post.')
				->setId($custom_page->getPostSlugOptionName())
				->setStd($custom_page->getDefaultPostSlug());
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Text();
		$option->setName('Gallery Taxonomy slug')
				->setDescription('Please type your custom slug for gallery\'s taxonomy.')
				->setId($custom_page->getTaxSlugOptionName())
				->setStd($custom_page->getDefaultTaxSlug());
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
	
	}
	
		/**
	 * Save form and set option-flag for reinit rewrite rules on init
	 */
	public function saveForm()
	{
		parent::saveForm();
		$this->setNeedReinitRulesFlag();
	}
	
	/**
	 * Reset form and set option-flag for reinit rewrite rules on init
	 */
	public function resetForm()
	{
		parent::resetForm();
		$this->setNeedReinitRulesFlag();
	}
	
	/**
	 * save to DB flag of need do flush_rewrite_rules on next init
	 */
	private function setNeedReinitRulesFlag()
	{
		update_option(SHORTNAME.'_need_flush_rewrite_rules', '1');
	}
}
?>
