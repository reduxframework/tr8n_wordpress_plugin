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
 * http://tr8nhub.com/
 *
 * Copyright 2010-2013, Michael Berkovich, Tr8nHub
 * Licensed under the GPL Version 2 or higher.
 * http://tr8nhub.com/license
 *
 */

require_once('vendor/tr8n_php_clientsdk/library/Tr8n.php');

tr8n_init_client_sdk("http://localhost:3000", "29adc3257b6960703", "a5af33d9d691ce0a6");
// tr8n_init_client_sdk('http://sandbox.tr8nhub.com', 'df8a6877f0918aeb5', '5c07f42936f816eda');

wp_enqueue_script('tr8n', \Tr8n\Config::instance()->application->host . '/tr8n/api/proxy/boot.js?debug=true');

function tr8n_translate($atts, $content = null) {
    if ($content == null) return $content;

    $label = trim($content);
    $description = array_key_exists('context', $atts) ? $atts['context'] : null;
    $tokens = array();
    $options = array();

    if (isset($atts['tokens'])) {
        $tokens = json_decode($atts['tokens'], true);
    }

    if (isset($atts['split'])) {
        $options['split'] = $atts['split'];
    }

    foreach($atts as $key => $value) {
        $parts = explode('_', $key);
        if ($parts[0] == 'token' && count($parts) > 1) {
            $tokens[$parts[1]] = array();
            \Tr8n\Utils\ArrayUtils::createAttribute($tokens[$parts[1]], array_slice($parts,2), $value);
        }
    }

//    \Tr8n\Logger::instance()->info("translating: \"" . $content . "\"", $tokens);

    try {
        return tr($label, $description, $tokens, $options);
    } catch(\Exception $e) {
        \Tr8n\Logger::instance()->info($e->getMessage());
        return $content;
    }
}
add_shortcode('tr', 'tr8n_translate', 2);

function tr8n_title($title, $id) {
    return do_shortcode($title);
}
add_filter('the_title', 'tr8n_title', 10, 2);
add_filter('wp_title', 'tr8n_title', 10, 2);
