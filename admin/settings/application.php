<?php

$application_fields = array(
    'tr8n_server_url' => array("title" => __('Server Url:'), "value" => get_option('tr8n_server_url'), "default" => "http://sandbox.tr8nhub.com"),
    'tr8n_application_key' => array("title" => __('Application Key:'), "value" => get_option('tr8n_application_key'), "default" => ""),
    'tr8n_application_secret' => array("title" => __('Secret:'), "value" => get_option('tr8n_application_secret'), "default" => ""),
);
?>

<div class="wrap">
        <table>
            <?php foreach($application_fields as $key => $field) { ?>
                <tr>
                    <td><?php echo($application_fields["title"]) ?></td>
                    <td><input type="text" name="<?php echo($key) ?>" value="<?php echo($field["value"]) ?>" placeholder="<?php echo($field["default"]) ?>"  size="40"></td>
                </tr>
            <?php } ?>
        </table>

        <hr />


    </form>
</div>

