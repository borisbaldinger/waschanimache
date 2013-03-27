<?php
/**
 * 'Update' admin menu page
 */
class Admin_Theme_Item_Update extends Admin_Theme_Menu_Item
{
	public function __construct($parent_slug = '')
	{

		$this->setPageTitle(__('Theme updater','liquidfolio'));
		$this->setMenuTitle(__('Theme Updater','liquidfolio'));
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_update');
		parent::__construct($parent_slug);

		$this->init();
	}

	public function init()
	{
		$option = null;
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName(__('User Account Information','liquidfolio'));
		$this->addOption($option);

		$option = null;

		$option = new Admin_Theme_Element_Text();
		$option->setName(__('Marketplace Username','liquidfolio'))
				->setDescription(__('Provide Username for theme update','liquidfolio'))
				->setId(SHORTNAME."_envato_nick")
				->setStd('');
		$this->addOption($option);
		$option = null;


		$option = new Admin_Theme_Element_Text();
		$option->setName(__('Secret API Key','liquidfolio'))
				->setDescription(__('Provide API Key for theme update','liquidfolio'))
				->setId(SHORTNAME."_envato_api")
				->setStd('');
		$this->addOption($option);
		$option = null;

		$option = new Admin_Theme_Element_Checkbox();
		$option->setDescription ('Check for skipping theme backup before update')
				->setName ('Skip backup theme before update')
				->setId (SHORTNAME."_envato_skip_backup");
		$this->addOption($option);
		$option = null;
	}
}
?>