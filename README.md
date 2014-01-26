<p align="center">
  <img src="https://raw.github.com/tr8n/tr8n/master/doc/screenshots/tr8nlogo.png">
</p>

Tr8n Plugin For Wordpress
=====================

This plugin uses Tr8n PHP Client SDK to enable inline translations of WordPress posts and page contents.

Installation
==================

Tr8n WordPress Plugin can be installed using the composer dependency manager. If you don't already have composer installed on your system, you can get it using the following command:

        $ cd YOUR_APPLICATION_FOLDER
        $ curl -s http://getcomposer.org/installer | php


Create composer.json in the root folder of your application, and add the following content:

        {
            "minimum-stability": "dev",
            "require": {
                "composer/installers": "v1.0.6",
                "tr8n/tr8n-wordpress-plugin": "dev-master"
            }
        }

This tells composer that your application requires tr8n-wordpress-plugin to be installed.

Now install Tr8n WordPress plugin by executing the following command:


        $ php composer.phar install







To learn about how to configure and use the plugin, please read the following documentation:

http://wiki.tr8nhub.com/index.php?title=Tr8n_WordPress_Plugin



