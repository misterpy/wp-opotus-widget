<?php
/**
 * Opotus Widget plugin is a plugin to enable the user to easily integrate Opotus Payment Dropins
 * into your website.
 *
 * @package Opotus Widget Plugin
 * @author Opotus
 * @license GPL-2.0+
 * @link https://opotus.net
 * @copyright 2019 Standard Systems Ventures
 *
 * @wordpress-plugin
 *            Plugin Name: Opotus Widget Plugin
 *            Plugin URI: https://opotus.net/developers/wordpress
 *            Description: Opotus Widget plugin is a plugin to enable the user to easily integrate Opotus Payment Dropins into your website.
 *            Version: 1.0
 *            Author: Opotus
 *            Author URI: https://opotus.net
 *            Text Domain: opotus-widget
 *            Contributors: Opotus, Standard Systems
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


function opotus_add_menu()
{
    add_submenu_page(
        "options-general.php",
        "Opotus Widget",
        "Opotus Widget",
        "manage_options",
        "opotus-widget",
        "opotus_init_page"
    );
}

add_action("admin_menu", "opotus_add_menu");


function opotus_init_page()
{
    ?>
    <div class="wrap">
        <h1>
            Hello World Plugin Template By <a
                href="https://crunchify.com/optimized-sharing-premium/" target="_blank">Crunchify</a>
        </h1>

        <form method="post" action="options.php">
            <?php
            settings_fields("opotus_widget_config");
            do_settings_sections("opotus-widget");
            submit_button();
            ?>
        </form>
    </div>

    <?php
}

function opotus_payment_widget_settings() {
    add_settings_section("opotus_widget_config", "", null, "opotus-widget");
    add_settings_field(
        "opotus_widget-api_key",
        "General",
        "opotus_widget_config_options",
        "opotus-widget",
        "opotus_widget_config");
    register_setting(
        "opotus_widget_config",
        "opotus_widget-api_key");
    register_setting(
        "opotus_widget_config",
        "opotus_widget-secret_key");
    register_setting(
        "opotus_widget_config",
        "opotus_widget-callback_url");
}
add_action("admin_init", "opotus_payment_widget_settings");

function opotus_widget_config_options() {
    ?>
    <div class="postbox" style="width: 65%; padding: 30px;">
        <br>
        <p><strong>API Key: </strong><input type="text" name="opotus_widget-api_key"
                                            value="<?php
                                            echo stripslashes_deep(esc_attr(get_option('opotus_widget-api_key'))); ?>" /></p>

        <br>
        <p><strong>Secret Key: </strong><input type="text" name="opotus_widget-secret_key"
                                               value="<?php
                                               echo stripslashes_deep(esc_attr(get_option('opotus_widget-secret_key'))); ?>" /></p>

        <br>
        <p><strong>Callback URL: </strong> <input type="text" name="opotus_widget-callback_url"
                                                  value="<?php
                                                  echo stripslashes_deep(esc_attr(get_option('opotus_widget-callback_url'))); ?>" /></p>
    </div>
    <?php
}