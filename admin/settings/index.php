<?php

if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

//    add_options_page('Settings Admin', 'Settings', 'manage_options', 'test-setting-admin', array($this, 'create_admin_page'));

// variables for the field and option names
$hidden_field_name = 'tr8n_submit_hidden';
$application_fields = array(
    'tr8n_server_url' => array("title" => __('Server Url:'), "value" => get_option('tr8n_server_url'), "default" => "http://sandbox.tr8nhub.com"),
    'tr8n_application_key' => array("title" => __('Application Key:'), "value" => get_option('tr8n_application_key'), "default" => ""),
    'tr8n_application_secret' => array("title" => __('Secret:'), "value" => get_option('tr8n_application_secret'), "default" => ""),
);

$translation_fields = array(
    'tr8n_translate_wordpress' => array("title" => __('Translate Wordpress:'), "value" => get_option('tr8n_translate_wordpress'), "type" => "checkbox"),
);

// See if the user has posted us some information
// If they did, this hidden field will be set to 'Y'
if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
    foreach($application_fields as $key => $attributes) {
        update_option( $key, $_POST[ $key ] );
        $application_fields[$key] = array_merge($attributes, array("value" => $_POST[$key]));
    }
    foreach($translation_fields as $key => $attributes) {
        update_option( $key, $_POST[ $key ] );
        $translation_fields[$key] = array_merge($attributes, array("value" => $_POST[$key]));
    }
    ?>
    <div class="updated"><p><strong><?php _e('admin saved.'); ?></strong></p></div>
<?php
}

$field_sets = array($application_fields, $translation_fields);

?>

<div class="wrap">
    <?php echo "<h2>" . __( 'Tr8n Application Settings' ) . "</h2>"; ?>
    <form name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

        <?php foreach($field_sets as $field_set) { ?>
        <table>
            <?php foreach($field_set as $key => $field) { ?>
                <?php $type = (!isset($field['type']) ? 'text' : $field['type']); ?>
                <tr>
                    <td style="width:150px;"><?php echo($field["title"]) ?></td>
                    <td>
                        <?php if ($type == 'text') {  ?>
                            <input type="text" name="<?php echo($key) ?>" value="<?php echo($field["value"]) ?>" placeholder="<?php echo($field["default"]) ?>"  size="40">
                        <?php } else if ($type == 'checkbox') { ?>
                            <?php
                                $value = $field["value"];
                            ?>
                            <input type="checkbox" name="<?php echo($key) ?>" value="true" <?php if ($value == "true") echo("checked"); ?> >
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <hr />
        <?php } ?>

        <p class="submit">
            <button class="button-primary">
                <?php echo __('Save Changes') ?>
            </button>
        </p>

    </form>
</div>

