<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/Editing_wp-config.php Modifier
 * wp-config.php} (en anglais). C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'weissblogdev');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'weissblogdev');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', '4YLQ5J');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9Jxbgb@#2bUu^[q#]>k.(-Mq.#%qrZTx~Yr|!2T`?(|+cj{uChw(X3R;CMrEE]Am');
define('SECURE_AUTH_KEY',  'KLNf8 cIPI09nI6Al?dHr~1;pHvw;baf%,JUKwwub8HS>-F4!6JSWZ,|_K1M1e9j');
define('LOGGED_IN_KEY',    '[M*::l,nX--<&O@zr2,jxvvG6zWd-Ed-o:[Z=]mG*H6xAV_vd+x^gfBDDG3M{ww|');
define('NONCE_KEY',        'XDG7.BE~IMHQ==E<)YkO*_xbuQ|thew<YQUo=1heJKd,E%RF+9A;Ec(~-I1-L]S$');
define('AUTH_SALT',        '!r0V,I~.+L~a3b$GjN)W}]bF>w+zGSY-]Z1faqi$15DV~VERfF|>$s2]t{TE9pF<');
define('SECURE_AUTH_SALT', 'I+JaU(DOhme9)$i&4tfv[BEV),NyzZ}Y^XAb/nFV854H&*rP},{L-~C- O:uXfOO');
define('LOGGED_IN_SALT',   '3Uo_5Ub}_!U=yX>gI1=2#ii/fW33Gx=Lc0z-OG_5%VxY4*+`i]xr1U?xX^{Y ,?3');
define('NONCE_SALT',       '-i7^Lr`hnDs@:Ef;Ei;oxA-PL+CoCk+NCc+_d52R/iKk/ON!]<vsJc`jN+P}#tFE');

/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 
define('WP_CACHE', true);
define( 'WP_ALLOW_MULTISITE', true ); 
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', true);
define('DOMAIN_CURRENT_SITE', ''. $_SERVER['HTTP_HOST'].''); 
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);
/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');