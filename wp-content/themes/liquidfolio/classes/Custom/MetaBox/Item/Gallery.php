<?php

class Custom_MetaBox_Item_Gallery extends Custom_MetaBox_Item_Default
{
	
	function __construct($taxonomy)
	{
		parent::__construct($taxonomy);
		$this->setId('gallery_meta_box')
			->setTitle('Gallery Taxonomy Meta Box');
		$this->addFields();
	}
	
	protected function addFields()
	{
		parent::addFields();	
		
		$this->getMetaTaxInstance()->addColor( SHORTNAME . '_cat_color', array('name' => 'Category color'));		
		$this->getMetaTaxInstance()->addSelect( SHORTNAME . '_post_listing_sidebar', $this->getSidebars(), array('name' => 'Sidebar', 'std' => ''));
		$this->getMetaTaxInstance()->addCheckbox( SHORTNAME . '_post_listing_title', array('name' => 'Show Gallery Title','description'=>''));
		$this->getMetaTaxInstance()->addSelect( SHORTNAME . '_post_listing_lightbox', array('fullscreen'=>'Fullscreen','small'=>'Small','permalink'=>'Single page'), array('name' => 'Gallery Lightbox type', 'std' => ''));
		$this->getMetaTaxInstance()->addSelect( SHORTNAME . '_post_listing_thumb', array('global'=>'Use global','custom'=>'Use custom'), array('name' => 'Gallery thumbnail size type', 'std' => ''));
		$this->getMetaTaxInstance()->addText( SHORTNAME . '_post_listing_thumb_x',  array('name' => 'Thumbnail width (px)', 'std' => '250'));
		$this->getMetaTaxInstance()->addText( SHORTNAME . '_post_listing_thumb_y',  array('name' => 'Thumbnail height (px)', 'std' => '250'));
	
		/**
		 * @todo add paragraph text
		 */
		
	}
}
?>
