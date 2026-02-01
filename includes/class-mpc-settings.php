<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class MPC_Settings {

    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', [ __CLASS__, 'add_settings_tab' ], 50 );
        add_action( 'woocommerce_settings_tabs_mpc_tab', [ __CLASS__, 'settings_tab_content' ] );
        add_action( 'woocommerce_update_options_mpc_tab', [ __CLASS__, 'update_settings' ] );
    }

    public static function add_settings_tab( $tabs ) {
        $tabs['mpc_tab'] = 'Campo Personalizado';
        return $tabs;
    }

    public static function settings_tab_content() {
        ?>
        <h2>Configurações do Campo HTML</h2>
        <table class="form-table">
            <tr>
                <th>Texto HTML abaixo do preço:</th>
                <td>
                    <?php
                    $content = get_option( 'mpc_html_field_content', '' );
                    wp_editor( $content, 'mpc_html_field_content', [ 'textarea_name' => 'mpc_html_field_content' ] );
                    ?>
                </td>
            </tr>
        </table>
        <?php
    }

    public static function update_settings() {
        // Permitimos HTML usando wp_kses_post para segurança
        if ( isset( $_POST['mpc_html_field_content'] ) ) {
            update_option( 'mpc_html_field_content', wp_kses_post( $_POST['mpc_html_field_content'] ) );
        }
    }
}