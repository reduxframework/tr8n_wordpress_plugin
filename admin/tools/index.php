<?php

if (\Tr8n\Config::instance()->isEnabled()) {
    ?>
        <div class="wrap" style="font-size:14px;padding:30px;">
            <img src="<?php echo \Tr8n\Config::instance()->application->host ?>/assets/tr8n/tr8n_logo.png"><br><br>
            <img src="<?php echo \Tr8n\Config::instance()->application->host ?>/assets/tr8n/spinner.gif" style="vertical-align:bottom">
            Redirecting to Tr8n service at <a href="<?php echo \Tr8n\Config::instance()->application->host ?>"><?php echo \Tr8n\Config::instance()->application->host ?></a> ...
        </div>

        <script>
            window.setTimeout(function() {
                location.href = "<?php echo \Tr8n\Config::instance()->application->host ?>/tr8n/app/phrases/index";
            }, 2000);
        </script>
    <?php
}

?>


