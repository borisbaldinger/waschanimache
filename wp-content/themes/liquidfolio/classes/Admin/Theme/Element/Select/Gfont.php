<?php

/**
 * Class for Google font Html element 
 */
class Admin_Theme_Element_Select_Gfont extends Admin_Theme_Element_Select
{
	/**
	 * List of google fonts
	 * @see https://developers.google.com/webfonts/
	 */
	const FONT_LIST = 'Abel,Abril Fatface,Aclonica,Acme,Actor,Adamina,Aguafina Script,Aladin,Aldrich,Alegreya,Alegreya SC,Alex Brush,Alfa Slab One,Alice,Alike,Alike Angular,Allan,Allerta,Allerta Stencil,Allura,Almendra,Almendra SC,Amaranth,Amatic SC,Amethysta,Andada,Andika,Annie Use Your Telescope,Anonymous Pro,Antic,Anton,Arapey,Arbutus,Architects Daughter,Arimo,Arizonia,Armata,Artifika,Arvo,Asap,Asset,Astloch,Asul,Atomic Age,Aubrey,Bad Script,Balthazar,Bangers,Basic,Baumans,Belgrano,Bentham,Bevan,Bigshot One,Bilbo,Bilbo Swash Caps,Bitter,Black Ops One,Bonbon,Boogaloo,Bowlby One,Bowlby One SC,Brawler,Bree Serif,Bubblegum Sans,Buda,Buenard,Butcherman,Butterfly Kids,Cabin,Cabin Condensed,Cabin Sketch,Caesar Dressing,Cagliostro,Calligraffitti,Cambo,Candal,Cantarell,Cardo,Carme,Carter One,Caudex,Cedarville Cursive,Ceviche One,Changa One,Chango,Chelsea Market,Cherry Cream Soda,Chewy,Chicle,Chivo,Coda,Coda Caption,Comfortaa,Coming Soon,Concert One,Condiment,Contrail One,Convergence,Cookie,Copse,Corben,Cousine,Coustard,Covered By Your Grace,Crafty Girls,Creepster,Crete Round,Crimson Text,Crushed,Cuprum,Damion,Dancing Script,Dawning of a New Day,Days One,Delius,Delius Swash Caps,Delius Unicase,Devonshire,Didact Gothic,Diplomata,Diplomata SC,Dorsa,Dr Sugiyama,Droid Sans,Droid Sans Mono,Droid Serif,Duru Sans,Dynalight,EB Garamond,Eater,Electrolize,Emblema One,Engagement,Enriqueta,Erica One,Esteban,Euphoria Script,Ewert,Exo,Expletus Sans,Fanwood Text,Fascinate,Fascinate Inline,Federant,Federo,Felipa,Fjord One,Flamenco,Flavors,Fondamento,Fontdiner Swanky,Forum,Francois One,Fredericka the Great,Fresca,Frijole,Fugaz One,Galdeano,Gentium Basic,Gentium Book Basic,Geo,Geostar,Geostar Fill,Germania One,Give You Glory,Glegoo,Gloria Hallelujah,Goblin One,Gochi Hand,Goudy Bookletter 1911,Gravitas One,Gruppo,Gudea,Habibi,Hammersmith One,Handlee,Herr Von Muellerhoff,Holtwood One SC,Homemade Apple,Homenaje,IM Fell DW Pica,IM Fell DW Pica SC,IM Fell Double Pica,IM Fell Double Pica SC,IM Fell English,IM Fell English SC,IM Fell French Canon,IM Fell French Canon SC,IM Fell Great Primer,IM Fell Great Primer SC,Iceberg,Iceland,Inconsolata,Inder,Indie Flower,Inika,Irish Grover,Istok Web,Italianno,Jim Nightshade,Jockey One,Josefin Sans,Josefin Slab,Judson,Julee,Junge,Jura,Just Another Hand,Just Me Again Down Here,Kameron,Kaushan Script,Kelly Slab,Kenia,Knewave,Kotta One,Kranky,Kreon,Kristi,La Belle Aurore,Lancelot,Lato,League Script,Leckerli One,Lekton,Lemon,Lilita One,Limelight,Linden Hill,Lobster,Lobster Two,Lora,Love Ya Like A Sister,Loved by the King,Luckiest Guy,Lusitana,Lustria,Macondo,Macondo Swash Caps,Magra,Maiden Orange,Mako,Marck Script,Marko One,Marmelad,Marvel,Mate,Mate SC,Maven Pro,Meddon,MedievalSharp,Medula One,Megrim,Merienda One,Merriweather,Metamorphous,Metrophobic,Michroma,Miltonian,Miltonian Tattoo,Miniver,Miss Fajardose,Modern Antiqua,Molengo,Monofett,Monoton,Monsieur La Doulaise,Montaga,Montez,Montserrat,Mountains of Christmas,Mr Bedfort,Mr Dafoe,Mr De Haviland,Mrs Saint Delafield,Mrs Sheppards,Muli,Neucha,Neuton,News Cycle,Niconne,Nixie One,Nobile,Norican,Nosifer,Nothing You Could Do,Noticia Text,Nova Cut,Nova Flat,Nova Mono,Nova Oval,Nova Round,Nova Script,Nova Slim,Nova Square,Numans,Nunito,Old Standard TT,Oldenburg,Open Sans,Open Sans Condensed,Orbitron,Original Surfer,Oswald,Over the Rainbow,Overlock,Overlock SC,Ovo,PT Sans,PT Sans Caption,PT Sans Narrow,PT Serif,PT Serif Caption,Pacifico,Parisienne,Passero One,Passion One,Patrick Hand,Patua One,Paytone One,Permanent Marker,Petrona,Philosopher,Piedra,Pinyon Script,Plaster,Play,Playball,Playfair Display,Podkova,Poller One,Poly,Pompiere,Port Lligat Sans,Port Lligat Slab,Prata,Princess Sofia,Prociono,Puritan,Quantico,Quattrocento,Quattrocento Sans,Questrial,Quicksand,Qwigley,Radley,Raleway,Rammetto One,Rancho,Rationale,Redressed,Reenie Beanie,Ribeye,Ribeye Marrow,Righteous,Rochester,Rock Salt,Rokkitt,Ropa Sans,Rosario,Rouge Script,Ruda,Ruge Boogie,Ruluko,Ruslan Display,Ruthie,Sail,Salsa,Sancreek,Sansita One,Sarina,Satisfy,Schoolbell,Shadows Into Light,Shanti,Share,Shojumaru,Short Stack,Sigmar One,Signika,Signika Negative,Sirin Stencil,Six Caps,Slackey,Smokum,Smythe,Sniglet,Snippet,Sofia,Sonsie One,Sorts Mill Goudy,Special Elite,Spicy Rice,Spinnaker,Spirax,Squada One,Stardos Stencil,Stint Ultra Condensed,Stint Ultra Expanded,Stoke,Sue Ellen Francisco,Sunshiney,Supermercado One,Swanky and Moo Moo,Syncopate,Tangerine,Telex,Tenor Sans,Terminal Dosis,The Girl Next Door,Tienne,Tinos,Titan One,Trade Winds,Trochut,Trykker,Tulpen One,Ubuntu,Ubuntu Condensed,Ubuntu Mono,Ultra,Uncial Antiqua,UnifrakturCook,UnifrakturMaguntia,Unkempt,Unlock,Unna,VT323,Varela,Varela Round,Vast Shadow,Vibur,Vidaloka,Viga,Volkhov,Vollkorn,Voltaire,Waiting for the Sunrise,Wallpoet,Walter Turncoat,Wellfleet,Wire One,Yanone Kaffeesatz,Yellowtail,Yeseva One,Yesteryear,Zeyada';
	/**
	 * Default specifying font families and styles in a stylesheet URL
	 * @see https://developers.google.com/webfonts/docs/getting_started#Syntax
	 */
	const DEFAULT_STYLE = '300italic,400italic,600italic,700italic,800italic,400,300,600,700,800';
	/**
	 * Suffix for addition style option
	 */
	const STYLE_SUFFIX = '_style';
	
	protected $option = array(
						'type' => Admin_Theme_Menu_Element::TYPE_SELECT,
					);
	
	function __construct()
	{
		$this->setOptions($this->getFonts());
	}
	
	/**
	 * Add JS to admin header for displaying font preview
	 */
	function google_font_preview()
	{
	?>
		<script type="text/javascript">
			function change_<?php echo $this->getId()?>() {
				var str = '';
				var style = '';
				
				str = jQuery("#<?php echo $this->getId()?> option:selected").val();
				
				style = jQuery("#<?php echo $this->getFontStyleId()?>").val();
				
				if(typeof style !='undefined' && style.length)
				{
					style = ':'+style;
				}
				else
				{
					style = '';
				}
				
				if(typeof str !='undefined' && str.length)
				{
					var jqxhr = jQuery.ajax({
						url: "//fonts.googleapis.com/css?family=" + str + style,
						dataType: "jsonp",
						timeout:1000,
						crossDomain: true,
						beforeSend: function(){jQuery('.loader_<?php echo $this->getId();?>').show()}
					}).always(function() { 
						console.log(jqxhr);
						if(jqxhr.statusText == 'success')
						{
							jQuery('link#<?php echo $this->getId().'_link' ?>').remove();
							var link = ("<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=" + str + style+"&text=The quick brown fox jumps over the lazy dog' media='screen' id='<?php echo $this->getId() . '_link'?>'/>");
							jQuery("head").append(link);
							jQuery("#gfont_preview_<?php echo $this->getId()?>").css("font-family", str);
							jQuery("#<?php echo $this->getFontStyleId().'_error'?>").hide();
							
						}
						else
						{
							jQuery('link#<?php echo $this->getId().'_link' ?>').remove();
							jQuery('#<?php echo $this->getFontStyleId().'_error'?>').show();
							
						}
						jQuery('.loader_<?php echo $this->getId();?>').hide()
					});    
					
				}
			}
			
			jQuery(document).ready(function(){
			
				if(jQuery('#<?php echo $this->getId()?>'))
				{
					if(jQuery('#gfont_preview_<?php echo $this->getId()?>').length == 0)
					{
						jQuery("#<?php echo $this->getId()?>").closest("div").before('<div class="gfont_preview" id="gfont_preview_<?php echo $this->getId()?>">The quick brown fox jumps over the lazy dog</div>');
						change_<?php echo $this->getId()?>();
					}

					jQuery("#<?php echo $this->getId()?>").change(function() {
						change_<?php echo $this->getId()?>();
					});

					jQuery("#<?php echo $this->getId()?>").keyup(function() {
						change_<?php echo $this->getId()?>();
					});

					jQuery("#<?php echo $this->getId()?>").keydown(function() {
						change_<?php echo $this->getId()?>();
					});

					jQuery("#<?php echo $this->getFontStyleId()?>").change(function() {
						change_<?php echo $this->getId()?>();
					});
				}
			});
		</script>
	<?php
	}
	
	/**
	 * Render select with fonts and addition input with specifying font families and styles
	 * @return string HTML 
	 */
	public function render()
	{
		ob_start();
		echo $this->getElementHeader();
		$cur = false;
		?>
		<select  name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
				<?php foreach ($this->options as $option) { ?>
					<option 
						<?php if ( get_option( $this->id ) == $option) 
						{
							echo ' selected="selected"';
							$cur = true; 
						}
						elseif($option == $this->std && !$cur)
						{
							echo ' selected="selected"'; 
							
						}
						?>>
							<?php echo $option; ?>
					</option>
				<?php } ?>
		</select>
		<label for="<?php echo $this->getFontStyleId(); ?>" style="font-size: 1em;">Specifying font families and styles</label>
			<a href="#" title="To request other styles or weights" class="ft_help">
				<img src="<?php echo get_template_directory_uri() . '/backend/img/help.png'; ?>" alt="" />
			</a><br>
		<input type="text" id="<?php echo  $this->getFontStyleId(); ?>" name="<?php echo  $this->getFontStyleId();?>" value="<?php echo get_option( $this->getFontStyleId() )?>" style="width:95%;">
		<img class="loader_<?php echo $this->getId();?>" alt="Loading" src="images/wpspin_light.gif" style="display:none;">
		<span class="font_error" id='<?php echo  $this->getFontStyleId().'_error'; ?>'>There are no font families that match</span>
		<?php
		echo $this->getElementFooter();
		 
		 $html = ob_get_clean();
		 return $html;
	}

	
	public function setId($id)
	{
		parent::setId($id);
		add_action('admin_head', array($this, 'google_font_preview'));
		return $this;
	}


	/**
	 * Fonts list
	 * @return array
	 */
	private function getFonts()
	{
		return explode(',', self::FONT_LIST);
	}
	
	/**
	 * Reset Gfont option and addition style option too
	 */
	public function reset()
	{
		parent::reset();
		
		if($this->getId())
		{
			update_option($this->getFontStyleId(), $this->getStdFontStyle());
		}
	}
	
	/**
	 * Save Gfont element and addtional style option
	 */
	public function save()
	{
		parent::save();
		if($this->getId())
		{
			update_option($this->getFontStyleId(), $this->getStyleRequestValue());
		}
	}
	
	/**
	 * Get addtion style value from request
	 * @return string|bool
	 */
	private function getStyleRequestValue()
	{
		if(isset($_REQUEST[$this->getFontStyleId()]))
		{
			return $_REQUEST[$this->getFontStyleId()];
		}
		return '';
	}
	
	/**
	 * Get font style option id
	 * @return type
	 */
	private function getFontStyleId()
	{
		return $this->getId().self::STYLE_SUFFIX;
	}
	
	/**
	 * Save default font value with default font families and styles
	 */
	public function setDefaultValue()
	{
		parent::setDefaultValue();
		
		if(get_option($this->getId()) === false)
		{
			add_option($this->getFontStyleId(), $this->getFontStyle());
		}
	}
	

	/**
	 * Return formated string for stylesheet request with font date
	 * @param string $id gfont id
	 * @return string
	 */
	public static function getFontRequest($id, $text = '')
	{
		$request = '';
		
		if ($font = get_option($id))
		{
			if($style = get_option($id . Admin_Theme_Element_Select_Gfont::STYLE_SUFFIX)) 
			{
				$request = str_replace(' ', '+', $font . ':' . $style);
			}
			else
			{
				$request = str_replace(' ', '+', $font);
			}
		}
		if($text)
		{
			$text = '&text='.urlencode($text);
		}
		$e = $request . $text;
		return $e;
	}
	
	public function setStdFontStyles($style)
	{
		$this->option['style'] = $style;
		return $this;
	}
	
	private function getStdFontStyle()
	{
		if(isset($this->option['style']))
		{
			return $this->option['style'];
		}
		return '';
	}
}
?>
