<?php
/**
 * 'Footer' admin menu page
 */
class Admin_Theme_Item_Footer extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Footer');
		$this->setMenuTitle('Footer');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_footer');
		parent::__construct($parent_slug);
		
		$this->init();
	}

	public function init()
	{
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Footer Settings');
		$this->addOption($option);
		
		$option = null;
		
				
	
		$option = new Admin_Theme_Element_Text();
		$option->setName('Footer text')
				->setDescription('Type here text that appear at botttom of each page - copyrights, etc..')
				->setId(SHORTNAME."_copyright")
				->setStd("LiquidFolio 2013 &copy; <a href='http://queldorei.com'>Premium WordPress Themes</a> by Queldorei");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Textarea();
		$option->setName('Google Analytics')
				->setDescription('Insert your Google Analytics (or other) code here.')
				->setId(SHORTNAME."_GA")
				->setStd("")
				->setElementListClass('info_top');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Separator();
		$option->setType(Admin_Theme_Menu_Element::TYPE_SEPARATOR);
		$this->addOption($option);
		$option = null;	
		
		
		
	
	}
}
?>