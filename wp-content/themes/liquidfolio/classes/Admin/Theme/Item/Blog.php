<?php
/**
 * 'Blog' admin menu page
 */
class Admin_Theme_Item_Blog extends Admin_Theme_Menu_Item
{
	
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Blog');
		$this->setMenuTitle('Blog');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_blog');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Blog Settings');
		$this->addOption($option);
		$option = null;
		
	
				$option = new Admin_Theme_Element_Checkbox();
				$option->setName ('Infinite scroll')
						->setDescription ('Check to enable infinite scroll')
						->setCustomized()					
						->setId (SHORTNAME."_infinite");
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Checkbox();
				$option->setName ('Disable exceprts')
						->setDescription ('Check to disable excerpts and use content on blog listings instead')
						->setCustomized()					
						->setId (SHORTNAME."_excerpt");
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Checkbox();
				$option->setName ('Hide post title')
						->setDescription ('Hide post title')
						->setCustomized()					
						->setId (SHORTNAME."_hideposttitle");
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Checkbox();
				$option->setName ('Hide post description')
						->setDescription ('Hide post description')
						->setCustomized()					
						->setId (SHORTNAME."_hidepostdesc");
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Checkbox();
				$option->setName ('Enable prev/next post buttons for post')
						->setDescription ('Enable prev/next post buttons for post')
						->setCustomized()					
						->setId (SHORTNAME."_shownavi");
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Checkbox();
				$option->setName ('Enable author desciption')
						->setDescription ('Enable author desciption')
						->setCustomized()					
						->setId (SHORTNAME."_showauthor");
				$this->addOption($option);
				$option = null;

				$option = new Admin_Theme_Element_Subheader();
				$option->setName(__('Post format colors','liquidfolio'));
				$this->addOption($option);
				$option = null;

				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format standard color')
						->setDescription('Select your custom post-format standard color.')
						->setId( SHORTNAME."_pf_standart")
						->setStd("#ff664e");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format gallery color')
						->setDescription('Select your custom post-format gallery color.')
						->setId( SHORTNAME."_pf_gallery")
						->setStd("#a05fef");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format link color')
						->setDescription('Select your custom post-format link color.')
						->setId( SHORTNAME."_pf_link")
						->setStd("#b9d400");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format aside color')
						->setDescription('Select your custom post-format aside color.')
						->setId( SHORTNAME."_pf_aside")
						->setStd("#e05fef");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format image color')
						->setDescription('Select your post-format image color.')
						->setId( SHORTNAME."_pf_image")
						->setStd("#febe36");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format quote color')
						->setDescription('Select your custom post-format quote color.')
						->setId( SHORTNAME."_pf_quote")
						->setStd("#f84f6c");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format audio color')
						->setDescription('Select your custom post-format audio color.')
						->setId( SHORTNAME."_pf_audio")
						->setStd("#00c8bd");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format video color')
						->setDescription('Select your custom post-format video color.')
						->setId( SHORTNAME."_pf_video")
						->setStd("#665fef");
				$this->addOption($option);
				
				$option = new Admin_Theme_Element_Colorchooser();
				$option->setName('post-format status color')
						->setDescription('Select your custom post-format status color.')
						->setId( SHORTNAME."_pf_status")
						->setStd("#00c3f4");
				$this->addOption($option);
				
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
				
		
		
		
		
		
		
		
	}
	
	
}
?>
