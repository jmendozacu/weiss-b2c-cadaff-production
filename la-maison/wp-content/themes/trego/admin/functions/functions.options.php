<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		
		$google_fonts = array('' => 'Default',
			'arial'=>'Arial',
			'verdana'=>'Verdana, Geneva',
			'trebuchet'=>'Trebuchet MS',
			'georgia' =>'Georgia',
			'times'=>'Times New Roman',
			'tahoma'=>'Tahoma, Geneva',
			'helvetica'=>'Helvetica',
			'Abel' => 'Abel',
			'Abril Fatface' => 'Abril Fatface',
			'Aclonica' => 'Aclonica',
			'Acme' => 'Acme',
			'Actor' => 'Actor',
			'Adamina' => 'Adamina',
			'Advent Pro' => 'Advent Pro',
			'Aguafina Script' => 'Aguafina Script',
			'Aladin' => 'Aladin',
			'Aldrich' => 'Aldrich',
			'Alegreya' => 'Alegreya',
			'Alegreya SC' => 'Alegreya SC',
			'Alex Brush' => 'Alex Brush',
			'Alfa Slab One' => 'Alfa Slab One',
			'Alice' => 'Alice',
			'Alike' => 'Alike',
			'Alike Angular' => 'Alike Angular',
			'Allan' => 'Allan',
			'Allerta' => 'Allerta',
			'Allerta Stencil' => 'Allerta Stencil',
			'Allura' => 'Allura',
			'Almendra' => 'Almendra',
			'Almendra SC' => 'Almendra SC',
			'Amaranth' => 'Amaranth',
			'Amatic SC' => 'Amatic SC',
			'Amethysta' => 'Amethysta',
			'Andada' => 'Andada',
			'Andika' => 'Andika',
			'Angkor' => 'Angkor',
			'Annie Use Your Telescope' => 'Annie Use Your Telescope',
			'Anonymous Pro' => 'Anonymous Pro',
			'Antic' => 'Antic',
			'Antic Didone' => 'Antic Didone',
			'Antic Slab' => 'Antic Slab',
			'Anton' => 'Anton',
			'Arapey' => 'Arapey',
			'Arbutus' => 'Arbutus',
			'Architects Daughter' => 'Architects Daughter',
			'Arimo' => 'Arimo',
			'Arizonia' => 'Arizonia',
			'Armata' => 'Armata',
			'Artifika' => 'Artifika',
			'Arvo' => 'Arvo',
			'Asap' => 'Asap',
			'Asset' => 'Asset',
			'Astloch' => 'Astloch',
			'Asul' => 'Asul',
			'Atomic Age' => 'Atomic Age',
			'Aubrey' => 'Aubrey',
			'Audiowide' => 'Audiowide',
			'Average' => 'Average',
			'Averia Gruesa Libre' => 'Averia Gruesa Libre',
			'Averia Libre' => 'Averia Libre',
			'Averia Sans Libre' => 'Averia Sans Libre',
			'Averia Serif Libre' => 'Averia Serif Libre',
			'Bad Script' => 'Bad Script',
			'Balthazar' => 'Balthazar',
			'Bangers' => 'Bangers',
			'Basic' => 'Basic',
			'Battambang' => 'Battambang',
			'Baumans' => 'Baumans',
			'Bayon' => 'Bayon',
			'Belgrano' => 'Belgrano',
			'Belleza' => 'Belleza',
			'Bentham' => 'Bentham',
			'Berkshire Swash' => 'Berkshire Swash',
			'Bevan' => 'Bevan',
			'Bigshot One' => 'Bigshot One',
			'Bilbo' => 'Bilbo',
			'Bilbo Swash Caps' => 'Bilbo Swash Caps',
			'Bitter' => 'Bitter',
			'Black Ops One' => 'Black Ops One',
			'Bokor' => 'Bokor',
			'Bonbon' => 'Bonbon',
			'Boogaloo' => 'Boogaloo',
			'Bowlby One' => 'Bowlby One',
			'Bowlby One SC' => 'Bowlby One SC',
			'Brawler' => 'Brawler',
			'Bree Serif' => 'Bree Serif',
			'Bubblegum Sans' => 'Bubblegum Sans',
			'Buda' => 'Buda',
			'Buenard' => 'Buenard',
			'Butcherman' => 'Butcherman',
			'Butterfly Kids' => 'Butterfly Kids',
			'Cabin' => 'Cabin',
			'Cabin Condensed' => 'Cabin Condensed',
			'Cabin Sketch' => 'Cabin Sketch',
			'Caesar Dressing' => 'Caesar Dressing',
			'Cagliostro' => 'Cagliostro',
			'Calligraffitti' => 'Calligraffitti',
			'Cambo' => 'Cambo',
			'Candal' => 'Candal',
			'Cantarell' => 'Cantarell',
			'Cantata One' => 'Cantata One',
			'Cardo' => 'Cardo',
			'Carme' => 'Carme',
			'Carter One' => 'Carter One',
			'Caudex' => 'Caudex',
			'Cedarville Cursive' => 'Cedarville Cursive',
			'Ceviche One' => 'Ceviche One',
			'Changa One' => 'Changa One',
			'Chango' => 'Chango',
			'Chau Philomene One' => 'Chau Philomene One',
			'Chelsea Market' => 'Chelsea Market',
			'Chenla' => 'Chenla',
			'Cherry Cream Soda' => 'Cherry Cream Soda',
			'Chewy' => 'Chewy',
			'Chicle' => 'Chicle',
			'Chivo' => 'Chivo',
			'Coda' => 'Coda',
			'Coda Caption' => 'Coda Caption',
			'Codystar' => 'Codystar',
			'Comfortaa' => 'Comfortaa',
			'Coming Soon' => 'Coming Soon',
			'Concert One' => 'Concert One',
			'Condiment' => 'Condiment',
			'Content' => 'Content',
			'Contrail One' => 'Contrail One',
			'Convergence' => 'Convergence',
			'Cookie' => 'Cookie',
			'Copse' => 'Copse',
			'Corben' => 'Corben',
			'Cousine' => 'Cousine',
			'Coustard' => 'Coustard',
			'Covered By Your Grace' => 'Covered By Your Grace',
			'Crafty Girls' => 'Crafty Girls',
			'Creepster' => 'Creepster',
			'Crete Round' => 'Crete Round',
			'Crimson Text' => 'Crimson Text',
			'Crushed' => 'Crushed',
			'Cuprum' => 'Cuprum',
			'Cutive' => 'Cutive',
			'Damion' => 'Damion',
			'Dancing Script' => 'Dancing Script',
			'Dangrek' => 'Dangrek',
			'Dawning of a New Day' => 'Dawning of a New Day',
			'Days One' => 'Days One',
			'Delius' => 'Delius',
			'Delius Swash Caps' => 'Delius Swash Caps',
			'Delius Unicase' => 'Delius Unicase',
			'Della Respira' => 'Della Respira',
			'Devonshire' => 'Devonshire',
			'Didact Gothic' => 'Didact Gothic',
			'Diplomata' => 'Diplomata',
			'Diplomata SC' => 'Diplomata SC',
			'Doppio One' => 'Doppio One',
			'Dorsa' => 'Dorsa',
			'Dosis' => 'Dosis',
			'Dr Sugiyama' => 'Dr Sugiyama',
			'Droid Sans' => 'Droid Sans',
			'Droid Sans Mono' => 'Droid Sans Mono',
			'Droid Serif' => 'Droid Serif',
			'Duru Sans' => 'Duru Sans',
			'Dynalight' => 'Dynalight',
			'EB Garamond' => 'EB Garamond',
			'Eater' => 'Eater',
			'Economica' => 'Economica',
			'Electrolize' => 'Electrolize',
			'Emblema One' => 'Emblema One',
			'Emilys Candy' => 'Emilys Candy',
			'Engagement' => 'Engagement',
			'Enriqueta' => 'Enriqueta',
			'Erica One' => 'Erica One',
			'Esteban' => 'Esteban',
			'Euphoria Script' => 'Euphoria Script',
			'Ewert' => 'Ewert',
			'Exo' => 'Exo',
			'Expletus Sans' => 'Expletus Sans',
			'Fanwood Text' => 'Fanwood Text',
			'Fascinate' => 'Fascinate',
			'Fascinate Inline' => 'Fascinate Inline',
			'Federant' => 'Federant',
			'Federo' => 'Federo',
			'Felipa' => 'Felipa',
			'Fjord One' => 'Fjord One',
			'Flamenco' => 'Flamenco',
			'Flavors' => 'Flavors',
			'Fondamento' => 'Fondamento',
			'Fontdiner Swanky' => 'Fontdiner Swanky',
			'Forum' => 'Forum',
			'Fjalla One' => 'Fjalla One',
			'Francois One' => 'Francois One',
			'Fredericka the Great' => 'Fredericka the Great',
			'Fredoka One' => 'Fredoka One',
			'Freehand' => 'Freehand',
			'Fresca' => 'Fresca',
			'Frijole' => 'Frijole',
			'Fugaz One' => 'Fugaz One',
			'GFS Didot' => 'GFS Didot',
			'GFS Neohellenic' => 'GFS Neohellenic',
			'Galdeano' => 'Galdeano',
			'Gentium Basic' => 'Gentium Basic',
			'Gentium Book Basic' => 'Gentium Book Basic',
			'Geo' => 'Geo',
			'Geostar' => 'Geostar',
			'Geostar Fill' => 'Geostar Fill',
			'Germania One' => 'Germania One',
			'Gilda Display' => 'Gilda Display',
			'Give You Glory' => 'Give You Glory',
			'Glass Antiqua' => 'Glass Antiqua',
			'Glegoo' => 'Glegoo',
			'Gloria Hallelujah' => 'Gloria Hallelujah',
			'Goblin One' => 'Goblin One',
			'Gochi Hand' => 'Gochi Hand',
			'Gorditas' => 'Gorditas',
			'Goudy Bookletter 1911' => 'Goudy Bookletter 1911',
			'Graduate' => 'Graduate',
			'Gravitas One' => 'Gravitas One',
			'Great Vibes' => 'Great Vibes',
			'Gruppo' => 'Gruppo',
			'Gudea' => 'Gudea',
			'Habibi' => 'Habibi',
			'Hammersmith One' => 'Hammersmith One',
			'Handlee' => 'Handlee',
			'Hanuman' => 'Hanuman',
			'Happy Monkey' => 'Happy Monkey',
			'Henny Penny' => 'Henny Penny',
			'Herr Von Muellerhoff' => 'Herr Von Muellerhoff',
			'Holtwood One SC' => 'Holtwood One SC',
			'Homemade Apple' => 'Homemade Apple',
			'Homenaje' => 'Homenaje',
			'IM Fell DW Pica' => 'IM Fell DW Pica',
			'IM Fell DW Pica SC' => 'IM Fell DW Pica SC',
			'IM Fell Double Pica' => 'IM Fell Double Pica',
			'IM Fell Double Pica SC' => 'IM Fell Double Pica SC',
			'IM Fell English' => 'IM Fell English',
			'IM Fell English SC' => 'IM Fell English SC',
			'IM Fell French Canon' => 'IM Fell French Canon',
			'IM Fell French Canon SC' => 'IM Fell French Canon SC',
			'IM Fell Great Primer' => 'IM Fell Great Primer',
			'IM Fell Great Primer SC' => 'IM Fell Great Primer SC',
			'Iceberg' => 'Iceberg',
			'Iceland' => 'Iceland',
			'Imprima' => 'Imprima',
			'Inconsolata' => 'Inconsolata',
			'Inder' => 'Inder',
			'Indie Flower' => 'Indie Flower',
			'Inika' => 'Inika',
			'Irish Grover' => 'Irish Grover',
			'Istok Web' => 'Istok Web',
			'Italiana' => 'Italiana',
			'Italianno' => 'Italianno',
			'Jim Nightshade' => 'Jim Nightshade',
			'Jockey One' => 'Jockey One',
			'Jolly Lodger' => 'Jolly Lodger',
			'Josefin Sans' => 'Josefin Sans',
			'Josefin Slab' => 'Josefin Slab',
			'Judson' => 'Judson',
			'Julee' => 'Julee',
			'Junge' => 'Junge',
			'Jura' => 'Jura',
			'Just Another Hand' => 'Just Another Hand',
			'Just Me Again Down Here' => 'Just Me Again Down Here',
			'Kameron' => 'Kameron',
			'Karla' => 'Karla',
			'Kaushan Script' => 'Kaushan Script',
			'Kelly Slab' => 'Kelly Slab',
			'Kenia' => 'Kenia',
			'Khmer' => 'Khmer',
			'Knewave' => 'Knewave',
			'Kotta One' => 'Kotta One',
			'Koulen' => 'Koulen',
			'Kranky' => 'Kranky',
			'Kreon' => 'Kreon',
			'Kristi' => 'Kristi',
			'Krona One' => 'Krona One',
			'La Belle Aurore' => 'La Belle Aurore',
			'Lancelot' => 'Lancelot',
			'Lato' => 'Lato',
			'League Script' => 'League Script',
			'Leckerli One' => 'Leckerli One',
			'Ledger' => 'Ledger',
			'Lekton' => 'Lekton',
			'Lemon' => 'Lemon',
			'Lilita One' => 'Lilita One',
			'Limelight' => 'Limelight',
			'Linden Hill' => 'Linden Hill',
			'Lobster' => 'Lobster',
			'Lobster Two' => 'Lobster Two',
			'Londrina Outline' => 'Londrina Outline',
			'Londrina Shadow' => 'Londrina Shadow',
			'Londrina Sketch' => 'Londrina Sketch',
			'Londrina Solid' => 'Londrina Solid',
			'Lora' => 'Lora',
			'Love Ya Like A Sister' => 'Love Ya Like A Sister',
			'Loved by the King' => 'Loved by the King',
			'Lovers Quarrel' => 'Lovers Quarrel',
			'Luckiest Guy' => 'Luckiest Guy',
			'Lusitana' => 'Lusitana',
			'Lustria' => 'Lustria',
			'Macondo' => 'Macondo',
			'Macondo Swash Caps' => 'Macondo Swash Caps',
			'Magra' => 'Magra',
			'Maiden Orange' => 'Maiden Orange',
			'Mako' => 'Mako',
			'Marcellus' => 'Marcellus',
			'Marcellus SC' => 'Marcellus SC',
			'Marck Script' => 'Marck Script',
			'Marko One' => 'Marko One',
			'Marmelad' => 'Marmelad',
			'Marvel' => 'Marvel',
			'Mate' => 'Mate',
			'Mate SC' => 'Mate SC',
			'Maven Pro' => 'Maven Pro',
			'Meddon' => 'Meddon',
			'MedievalSharp' => 'MedievalSharp',
			'Medula One' => 'Medula One',
			'Megrim' => 'Megrim',
			'Merienda One' => 'Merienda One',
			'Merriweather' => 'Merriweather',
			'Metal' => 'Metal',
			'Metamorphous' => 'Metamorphous',
			'Metrophobic' => 'Metrophobic',
			'Michroma' => 'Michroma',
			'Miltonian' => 'Miltonian',
			'Miltonian Tattoo' => 'Miltonian Tattoo',
			'Miniver' => 'Miniver',
			'Miss Fajardose' => 'Miss Fajardose',
			'Modern Antiqua' => 'Modern Antiqua',
			'Molengo' => 'Molengo',
			'Monofett' => 'Monofett',
			'Monoton' => 'Monoton',
			'Monsieur La Doulaise' => 'Monsieur La Doulaise',
			'Montaga' => 'Montaga',
			'Montez' => 'Montez',
			'Montserrat' => 'Montserrat',
			'Montserrat Alternates' => 'Montserrat Alternates',
			'Montserrat Subrayada' => 'Montserrat Subrayada',
			'Moul' => 'Moul',
			'Moulpali' => 'Moulpali',
			'Mountains of Christmas' => 'Mountains of Christmas',
			'Mr Bedfort' => 'Mr Bedfort',
			'Mr Dafoe' => 'Mr Dafoe',
			'Mr De Haviland' => 'Mr De Haviland',
			'Mrs Saint Delafield' => 'Mrs Saint Delafield',
			'Mrs Sheppards' => 'Mrs Sheppards',
			'Muli' => 'Muli',
			'Mystery Quest' => 'Mystery Quest',
			'Neucha' => 'Neucha',
			'Neuton' => 'Neuton',
			'News Cycle' => 'News Cycle',
			'Niconne' => 'Niconne',
			'Nixie One' => 'Nixie One',
			'Nobile' => 'Nobile',
			'Nokora' => 'Nokora',
			'Norican' => 'Norican',
			'Nosifer' => 'Nosifer',
			'Nothing You Could Do' => 'Nothing You Could Do',
			'Noticia Text' => 'Noticia Text',
			'Noto Sans' => 'Noto Sans',
			'Nova Cut' => 'Nova Cut',
			'Nova Flat' => 'Nova Flat',
			'Nova Mono' => 'Nova Mono',
			'Nova Oval' => 'Nova Oval',
			'Nova Round' => 'Nova Round',
			'Nova Script' => 'Nova Script',
			'Nova Slim' => 'Nova Slim',
			'Nova Square' => 'Nova Square',
			'Numans' => 'Numans',
			'Nunito' => 'Nunito',
			'Odor Mean Chey' => 'Odor Mean Chey',
			'Old Standard TT' => 'Old Standard TT',
			'Oldenburg' => 'Oldenburg',
			'Oleo Script' => 'Oleo Script',
			'Open Sans' => 'Open Sans',
			'Open Sans Condensed' => 'Open Sans Condensed',
			'Orbitron' => 'Orbitron',
			'Original Surfer' => 'Original Surfer',
			'Oswald' => 'Oswald',
			'Over the Rainbow' => 'Over the Rainbow',
			'Overlock' => 'Overlock',
			'Overlock SC' => 'Overlock SC',
			'Ovo' => 'Ovo',
			'Oxygen' => 'Oxygen',
			'PT Mono' => 'PT Mono',
			'PT Sans' => 'PT Sans',
			'PT Sans Caption' => 'PT Sans Caption',
			'PT Sans Narrow' => 'PT Sans Narrow',
			'PT Serif' => 'PT Serif',
			'PT Serif Caption' => 'PT Serif Caption',
			'Pacifico' => 'Pacifico',
			'Parisienne' => 'Parisienne',
			'Passero One' => 'Passero One',
			'Passion One' => 'Passion One',
			'Patrick Hand' => 'Patrick Hand',
			'Patua One' => 'Patua One',
			'Paytone One' => 'Paytone One',
			'Permanent Marker' => 'Permanent Marker',
			'Petrona' => 'Petrona',
			'Philosopher' => 'Philosopher',
			'Piedra' => 'Piedra',
			'Pinyon Script' => 'Pinyon Script',
			'Plaster' => 'Plaster',
			'Play' => 'Play',
			'Playball' => 'Playball',
			'Playfair Display' => 'Playfair Display',
			'Podkova' => 'Podkova',
			'Poiret One' => 'Poiret One',
			'Poller One' => 'Poller One',
			'Poly' => 'Poly',
			'Pompiere' => 'Pompiere',
			'Pontano Sans' => 'Pontano Sans',
			'Port Lligat Sans' => 'Port Lligat Sans',
			'Port Lligat Slab' => 'Port Lligat Slab',
			'Prata' => 'Prata',
			'Preahvihear' => 'Preahvihear',
			'Press Start 2P' => 'Press Start 2P',
			'Princess Sofia' => 'Princess Sofia',
			'Prociono' => 'Prociono',
			'Prosto One' => 'Prosto One',
			'Puritan' => 'Puritan',
			'Quantico' => 'Quantico',
			'Quattrocento' => 'Quattrocento',
			'Quattrocento Sans' => 'Quattrocento Sans',
			'Questrial' => 'Questrial',
			'Quicksand' => 'Quicksand',
			'Qwigley' => 'Qwigley',
			'Radley' => 'Radley',
			'Raleway' => 'Raleway',
			'Rammetto One' => 'Rammetto One',
			'Rancho' => 'Rancho',
			'Rationale' => 'Rationale',
			'Redressed' => 'Redressed',
			'Reenie Beanie' => 'Reenie Beanie',
			'Revalia' => 'Revalia',
			'Ribeye' => 'Ribeye',
			'Ribeye Marrow' => 'Ribeye Marrow',
			'Righteous' => 'Righteous',
			'Roboto' => 'Roboto',
			'Roboto Sans' => 'Roboto Sans',
			'Rochester' => 'Rochester',
			'Rock Salt' => 'Rock Salt',
			'Rokkitt' => 'Rokkitt',
			'Ropa Sans' => 'Ropa Sans',
			'Rosario' => 'Rosario',
			'Rosarivo' => 'Rosarivo',
			'Rouge Script' => 'Rouge Script',
			'Ruda' => 'Ruda',
			'Ruge Boogie' => 'Ruge Boogie',
			'Ruluko' => 'Ruluko',
			'Ruslan Display' => 'Ruslan Display',
			'Russo One' => 'Russo One',
			'Ruthie' => 'Ruthie',
			'Sacramento' => 'Sacramento',
			'Sail' => 'Sail',
			'Salsa' => 'Salsa',
			'Sancreek' => 'Sancreek',
			'Sansita One' => 'Sansita One',
			'Sarina' => 'Sarina',
			'Satisfy' => 'Satisfy',
			'Schoolbell' => 'Schoolbell',
			'Seaweed Script' => 'Seaweed Script',
			'Sevillana' => 'Sevillana',
			'Seymour One' => 'Seymour One',
			'Shadows Into Light' => 'Shadows Into Light',
			'Shadows Into Light Two' => 'Shadows Into Light Two',
			'Shanti' => 'Shanti',
			'Share' => 'Share',
			'Shojumaru' => 'Shojumaru',
			'Short Stack' => 'Short Stack',
			'Siemreap' => 'Siemreap',
			'Sigmar One' => 'Sigmar One',
			'Signika' => 'Signika',
			'Signika Negative' => 'Signika Negative',
			'Simonetta' => 'Simonetta',
			'Sirin Stencil' => 'Sirin Stencil',
			'Six Caps' => 'Six Caps',
			'Slackey' => 'Slackey',
			'Smokum' => 'Smokum',
			'Smythe' => 'Smythe',
			'Sniglet' => 'Sniglet',
			'Snippet' => 'Snippet',
			'Sofia' => 'Sofia',
			'Sonsie One' => 'Sonsie One',
			'Sorts Mill Goudy' => 'Sorts Mill Goudy',
			'Special Elite' => 'Special Elite',
			'Spicy Rice' => 'Spicy Rice',
			'Spinnaker' => 'Spinnaker',
			'Spirax' => 'Spirax',
			'Squada One' => 'Squada One',
			'Stardos Stencil' => 'Stardos Stencil',
			'Stint Ultra Condensed' => 'Stint Ultra Condensed',
			'Stint Ultra Expanded' => 'Stint Ultra Expanded',
			'Stoke' => 'Stoke',
			'Sue Ellen Francisco' => 'Sue Ellen Francisco',
			'Sunshiney' => 'Sunshiney',
			'Supermercado One' => 'Supermercado One',
			'Suwannaphum' => 'Suwannaphum',
			'Swanky and Moo Moo' => 'Swanky and Moo Moo',
			'Syncopate' => 'Syncopate',
			'Tangerine' => 'Tangerine',
			'Taprom' => 'Taprom',
			'Telex' => 'Telex',
			'Tenor Sans' => 'Tenor Sans',
			'The Girl Next Door' => 'The Girl Next Door',
			'Tienne' => 'Tienne',
			'Tinos' => 'Tinos',
			'Titan One' => 'Titan One',
			'Titillium Web' => 'Titillium Web',
			'Trade Winds' => 'Trade Winds',
			'Trocchi' => 'Trocchi',
			'Trochut' => 'Trochut',
			'Trykker' => 'Trykker',
			'Tulpen One' => 'Tulpen One',
			'Ubuntu' => 'Ubuntu',
			'Ubuntu Condensed' => 'Ubuntu Condensed',
			'Ubuntu Mono' => 'Ubuntu Mono',
			'Ultra' => 'Ultra',
			'Uncial Antiqua' => 'Uncial Antiqua',
			'UnifrakturCook' => 'UnifrakturCook',
			'UnifrakturMaguntia' => 'UnifrakturMaguntia',
			'Unkempt' => 'Unkempt',
			'Unlock' => 'Unlock',
			'Unna' => 'Unna',
			'VT323' => 'VT323',
			'Varela' => 'Varela',
			'Varela Round' => 'Varela Round',
			'Vast Shadow' => 'Vast Shadow',
			'Vibur' => 'Vibur',
			'Vidaloka' => 'Vidaloka',
			'Viga' => 'Viga',
			'Voces' => 'Voces',
			'Volkhov' => 'Volkhov',
			'Vollkorn' => 'Vollkorn',
			'Voltaire' => 'Voltaire',
			'Waiting for the Sunrise' => 'Waiting for the Sunrise',
			'Wallpoet' => 'Wallpoet',
			'Walter Turncoat' => 'Walter Turncoat',
			'Wellfleet' => 'Wellfleet',
			'Wire One' => 'Wire One',
			'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
			'Yellowtail' => 'Yellowtail',
			'Yeseva One' => 'Yeseva One',
			'Yesteryear' => 'Yesteryear',
			'Zeyada' => 'Zeyada'
		);

		$background = array(
			'' => 'Default',
			'1' => '1.png',
			'2' => '2.png',
			'3' => '3.png',
			'4' => '4.png',
			'5' => '5.png',
			'6' => '6.png',
			'7' => '7.png',
			'8' => '8.png',
			'9' => '9.png',
			'10' => '10.png',
			'11' => '11.png',
			'12' => '12.png',
			'13' => '13.png',
			'14' => '14.png',
			'15' => '15.png',
			'16' => '16.png',
		);


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();


// GENERAL //

$of_options[] = array( 	"name" 		=> "Header",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Logo",
						"desc" 		=> "Upload logo here.",
						"id" 		=> "site_logo",
						"std" 		=> get_template_directory_uri().'/images/logo.png',
						"type" 		=> "media"
);

$of_options[] = array( 	"name" 		=> "Logo (only Gallery Template)",
						"desc" 		=> "Upload logo here.",
						"id" 		=> "site_logo2",
						"std" 		=> get_template_directory_uri().'/images/logo.png',
						"type" 		=> "media"
);

$of_options[] = array( 	"name" 		=> "Favicon",
						"desc" 		=> "Add your custom Favicon image. 16x16px .ico or .png file required.",
						"id" 		=> "site_favicon",
						"std" 		=> get_template_directory_uri() . '/favicon.ico',
						"type" 		=> "media"
);

$of_options[] = array( 	"name" 		=> "Disable Mini Menu",
						"desc" 		=> "If you select 'no', then the dropdown menu is used when window height is smaller than 800px",
						"id" 		=> "mini_menu",
						"std" 		=> 1,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);


$of_options[] = array( 	"name" 		=> "Disable Search Form",
						"desc" 		=> "",
						"id" 		=> "disable_search_form",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);

$of_options[] = array( 	"name" 		=> "Disable Special Product Menu",
						"desc" 		=> "If you select 'yes', then special product menu is hidden",
						"id" 		=> "disable_special_product_menu",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);

$of_options[] = array( 	"name" 		=> "Footer",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Copyright Text",
						"desc" 		=> "",
						"id" 		=> "copyright",
						"std" 		=> "2013 Trego. All Rights reserved.",
						"type" 		=> "textarea"
);

$of_options[] = array( 	"name" 		=> "Contact Address (One Page Template)",
						"desc" 		=> "",
						"id" 		=> "contact_address",
						"std" 		=> "",
						"type" 		=> "textarea"
);

$of_options[] = array( 	"name" 		=> "Phone (One Page Template)",
						"desc" 		=> "",
						"id" 		=> "contact_phone",
						"std" 		=> "",
						"type" 		=> "textarea"
);

$of_options[] = array( 	"name" 		=> "E-mail (One Page Template)",
						"desc" 		=> "",
						"id" 		=> "contact_email",
						"std" 		=> "",
						"type" 		=> "textarea"
);

// TYPE 
$of_options[] = array( 	"name" 		=> "Font Style",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Primary Font",
						"desc" 		=> "",
						"id" 		=> "font_primary",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Heading Font",
						"desc" 		=> "",
						"id" 		=> "font_head",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Menu Font",
						"desc" 		=> "",
						"id" 		=> "font_menu",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Button Font",
						"desc" 		=> "",
						"id" 		=> "font_button",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Price Font 1",
						"desc" 		=> "",
						"id" 		=> "font_price_1",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Price Font 2",
						"desc" 		=> "",
						"id" 		=> "font_price_2",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Widget Title Font",
						"desc" 		=> "",
						"id" 		=> "font_widget_title",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Title Font 1",
						"desc" 		=> "",
						"id" 		=> "font_title_1",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Title Font 2",
						"desc" 		=> "",
						"id" 		=> "font_title_2",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Other Font 1",
						"desc" 		=> "",
						"id" 		=> "font_other_1",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Other Font 2",
						"desc" 		=> "",
						"id" 		=> "font_other_2",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Other Font 3",
						"desc" 		=> "",
						"id" 		=> "font_other_3",
						"std" 		=> "",
						"type" 		=> "select_google_font",
						"preview" 	=> array(
										"text" => "<strong>THIS TEXT IS IN UPPERCASE.</strong><br>This text is in lowercase.",
										"size" => "16px"
						),
						"options" 	=>  $google_fonts
);

$of_options[] = array( 	"name" 		=> "Font Color",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Primary Font Color",
						"desc" 		=> "",
						"id" 		=> "font_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Secondary Font Color",
						"desc" 		=> "",
						"id" 		=> "font_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Link Color",
						"desc" 		=> "",
						"id" 		=> "link_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Link Hover Color",
						"desc" 		=> "",
						"id" 		=> "link_hover_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Color 1",
						"desc" 		=> "",
						"id" 		=> "button_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Hover Color 1",
						"desc" 		=> "",
						"id" 		=> "button_hover_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Color 2",
						"desc" 		=> "",
						"id" 		=> "button_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Hover Color 2",
						"desc" 		=> "",
						"id" 		=> "button_hover_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Menu Color",
						"desc" 		=> "",
						"id" 		=> "menu_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "SubMenu Color",
						"desc" 		=> "",
						"id" 		=> "submenu_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Menu Hover Color",
						"desc" 		=> "",
						"id" 		=> "menu_hover_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Placeholder Color",
						"desc" 		=> "",
						"id" 		=> "placeholder_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Price Color 1",
						"desc" 		=> "",
						"id" 		=> "price_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Price Color 2",
						"desc" 		=> "",
						"id" 		=> "price_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Background",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Background Pattern",
						"desc" 		=> "",
						"id" 		=> "bg_pattern",
						"std" 		=> "",
						"type" 		=> "select",
						"options" 	=> $background
);

$of_options[] = array( 	"name" 		=> "Header Background Color",
						"desc" 		=> "",
						"id" 		=> "header_bg_color",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Background Color 1",
						"desc" 		=> "",
						"id" 		=> "bg_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Background Color 2",
						"desc" 		=> "",
						"id" 		=> "bg_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Background Color 3",
						"desc" 		=> "",
						"id" 		=> "bg_color_3",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Background Color 4",
						"desc" 		=> "",
						"id" 		=> "bg_color_4",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Color (Black)",
						"desc" 		=> "",
						"id" 		=> "btn_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Hover Color (Black)",
						"desc" 		=> "",
						"id" 		=> "btn_hover_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Color (Gray)",
						"desc" 		=> "",
						"id" 		=> "btn_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Button Hover Color (Gray)",
						"desc" 		=> "",
						"id" 		=> "btn_hover_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Border Color",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Border Color 1",
						"desc" 		=> "",
						"id" 		=> "border_color_1",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Border Color 2",
						"desc" 		=> "",
						"id" 		=> "border_color_2",
						"std" 		=> "",
						"type" 		=> "color",
);

$of_options[] = array( 	"name" 		=> "Border Color 3",
						"desc" 		=> "",
						"id" 		=> "border_color_3",
						"std" 		=> "",
						"type" 		=> "color",
);

// social links
$of_options[] = array( 	"name" 		=> "Social Links",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Facebook URL",
						"desc" 		=> "",
						"id" 		=> "facebook_link",
						"std" 		=> "http://www.facebook.com",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "Tweet URL",
						"desc" 		=> "",
						"id" 		=> "twitter_link",
						"std" 		=> "http://www.twitter.com",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "Linkedin URL",
						"desc" 		=> "",
						"id" 		=> "linkedin_link",
						"std" 		=> "http://www.linkedin.com",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "Flickr URL",
						"desc" 		=> "",
						"id" 		=> "flickr_link",
						"std" 		=> "http://www.flickr.com",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "Googleplus URL",
						"desc" 		=> "",
						"id" 		=> "googleplus_link",
						"std" 		=> "http://plus.google.com",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "Pinterest URL",
						"desc" 		=> "",
						"id" 		=> "pinterest_link",
						"std" 		=> "",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "YouTube URL",
						"desc" 		=> "",
						"id" 		=> "youtube_link",
						"std" 		=> "",
						"type" 		=> "text"
);
$of_options[] = array( 	"name" 		=> "Instagram URL",
						"desc" 		=> "",
						"id" 		=> "instagram_link",
						"std" 		=> "",
						"type" 		=> "text"
);

// google map
$of_options[] = array( 	"name" 		=> "GoogleMap Setting",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "GoogleMap API Key",
						"desc" 		=> "",
						"id" 		=> "gmap_key",
						"std" 		=> "AIzaSyCaH2tdZkIU8u8CjrZWLunNDKrCbckeuqE",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Map Location Address",
						"desc" 		=> "",
						"id" 		=> "gmap_address",
						"std" 		=> "Trego Store",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Default Zoom",
						"desc" 		=> "",
						"id" 		=> "gmap_zoom",
						"std" 		=> "17",
						"type" 		=> "text"
);


$of_options[] = array( 	"name" 		=> "Default Center Latitude",
						"desc" 		=> "",
						"id" 		=> "gmap_lat",
						"std" 		=> "-34.398",
						"type" 		=> "text"
);


$of_options[] = array( 	"name" 		=> "Default Center Longitude",
						"desc" 		=> "",
						"id" 		=> "gmap_long",
						"std" 		=> "150.884",
						"type" 		=> "text"
);




$of_options[] = array( 	"name" 		=> "Shop Page",
						"type" 		=> "heading"
);


$of_options[] = array( 	"name" 		=> "Category sidebar",
						"desc" 		=> "",
						"id" 		=> "category_sidebar",
						"std" 		=> "none",
						"type" 		=> "select",

						"options" 	=> array(
										"none" => "No sidebar",//please, always use this key: "none"
										"left-sidebar" => "Left sidebar",
										"right-sidebar" => "Right sidebar",

						)
);

$of_options[] = array( 	"name" 		=> "Disable Cloud Zoom on Product Page",
						"desc" 		=> "",
						"id" 		=> "disable_cloud_zoom",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);

$of_options[] = array( 	"name" 		=> "Disable Comments on Product Page",
						"desc" 		=> "",
						"id" 		=> "disable_comments",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);

$of_options[] = array( 	"name" 		=> "Disable Product Tags on Product Page",
						"desc" 		=> "",
						"id" 		=> "disable_product_tags",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);

$of_options[] = array( 	"name" 		=> "Disable Upselling Products on Product Page",
						"desc" 		=> "",
						"id" 		=> "disable_upselling_products",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
);

$of_options[] = array( 	"name" 		=> "Blog Page",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Blog layout",
						"desc" 		=> "Change blog layout",
						"id" 		=> "blog_layout",
						"std" 		=> "right-sidebar",
						"type" 		=> "select",
						"options"   => array("left-sidebar" => "Left sidebar", "right-sidebar" => "Right sidebar", "no-sidebar" => "No sidebar")
);

$of_options[] = array( 	"name" 		=> "Blog header HTML, Image, ShortCode",
						"desc" 		=> "Enter HTML for blog header here. Will be placed above content and sidebar. Shortcodes are allowed. ex [block id='blog-header']",
						"id" 		=> "blog_header",
						"std" 		=> " ",
						"type" 		=> "textarea"
);

$of_options[] = array( 	"name" 		=> "Product Search",
						"desc" 		=> "",
						"id" 		=> "product_search",
						"std" 		=> 1,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Portfolio Page",
						"type" 		=> "heading"
);


$of_options[] = array( 	"name" 		=> "Portfolio Column",
						"desc" 		=> "",
						"id" 		=> "portfolio_column",
						"std" 		=> "three",
						"type" 		=> "select",

						"options" 	=> array(
										"two" => "Two Column",
										"three" => "Three Column",
										"four" => "Four Column",

						)
);

$of_options[] = array( 	"name" 		=> "Portfolio Title",
						"desc" 		=> "",
						"id" 		=> "portfolio_label",
						"std" 		=> "Portfolio",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Show Category",
						"desc" 		=> "",
						"id" 		=> "portfolio_show_category",
						"std" 		=> 1,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Show Title",
						"desc" 		=> "",
						"id" 		=> "portfolio_show_title",
						"std" 		=> 0,
						"on" 		=> "Yes",
						"off" 		=> "No",
						"type" 		=> "switch"
				);

$of_options[] = array( 	"name" 		=> "Custom CSS",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Add custom CSS here",
						"id" 		=> "custom_css",
						"std" 		=> "div {}",
						"type" 		=> "textarea"
);

$of_options[] = array( 	"name" 		=> "Newsletter",
						"type" 		=> "heading"
);

$of_options[] = array( 	"name" 		=> "Form action",
						"desc" 		=> "The attribute \"action\" of the form.",
						"id" 		=> "newsletter_action",
						"std" 		=> "",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Request method",
						"desc" 		=> "The attribute \"method\" of the form. (Default: POST) ",
						"id" 		=> "newsletter_method",
						"std" 		=> "post",
						"type" 		=> "select",
						"options"   => array("post" => "POST", "get" => "GET")
);

$of_options[] = array( 	"name" 		=> "Email field label",
						"desc" 		=> "",
						"id" 		=> "newsletter_email_label",
						"std" 		=> "Sign Up for Our Newsletter:",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Email \"name\"",
						"desc" 		=> "The attribute \"name\" of the email address field.",
						"id" 		=> "newsletter_email_name",
						"std" 		=> "",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Submit button label",
						"desc" 		=> "This field is not always used. Depends on the style of the form.",
						"id" 		=> "newsletter_submit_label",
						"std" 		=> "Submit",
						"type" 		=> "text"
);

$of_options[] = array( 	"name" 		=> "Hidden fields",
						"desc" 		=> "Type here all hidden fields names and values in serializate way. <br>(ex: name1=value1&name2=value2)",
						"id" 		=> "newsletter_hidden",
						"std" 		=> "",
						"type" 		=> "text"
);

// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading",
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);

				
}//End function: of_options()
}//End chack if function exists: of_options()
?>
