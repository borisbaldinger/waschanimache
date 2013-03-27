<?php

class Import_Theme_Widgets implements Import_Theme_Item
{

	public function import()
	{
		$sidebars = get_option("sidebars_widgets");
		$sidebars["default-sidebar"] = array("liquidfolio-feedburner-2", "liquidfolio-twitter-2", "liquidfolio-tagcloud-3");
		$sidebars["qd_sidebar-1"] = array();
		$sidebars["qd_sidebar-2"] = array("search-4", "liquidfolio-gallery-3");
		$sidebars["qd_sidebar-3"] = array("liquidfolio-feedburner-3", "liquidfolio-twitter-3", "liquidfolio-tagcloud-2");
		$sidebars["qd_sidebar-4"] = array("text-2");
		$sidebars["qd_sidebar-5"] = array("liquidfolio-twitter-4");
		$sidebars["qd_sidebar-6"] = array();
		$sidebars["qd_sidebar-7"] = array("text-3", "liquidfolio-social-links-2");
		update_option("sidebars_widgets", $sidebars);


// Widget Liquidfolio feedburner
		$liquidfolio_feedburner = get_option("widget_liquidfolio-feedburner");
		$liquidfolio_feedburner[2] = array("title" => "Newsletter Signup", "description" => "Sign up for our mailing list to stay updated on the latest themes from the Quedorei! ", "feedname" => "queldorei",);
		$liquidfolio_feedburner[3] = array("title" => "Sign up for our Newsletter", "description" => "Keep up with the latest news and events.", "feedname" => "queldorei",);
		$liquidfolio_feedburner["_multiwidget"] = 1;
		update_option("widget_liquidfolio-feedburner", $liquidfolio_feedburner);



// Widget Liquidfolio twitter
		$liquidfolio_twitter = get_option("widget_liquidfolio-twitter");
		$liquidfolio_twitter[2] = array("title" => "Recent Tweets", "username" => "QueldoreiThemes", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on",);
		$liquidfolio_twitter[3] = array("title" => "Twitter", "username" => "QueldoreiThemes", "num" => "3", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on",);
		$liquidfolio_twitter[4] = array("title" => "Twitter", "username" => "QueldoreiThemes", "num" => "2", "update" => "on", "linked" => "", "hyperlinks" => "on", "twitter_users" => "on", "encode_utf8" => "on",);
		$liquidfolio_twitter["_multiwidget"] = 1;
		update_option("widget_liquidfolio-twitter", $liquidfolio_twitter);



// Widget Liquidfolio tagcloud
		$liquidfolio_tagcloud = get_option("widget_liquidfolio-tagcloud");
		$liquidfolio_tagcloud[2] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$liquidfolio_tagcloud[3] = array("title" => "Tags", "taxonomy" => "post_tag",);
		$liquidfolio_tagcloud["_multiwidget"] = 1;
		update_option("widget_liquidfolio-tagcloud", $liquidfolio_tagcloud);



// Widget Search
		$search = get_option("widget_search");
		$search[4] = array("title" => "",);
		$search["_multiwidget"] = 1;
		update_option("widget_search", $search);



// Widget Liquidfolio gallery
		$liquidfolio_gallery = get_option("widget_liquidfolio-gallery");
		$liquidfolio_gallery[3] = array("title" => "From gallery", "number" => "4", "category" => "video",);
		$liquidfolio_gallery["_multiwidget"] = 1;
		update_option("widget_liquidfolio-gallery", $liquidfolio_gallery);



// Widget Text
		$text = get_option("widget_text");
		$text[2] = array("title" => "Need Help?", "text" => "<p style=\"text-align:center\">If you encounter any problems or have questions once you purchased the theme feel free to drop us a notice at <a href=\"http://help.queldorei.com/\">http://help.queldorei.com/</a></p>", "filter" => "",);
		$text[3] = array("title" => "How to find us", "text" => "<p style=\"text-align: center;\">You can also add you contact information here!</p> <p style=\"text-align: center;\">(123) 456-7890 <br/><a href=\"maito:mail@companyname.com\">mail@companyname.com</a></p> <p style=\"text-align: center;\">1234 Topaz Way<br/> San Francisco, CA,<br/> United States</p>", "filter" => "",);
		$text["_multiwidget"] = 1;
		update_option("widget_text", $text);



// Widget Liquidfolio social links
		$liquidfolio_social_links = get_option("widget_liquidfolio-social-links");
		$liquidfolio_social_links[2] = array("hide_icon" => "", "title" => "Follow us", "twitter_account" => "queldoreithemes", "twitter_account_title" => "Twitter", "facebook_account" => "queldorei", "facebook_account_title" => "Facebook", "google_plus_account" => "queldorei", "google_plus_account_title" => "Google Plus", "rss_feed" => "http://liquidfolio.queldorei.com/feed", "rss_feed_title" => "RSS", "email_to" => "queldorei", "email_to_title" => "Email", "flicker_account" => "queldorei", "flicker_account_title" => "Flicker", "vimeo_account" => "queldorei", "vimeo_account_title" => "Vimeo", "youtube_account" => "queldorei", "youtube_account_title" => "YouTube", "dribble_account" => "queldorei", "dribble_account_title" => "Dribbble", "linkedin_account" => "queldorei", "linkedin_account_title" => "", "pinterest_account" => "queldorei", "pinterest_account_title" => "Pinterest",);
		$liquidfolio_social_links["_multiwidget"] = 1;
		update_option("widget_liquidfolio-social-links", $liquidfolio_social_links);
	}

}

?>