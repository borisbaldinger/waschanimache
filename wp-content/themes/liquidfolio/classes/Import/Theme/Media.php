<?php

class Import_Theme_Media implements Import_Theme_Item
{
	private $attach_ids = array();

	function __construct()
	{
		$this->uploadImages();
	}

	public function import()
	{
		$this->setPostsMedia();
		$this->setGalleryOption();
	}

	private function uploadImages()
	{
		$uploads		= wp_upload_dir();
		$filepath		= $uploads['path'];
		$attach_ids		= array();
		$default_images	= array('0DBCE9.png',
								'A05FEF.png',
								'A273DD.png',
								'AEBB09.png',
								'FE664E.png',
							);


		foreach ($default_images as $filename)
		{
			/*
			$def_image = array(
				"src" => get_template_directory() . "/images/" . $filename,
				"link" => "", "description" => "", "type" => "upload",
				"title" => "");
			*/
			$file = $filepath . "/" . $filename;
			if(file_exists(get_template_directory() . "/backend/dummy/images/" . $filename))
			{
				copy(get_template_directory() . "/backend/dummy/images/" . $filename, $file);

				$wp_filetype = wp_check_filetype(basename($file), null);
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($file)),
					'post_content' => '',
					'post_status' => 'inherit'
				);


				$attach_id = wp_insert_attachment($attachment, $file);

				$imagesize = getimagesize($file);

				$metadata					= array();
				$metadata['width']			= $imagesize[0];
				$metadata['height']			= $imagesize[1];
				list($uwidth, $uheight)		= wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
				$metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
				$metadata['file']			= _wp_relative_upload_path($file);

				global $_wp_additional_image_sizes;

				foreach (get_intermediate_image_sizes() as $s)
				{
					$sizes[$s] = array('name' => '', 'width' => '', 'height' => '', 'crop' => FALSE);
					$sizes[$s]['name'] = $s;

					if (isset($_wp_additional_image_sizes[$s]['width']))
						$sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']);
					else
						$sizes[$s]['width'] = get_option("{$s}_size_w");

					if (isset($_wp_additional_image_sizes[$s]['height']))
						$sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']);
					else
						$sizes[$s]['height'] = get_option("{$s}_size_h");

					if (isset($_wp_additional_image_sizes[$s]['crop']))
						$sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']);
					else
						$sizes[$s]['crop'] = get_option("{$s}_crop");
				}

				$sizes = apply_filters('intermediate_image_sizes_advanced', $sizes);
				set_time_limit(30);
				foreach ($sizes as $size => $size_data)
				{
					$metadata['sizes'][$size] = image_make_intermediate_size($file, $size['width'], $size['height'], $size['crop']);
				}

				apply_filters('wp_generate_attachment_metadata', $metadata, $attach_id);
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$att_data = wp_generate_attachment_metadata($attach_id, $file);
				wp_update_attachment_metadata($attach_id, $att_data);

				$this->attach_ids[] = $attach_id;
			}
		}
	}

	private function getAttachedId($id = '')
	{
		if(isset($this->attach_ids[$id]))
		{
			return $this->attach_ids[$id];
		}
		return 0;
	}

	private function getRandomAttachedId()
	{
		return $this->attach_ids[array_rand($this->attach_ids)];
	}


	private function setPostsMedia()
	{
		//set default image for all posts
		$args = array(
			"post_type" => array('post'),
			"posts_per_page" => "-1"
		);

		$all_posts = new WP_Query($args);
		while ($all_posts->have_posts()) :
			$all_posts->the_post();
			set_post_thumbnail(get_the_ID(), $this->getRandomAttachedId());
		endwhile;
	}


	private function setGalleryOption()
	{
		//set default image for slides posts
		$args = array(
			"post_type"			=> array(Custom_Posts_Type_Gallery::POST_TYPE),
			"posts_per_page"	=> "-1"
		);

		$all_gallery_query = new WP_Query($args);

		while ($all_gallery_query->have_posts()) :
			$all_gallery_query->the_post();
			set_post_thumbnail(get_the_ID(), $this->getRandomAttachedId());
		endwhile;
	}
}
?>