<?php
/**
 * 'Footer' admin menu page
 */
class Admin_Theme_Item_Sidebar extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('Sidebars');
		$this->setMenuTitle('Sidebars');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME . '_sidebars');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('Sidebars Settings');
		$this->addOption($option);
		
		
		$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Sidebar background color')
					->setDescription('Please select your custom color for sidebar background.')
					->setId( SHORTNAME."_sidebar_background_color")
					->setStd('#ffffff');
			$this->addOption($option);
		
		
		
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Select();
			$option->setName('Widgets alignment')
					->setDescription('Custom alignment for widgets content')
					->setId(SHORTNAME."_walign")
					->setStd('left')
					->setOptions(array('left','center','right'));
			$this->addOption($option);
			$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Sidebar text color')
					->setDescription('Please select your custom color sidebar text.')
					->setId( SHORTNAME."_sidebar_text_color")
					->setStd('#666666');
			$this->addOption($option);
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Sidebar headings color')
					->setDescription('Please select your custom color for sidebar headings.')
					->setId( SHORTNAME."_sidebar_headings_color")
					->setStd('#363636');
			$this->addOption($option);
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Sidebar links color')
					->setDescription('Please select your custom color for sidebar links.')
					->setId( SHORTNAME."_sidebar_links_color")
					->setStd('#000000');
			$this->addOption($option);
		
		
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
		
		$option = null;
		$option = new Admin_Theme_Element_Sidebar();
		$option->setName('Add Sidebar:')
				->setDescription('Enter the name of the new sidebar that you would like to create.')
				->setId('sidebar_generator_0')
				->setSize('70');
		$this->addOption($option);
		
		$option = new Admin_Theme_Element_SidebarDelete();
		$option->setDescription('Below are the Sidebars you have created:')
				->setName('Sidebars created:')
				->setElementListClass('info_top');
		$this->addOption($option);
	}
}
?>
