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

//class Tr8nWordpressConfig extends \Tr8n\Config {
//    public function isCachingEnabled() {
//        return true;
//    }
//}
//\Tr8n\Config::init(new Tr8nWordpressConfig());

function tr8n_translate($atts, $content = null) {
    if ($content == null) return $content;

    $label = trim($content);
    $description = isset($atts['context']) ? $atts['context'] : null;
    $tokens = array();
    $options = array();

    if (is_string($atts)) $atts = array();

    if (isset($atts['tokens'])) {
        $tokens = json_decode($atts['tokens'], true);
    }

    if (isset($atts['options'])) {
        $options = json_decode($atts['options'], true);
    }

    foreach(array_values($atts) as $value) {
        if (\Tr8n\Utils\StringUtils::startsWith('token:', $value)) {
            $parts = explode('=', substr($value, 6));
            $value = trim($parts[1], '\'"');

            $parts = explode('.', $parts[0]);
            if (count($parts) == 1) {
                $tokens[$parts[0]] = $value;
            } else {
                if (!isset($tokens[$parts[0]])) $tokens[$parts[0]] = array();
                \Tr8n\Utils\ArrayUtils::createAttribute($tokens[$parts[0]], array_slice($parts,1), $value);
            }
        } else if (\Tr8n\Utils\StringUtils::startsWith('option:', $value)) {
            $parts = explode('=', substr($value, 7));
            $value = trim($parts[1], '\'"');

            $parts = explode('.', $parts[0]);
            if (count($parts) == 1) {
                $options[$parts[0]] = $value;
            } else {
                if (!isset($options[$parts[0]])) $options[$parts[0]] = array();
                \Tr8n\Utils\ArrayUtils::createAttribute($options[$parts[0]], array_slice($parts,1), $value);
            }
        }
    }

    if (isset($atts['split'])) {
        $options['split'] = $atts['split'];
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

function tr8n_block($atts, $content = null) {
    $options = array();
    if (isset($atts['source'])) {
        $options['source'] = $atts['source'];
    }
    if (isset($atts['locale'])) {
        $options['locale'] = $atts['locale'];
    }
    \Tr8n\Config::instance()->beginBlockWithOptions($options);
    $content = do_shortcode($content);
    \Tr8n\Config::instance()->finishBlockWithOptions();
    return $content;
}
add_shortcode('tr8n:block', 'tr8n_block', 2);

function tr8n_title($title, $id) {
    return do_shortcode($title);
}
add_filter('the_title', 'tr8n_title', 10, 2);
add_filter('wp_title', 'tr8n_title', 10, 2);


function tr8n_request_shutdown() {
    \Tr8n\Config::instance()->application->submitMissingKeys();
}
add_action('shutdown', 'tr8n_request_shutdown');

/*
 * Api Forwarding
 */

//add_rewrite_rule('^tr8n/api/([^/]*)/([^/]*)/?','vendor/tr8n_php_clientsdk/library/Tr8n/Api/Router.php?controller=$matches[1]&action=$matches[2]','top');

wp_enqueue_script('tr8n', \Tr8n\Config::instance()->application->host . '/tr8n/api/proxy/boot.js?debug=true');
