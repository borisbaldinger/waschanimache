<?php

class Import_Theme_Options implements Import_Theme_Item
{

	public function import()
	{
		update_option('lf_sidebar_generator', unserialize('a:7:{s:12:"test-sidebar";s:12:"Test Sidebar";s:10:"video-post";s:10:"Video Post";s:10:"usual-post";s:10:"Usual post";s:13:"features-page";s:13:"Features page";s:12:"gallery-page";s:12:"Gallery page";s:14:"portfolio-page";s:14:"portfolio Page";s:8:"contacts";s:8:"contacts";}'));

		update_option('tax_meta_10', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#02cf95";}'));
		update_option('tax_meta_11', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#e05fef";}'));
		update_option('tax_meta_12', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#665fef";}'));
		update_option('tax_meta_13', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#74cc00";}'));
		update_option('tax_meta_17', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#8ad902";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_18', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#c847ff";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_22', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#725eed";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_24', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#00e0b6";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_25', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#00a6f0";}'));
		update_option('tax_meta_28', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#eb0088";}'));
		update_option('tax_meta_29', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#42c2ff";}'));
		update_option('tax_meta_31', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#c851f6";}'));
		update_option('tax_meta_32', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#87db00";}'));
		update_option('tax_meta_33', unserialize('a:1:{s:12:"lf_cat_color";s:1:"#";}'));
		update_option('tax_meta_34', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#ff664e";}'));
		update_option('tax_meta_35', unserialize('a:1:{s:12:"lf_cat_color";s:7:"#bad300";}'));
		update_option('tax_meta_36', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#ff2eb4";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_37', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#ffb500";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_6', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#0091e6";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));
		update_option('tax_meta_9', unserialize('a:2:{s:12:"lf_cat_color";s:7:"#ff5b4d";s:23:"lf_post_listing_sidebar";s:12:"test-sidebar";}'));

//		update_option("avatar_default", get_stylesheet_directory_uri() . "/images/noava.png");
		
		update_option(SHORTNAME . '_infinite', '1');
		update_option(SHORTNAME . '_excerpt', '1');
		
	}

}

?>
