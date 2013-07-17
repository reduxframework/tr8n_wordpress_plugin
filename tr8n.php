<?php
/*
  Plugin Name: Tr8n
  Plugin URI: http://tr8nhub.com/
  Description: Translation filter for WordPress
  Author: Tr8nHub
  Version: 0.1.0
  Author URI: http://tr8nhub.com/
  License: GPL (http://www.gnu.org/licenses/gpl.txt)
  Text Domain: tr8nhub
  Domain Path: /tr8n
 */

/*
 * Tr8n v0.1.0
 * http://tr8nhub.org/
 *
 * Copyright 2010-2013, Tr8nHub
 * Licensed under the GPL Version 2 or higher.
 * http://tr8nhub.com/license
 *
 */

require_once('vendor/tr8n_php_clientsdk/library/Tr8n.php');

//tr8n_init_client_sdk("http://sandbox.tr8nhub.com", "0c1eb03d6c6e12cb2", "5ff3d87a83c13fcdb");
tr8n_init_client_sdk('http://sandbox.tr8nhub.com', 'df8a6877f0918aeb5', '5c07f42936f816eda');

wp_enqueue_script('tr8n', \Tr8n\Config::instance()->application->host . '/tr8n/api/proxy/boot.js?debug=true');

add_shortcode('tml:token', 'tmlToken');
add_shortcode('tml:label', 'tmlLabel', 2);

function tmlToken($atts, $content = null) {
    return "{Token}";
}

function tmlLabel($atts, $content = null) {
    $label = do_shortcode($content);
    return tr($label);

//    $lang = strtolower($atts['lang']);
//    $content = "<div class='translate_".$lang."'>".$content."</div>";
//    if($lang == $_SESSION['language']):
//
//        return $content;
//    endif;
//
}





