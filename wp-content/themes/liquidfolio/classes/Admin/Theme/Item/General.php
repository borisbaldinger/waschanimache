<?php
/**
 * 'General' admin menu page
 */
class Admin_Theme_Item_General extends Admin_Theme_Menu_Item
{
	
	const FONT_LIST = 'ABeeZee,Abel,Abril Fatface,Aclonica,Acme,Actor,Adamina,Advent Pro,Aguafina Script,Akronim,Aladin,Aldrich,Alegreya,Alegreya SC,Alex Brush,Alfa Slab One,Alice,Alike,Alike Angular,Allan,Allerta,Allerta Stencil,Allura,Almendra,Almendra Display,Almendra SC,Amarante,Amaranth,Amatic SC,Amethysta,Anaheim,Andada,Andika,Angkor,Annie Use Your Telescope,Anonymous Pro,Antic,Antic Didone,Antic Slab,Anton,Arapey,Arbutus,Arbutus Slab,Architects Daughter,Archivo Black,Archivo Narrow,Arimo,Arizonia,Armata,Artifika,Arvo,Asap,Asset,Astloch,Asul,Atomic Age,Aubrey,Audiowide,Autour One,Average,Average Sans,Averia Gruesa Libre,Averia Libre,Averia Sans Libre,Averia Serif Libre,Bad Script,Balthazar,Bangers,Basic,Battambang,Baumans,Bayon,Belgrano,Belleza,BenchNine,Bentham,Berkshire Swash,Bevan,Bigelow Rules,Bigshot One,Bilbo,Bilbo Swash Caps,Bitter,Black Ops One,Bokor,Bonbon,Boogaloo,Bowlby One,Bowlby One SC,Brawler,Bree Serif,Bubblegum Sans,Bubbler One,Buda,Buenard,Butcherman,Butterfly Kids,Cabin,Cabin Condensed,Cabin Sketch,Caesar Dressing,Cagliostro,Calligraffitti,Cambo,Candal,Cantarell,Cantata One,Cantora One,Capriola,Cardo,Carme,Carrois Gothic,Carrois Gothic SC,Carter One,Caudex,Cedarville Cursive,Ceviche One,Changa One,Chango,Chau Philomene One,Chela One,Chelsea Market,Chenla,Cherry Cream Soda,Cherry Swash,Chewy,Chicle,Chivo,Cinzel,Cinzel Decorative,Clicker Script,Coda,Coda Caption,Codystar,Combo,Comfortaa,Coming Soon,Concert One,Condiment,Content,Contrail One,Convergence,Cookie,Copse,Corben,Courgette,Cousine,Coustard,Covered By Your Grace,Crafty Girls,Creepster,Crete Round,Crimson Text,Croissant One,Crushed,Cuprum,Cutive,Cutive Mono,Damion,Dancing Script,Dangrek,Dawning of a New Day,Days One,Delius,Delius Swash Caps,Delius Unicase,Della Respira,Denk One,Devonshire,Didact Gothic,Diplomata,Diplomata SC,Domine,Donegal One,Doppio One,Dorsa,Dosis,Dr Sugiyama,Droid Sans,Droid Sans Mono,Droid Serif,Duru Sans,Dynalight,EB Garamond,Eagle Lake,Eater,Economica,Electrolize,Elsie,Elsie Swash Caps,Emblema One,Emilys Candy,Engagement,Englebert,Enriqueta,Erica One,Esteban,Euphoria Script,Ewert,Exo,Expletus Sans,Fanwood Text,Fascinate,Fascinate Inline,Faster One,Fasthand,Federant,Federo,Felipa,Fenix,Finger Paint,Fjalla One,Fjord One,Flamenco,Flavors,Fondamento,Fontdiner Swanky,Forum,Francois One,Freckle Face,Fredericka the Great,Fredoka One,Freehand,Fresca,Frijole,Fruktur,Fugaz One,GFS Didot,GFS Neohellenic,Gafata,Galdeano,Galindo,Gentium Basic,Gentium Book Basic,Geo,Geostar,Geostar Fill,Germania One,Gilda Display,Give You Glory,Glass Antiqua,Glegoo,Gloria Hallelujah,Goblin One,Gochi Hand,Gorditas,Goudy Bookletter 1911,Graduate,Grand Hotel,Gravitas One,Great Vibes,Griffy,Gruppo,Gudea,Habibi,Hammersmith One,Hanalei,Hanalei Fill,Handlee,Hanuman,Happy Monkey,Headland One,Henny Penny,Herr Von Muellerhoff,Holtwood One SC,Homemade Apple,Homenaje,IM Fell DW Pica,IM Fell DW Pica SC,IM Fell Double Pica,IM Fell Double Pica SC,IM Fell English,IM Fell English SC,IM Fell French Canon,IM Fell French Canon SC,IM Fell Great Primer,IM Fell Great Primer SC,Iceberg,Iceland,Imprima,Inconsolata,Inder,Indie Flower,Inika,Irish Grover,Istok Web,Italiana,Italianno,Jacques Francois,Jacques Francois Shadow,Jim Nightshade,Jockey One,Jolly Lodger,Josefin Sans,Josefin Slab,Joti One,Judson,Julee,Julius Sans One,Junge,Jura,Just Another Hand,Just Me Again Down Here,Kameron,Karla,Kaushan Script,Kavoon,Keania One,Kelly Slab,Kenia,Khmer,Kite One,Knewave,Kotta One,Koulen,Kranky,Kreon,Kristi,Krona One,La Belle Aurore,Lancelot,Lato,League Script,Leckerli One,Ledger,Lekton,Lemon,Libre Baskerville,Life Savers,Lilita One,Limelight,Linden Hill,Lobster,Lobster Two,Londrina Outline,Londrina Shadow,Londrina Sketch,Londrina Solid,Lora,Love Ya Like A Sister,Loved by the King,Lovers Quarrel,Luckiest Guy,Lusitana,Lustria,Macondo,Macondo Swash Caps,Magra,Maiden Orange,Mako,Marcellus,Marcellus SC,Marck Script,Margarine,Marko One,Marmelad,Marvel,Mate,Mate SC,Maven Pro,McLaren,Meddon,MedievalSharp,Medula One,Megrim,Meie Script,Merienda,Merienda One,Merriweather,Metal,Metal Mania,Metamorphous,Metrophobic,Michroma,Milonga,Miltonian,Miltonian Tattoo,Miniver,Miss Fajardose,Modern Antiqua,Molengo,Molle,Monda,Monofett,Monoton,Monsieur La Doulaise,Montaga,Montez,Montserrat,Montserrat Alternates,Montserrat Subrayada,Moul,Moulpali,Mountains of Christmas,Mouse Memoirs,Mr Bedfort,Mr Dafoe,Mr De Haviland,Mrs Saint Delafield,Mrs Sheppards,Muli,Mystery Quest,Neucha,Neuton,New Rocker,News Cycle,Niconne,Nixie One,Nobile,Nokora,Norican,Nosifer,Nothing You Could Do,Noticia Text,Nova Cut,Nova Flat,Nova Mono,Nova Oval,Nova Round,Nova Script,Nova Slim,Nova Square,Numans,Nunito,Odor Mean Chey,Offside,Old Standard TT,Oldenburg,Oleo Script,Oleo Script Swash Caps,Open Sans,Open Sans Condensed,Oranienbaum,Orbitron,Oregano,Orienta,Original Surfer,Oswald,Over the Rainbow,Overlock,Overlock SC,Ovo,Oxygen,Oxygen Mono,PT Mono,PT Sans,PT Sans Caption,PT Sans Narrow,PT Serif,PT Serif Caption,Pacifico,Paprika,Parisienne,Passero One,Passion One,Patrick Hand,Patua One,Paytone One,Peralta,Permanent Marker,Petit Formal Script,Petrona,Philosopher,Piedra,Pinyon Script,Pirata One,Plaster,Play,Playball,Playfair Display,Playfair Display SC,Podkova,Poiret One,Poller One,Poly,Pompiere,Pontano Sans,Port Lligat Sans,Port Lligat Slab,Prata,Preahvihear,Press Start 2P,Princess Sofia,Prociono,Prosto One,Puritan,Purple Purse,Quando,Quantico,Quattrocento,Quattrocento Sans,Questrial,Quicksand,Quintessential,Qwigley,Racing Sans One,Radley,Raleway,Raleway Dots,Rambla,Rammetto One,Ranchers,Rancho,Rationale,Redressed,Reenie Beanie,Revalia,Ribeye,Ribeye Marrow,Righteous,Risque,Roboto,Roboto Condensed,Rochester,Rock Salt,Rokkitt,Romanesco,Ropa Sans,Rosario,Rosarivo,Rouge Script,Ruda,Rufina,Ruge Boogie,Ruluko,Rum Raisin,Ruslan Display,Russo One,Ruthie,Rye,Sacramento,Sail,Salsa,Sanchez,Sancreek,Sansita One,Sarina,Satisfy,Scada,Schoolbell,Seaweed Script,Sevillana,Seymour One,Shadows Into Light,Shadows Into Light Two,Shanti,Share,Share Tech,Share Tech Mono,Shojumaru,Short Stack,Siemreap,Sigmar One,Signika,Signika Negative,Simonetta,Sirin Stencil,Six Caps,Skranji,Slackey,Smokum,Smythe,Sniglet,Snippet,Snowburst One,Sofadi One,Sofia,Sonsie One,Sorts Mill Goudy,Source Code Pro,Source Sans Pro,Special Elite,Spicy Rice,Spinnaker,Spirax,Squada One,Stalemate,Stalinist One,Stardos Stencil,Stint Ultra Condensed,Stint Ultra Expanded,Stoke,Strait,Sue Ellen Francisco,Sunshiney,Supermercado One,Suwannaphum,Swanky and Moo Moo,Syncopate,Tangerine,Taprom,Telex,Tenor Sans,Text Me One,The Girl Next Door,Tienne,Tinos,Titan One,Titillium Web,Trade Winds,Trocchi,Trochut,Trykker,Tulpen One,Ubuntu,Ubuntu Condensed,Ubuntu Mono,Ultra,Uncial Antiqua,Underdog,Unica One,UnifrakturCook,UnifrakturMaguntia,Unkempt,Unlock,Unna,VT323,Vampiro One,Varela,Varela Round,Vast Shadow,Vibur,Vidaloka,Viga,Voces,Volkhov,Vollkorn,Voltaire,Waiting for the Sunrise,Wallpoet,Walter Turncoat,Warnes,Wellfleet,Wendy One,Wire One,Yanone Kaffeesatz,Yellowtail,Yeseva One,Yesteryear,Zeyada';
	
	public function __construct($parent_slug = '')
	{
		
		$this->setPageTitle('General');
		$this->setMenuTitle('General');
		$this->setCapability('administrator');
		$this->setMenuSlug(SHORTNAME.'_general');
		parent::__construct($parent_slug);
		$this->init();
	}

	public function init()
	{
		
		$option = new Admin_Theme_Element_Pagetitle();
		$option->setName('General Settings');
		$this->addOption($option);
		$option = null;		
		
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Post background color')
					->setDescription('Choose your custom post background color.')
					->setId( SHORTNAME."_post_background_color")
					->setStd('#ffffff');
			$this->addOption($option);
		
		
		
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
		
		
		$option = new Admin_Theme_Element_Select_Wide();
		$option->setName('Choose a Font')
				->setDescription('Choose a Font for titles, etc.')
				->setId(SHORTNAME."_gfont")
				->setStd('Open Sans')
				->setCustomized()					// Show this element on WP Customize Admin menu
				->setOptions($this->getFonts());
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setDescription ('Disable Google fonts')
				->setName ('Check to disable Google fonts.')
				->setCustomized()					// Show this element on WP Customize Admin menu
				->setId (SHORTNAME."_gfontdisable");
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
		
		
				$option = new Admin_Theme_Element_Select_Wide();
				$option->setName('Choose a font family for content')
						->setDescription('Choose a font family for content')
						->setId(SHORTNAME."_fontfamily")
						->setStd("Arial, serif")
						->setOptions(array("Arial, Helvetica, sans-serif", "'Times New Roman', Times, serif",  "'Courier New', Courier, monospace", "Georgia, 'Times New Roman', Times, serif","Verdana, Arial, Helvetica, sans-serif","Geneva, Arial, Helvetica, sans-serif"));
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Select_Wide();
				$option->setName('Choose a font style for content')
						->setDescription('Choose a font style for content')
						->setId(SHORTNAME."_fontstyle")
						->setStd('normal')
						->setOptions(array("italic", "normal"));
				$this->addOption($option);
				$option = null;
	
				
				$option = new Admin_Theme_Element_Separator();
				$this->addOption($option);
				$option = null;

				$option = new Admin_Theme_Element_Checkbox();
				$option->setName(__('Hide date and social icons area at the bottom of post/page','liquidfolio'))
						->setDescription(__('Check to hide post meta for blog posts, gallery posts and pages','liquidfolio'))
						->setId(SHORTNAME."_postmetashow");
				$this->addOption($option);
				$option = null;

				$option = new Admin_Theme_Element_Separator();
				$this->addOption($option);
				$option = null;		
		
				$option = new Admin_Theme_Element_File_Favicon();
				$option->setName('Favicon')
						->setDescription('Click upload button, then choose and upload your favicon file')
						->setId(SHORTNAME."_favicon")
						->setStd(get_template_directory_uri().'/images/favicon.ico');
				$this->addOption($option);
				$option = null;
				
				$option = new Admin_Theme_Element_Separator();
				$this->addOption($option);
				$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName(__('Map types','liquidfolio'))
				->setDescription(__('Allow your readers to change the map type (street, satellite, or hybrid)','liquidfolio'))
				->setId(SHORTNAME."_maps_types_switch")
				->setStd('true');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName(__('Scroll wheel zoom','liquidfolio'))
				->setDescription(__('Enable zoom with the mouse scroll wheel','liquidfolio'))
				->setId(SHORTNAME."_maps_weel_zoom")
				->setStd('');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_Checkbox();
		$option->setName(__('Tooltips','liquidfolio'))
				->setDescription(htmlentities(__('Show marker titles as a "tooltip" on mouse-over','liquidfolio')))
				->setId(SHORTNAME."_maps_tooltips")
				->setStd('true');
		$this->addOption($option);
		$option = null;
		
		$option = new Admin_Theme_Element_File();
		$option->setName('Google map location pin')
				->setDescription('You can upload an image for google map location pin.')
				->setId(SHORTNAME."_map_location")
				->setStd(get_template_directory_uri().'/images/ico_lf.png');
		$this->addOption($option);
		$option = null;
		
		
		
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Default page color')
					->setDescription('Select your custom color.')
					->setId( SHORTNAME."_page_color")
					->setStd("#363636");
			$this->addOption($option);
			
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content background color')
					->setDescription('Select your custom color for all elements on light background.')
					->setId( SHORTNAME."_content_background_color")
					->setStd("#f5f5f5");
			$this->addOption($option);
			
			$option = new Admin_Theme_Element_File();
			$option->setName('Content background image')
					->setDescription('You can upload custom pattern image.')
					->setId(SHORTNAME."_content_pattern")
					->setStd(get_template_directory_uri().'/images/content_bg.png');
			$this->addOption($option);
			$option = null;	
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Content background repeat')
					->setDescription('Custom pattern repeat settings')
					->setId(SHORTNAME."_content_pattern_repeat")
					->setStd('no-repeat')
					->setOptions(array('repeat','no-repeat','repeat-x','repeat-y'));
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Content background attachment')
					->setDescription('Custom pattern attachment settings')
					->setId(SHORTNAME."_content_attachment")
					->setStd('fixed')
					->setOptions(array('fixed','scroll','inherit'));
			$this->addOption($option);
			$option = null;
			
			$option = new Admin_Theme_Element_Select();
			$option->setName('Content background horizontal position')
					->setDescription('Custom pattern horizontal position')
					->setId(SHORTNAME."_content_pattern_x")
					->setStd('right')
					->setOptions(array('left','right','center'));
			$this->addOption($option);
			$option = null;
			
					$option = new Admin_Theme_Element_Select();
			$option->setName('Content background vertical')
					->setDescription('Custom pattern vertical position')
					->setId(SHORTNAME."_content_pattern_y")
					->setStd('0px')
					->setOptions(array('top','bottom','middle'));
			$this->addOption($option);
			$option = null;
		
		
		$option = new Admin_Theme_Element_Separator();
		$this->addOption($option);
		$option = null;
		
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content text color')
					->setDescription('Select your custom font color on your page.')
					->setId( SHORTNAME."_textcolor")
					->setStd("#545454");
			$this->addOption($option);

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content headings color')
					->setDescription('Select your custom color for your headings and all elements on dark background.')
					->setId(SHORTNAME."_headingscolor")
					->setStd('#363636');
			$this->addOption($option);

			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content links color')
					->setDescription('Select your custom color for your links and all elements on dark background.')
					->setId(SHORTNAME."_linkscolor")
					->setStd('#000000');
			$this->addOption($option);
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Content links hover color')
					->setDescription('Select your custom color for all links in hover state.')
					->setId(SHORTNAME."_linkscolor_hover")
					->setStd('#545454');
			$this->addOption($option);		
		
			
			$option = new Admin_Theme_Element_Colorchooser();
			$option->setName('Accent color')
					->setDescription('Select your custom color for accented elements.')
					->setId(SHORTNAME . '_accent_color')
					->setStd('#A05FEF');
			$this->addOption($option);
		if (isset($_GET['preview']))
		{
			$option = new Admin_Theme_Element_Checkbox();
			$option->setName('Show preview switcher')
					->setDescription('Check to show preview color switcher')
					->setId(SHORTNAME."_preview")
					->setStd('');
			$this->addOption($option);
			$option = null;
		}	
	}
	
	/**
	 * Fonts list
	 * @return array
	 */
	private function getFonts()
	{
		return explode(',', self::FONT_LIST);
	}
}
?>
