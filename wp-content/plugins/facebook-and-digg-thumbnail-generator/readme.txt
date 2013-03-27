=== Fedmich's Facebook Open Graph Meta ===
Contributors: fedmich
Tags: facebook, facebook share, facebook like, Facebook Open Graph, digg, google plus one, social, sociable, share, sharing, thumbnails, youtube, image_src, video_src, widget, seo, open graph meta, social media, images, posts, youtube embed, embed, img_src, meta ogimage, open graph, linkedin, linkedin share, ogimage, videos, imgur, imgur, tinypic, youtube short link, vimeo, facebook meta, ogp, google+, plus one, featured image
Requires at least: 2.0.2
Tested up to: 3.5.1
Stable tag: 1.15
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate link: http://fedmich.com/tools/donate

== Description ==
This plugin will automatically add meta tags on the HEAD section of a post, which will then be used by Facebook, Digg, and other website as the preview images of the link you are sharing. It will also enhance your wall posts by adding a clickable videos embed for youtube and Vimeo on the left-side of your Facebook  walls. <a href = 'http://www.facebook.com/pages/FedmichMovies/259185582821'>Sample 1</a> , <a href = 'http://www.facebook.com/pages/FedmichLyrics/118633791513828'>Sample 2</a>.
It doesn't require other plugin and it can be used as is. Just activate it and you can proceed to sharing the urls of your posts to facebook.
Some technical details:
Unlike some other plugins, this one doesn't create additional table on your database. The plugin uses regular expressions and I've added some logics to ensure fast execution of the functions used. It uses cache and custom fields for processing some posts.
Previously knowned as "Facebook and Digg Thumbnail generator" plugin.

== Installation ==
Just activate the plugin and paste the url of post into your facebook pages.
To test if theres a picture being generated, paste it via Facebook's debugger/lint tool.

== Frequently Asked Questions ==
If you got question/suggestions, post it in <a href = 'http://fedmich.com/tools/facebook-and-digg-thumbnail-generator'>fedmich.com/tools/facebook-and-digg-thumbnail-generator</a>

== Screenshots ==
1. Sharing post in facebook
2. Adds required link tag image_scr on head tag
3. Sample clickable youtube videos.
4. for 1.4+ now uses more youtube previews
5. for 1.4+ enhanced youtube params, no relatedpages, just 1 click (autoplay)
6. for 1.12+ support for short youtube links like http://youtu.be/lSt6I4zYU7M 

== Changelog ==
= 1.15.6 =
Will generate a 35 words meta-description automatically from your excerpt or post content
checkbox to disable meta og:locale

= 1.15.5 =
Checkbox in the option page to disable meta og:locale from being added in the header

= 1.15.4 =
Checkbox in the option page to disable meta og:url from being added in the header

= 1.15.3 =
Changed the plugin title so its a bit shorter and added my name
Better compatibility, renamed function to fbthu_set_plugin_meta()

= 1.15.2 =
Added the required meta tags like og:url, og:title, og:description
Also outputs og:locale

= 1.15 =
uses wp_remote_get instead of file_get_contents

= 1.14 =
* Support for Vimeo videos

= 1.13 =
* Prevent duplicate on image_src when using youtu.be

= 1.12 =
* Settings can only be accessed by Administrators. Thanks for the feature request Jason
* Support for new short link youtu.be

= 1.11 =
* Support for some youtube videos being posted using httpv://

= 1.10 =
* Compatibility with Viper's Video Quicktags plugin
* Support for showing the thumbnails of images hosted on imgur.com (multiple sizes), tinypic.com (smaller), and imgjoe.com (thumbnail)
* Added sidebar on the right of options to get the latest news about Fedmich.
* Now also outputs Meta OG:image (Open Graph Image Protocol)

= 1.9 = 
* Support for showing/embedding flash video of Justin.tv on the post

= 1.8 =
* Support for http://www.youtube.com/embed/lSt6I4zYU7M and more iframe embed variants
* Some cleanups and optimized some code a bit
	
= 1.7 =
* Support for embedding of v3 style of youtube embeds, http://www.youtube.com/v/lSt6I4zYU7M?version=3
* Support for youtube using iframes

= 1.6 =
* Settings page 
* Settings to disable embedded videos
* Settings to disable other youtube videos

= 1.5 =
* now scans the post content for images, and use it together with youtube images
	
= 1.4 =
* Support for page/subpages
* Support for youtube-nocookie
* Now autoplays in facebook after 1 click
* Now uses more thumbnails for youtube previews, default.jpg, 0.jg (big), 1.jpg, 2.jpg
* Removes related videos at end of youtube preview
* minor fix, cleaning of youtube ids
	
= 1.3 =
* Support for get_post_meta, post_image  
* minor fix, "Undefined variable", $video_src  

= 1.2 =
* Support for get_post_meta, thumbnail  

= 1.1 =
* Auto-generate youtube embed for facebook  

= 1.0 =
* Auto-generate image_src based on post contents

Send your suggestions and comments on <a href = 'http://fedmich.com/tools/facebook-and-digg-thumbnail-generator'>fedmich.com/tools/facebook-and-digg-thumbnail-generator</a>


== More Info == 

Send your suggestions and comments on <a href = 'http://fedmich.com/tools/facebook-and-digg-thumbnail-generator'>fedmich.com/tools/facebook-and-digg-thumbnail-generator</a>

Thanks

