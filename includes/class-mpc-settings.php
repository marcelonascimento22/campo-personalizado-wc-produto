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
        $content = get_option( 'mpc_html_field_content', '' );
        echo '<h2>Configurações do Campo HTML</h2>';
        
        // Adiciona o campo de Nonce para segurança (Proteção contra CSRF)
        wp_nonce_field( 'mpc_save_settings_action', 'mpc_settings_nonce' );

        echo '<table class="form-table"><tr><th>HTML abaixo do preço:</th><td>';
        wp_editor( $content, 'mpc_html_field_content', [ 'textarea_name' => 'mpc_html_field_content' ] );
        echo '</td></tr></table>';
    }

    public static function update_settings() {
        // 1. Verificação de Nonce (Resolve o aviso: NonceVerification.Missing)
        if ( ! isset( $_POST['mpc_settings_nonce'] ) || ! wp_verify_nonce( $_POST['mpc_settings_nonce'], 'mpc_save_settings_action' ) ) {
            return;
        }

        // 2. Verificação de Permissão (Boa prática adicional)
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        if ( isset( $_POST['mpc_html_field_content'] ) ) {
            // 3. wp_unslash() remove barras indesejadas (Resolve o aviso: ValidatedSanitizedInput.MissingUnslash)
            // 4. wp_kses_post() limpa o HTML mantendo apenas tags seguras
            $allowed_html = wp_unslash( $_POST['mpc_html_field_content'] );
            update_option( 'mpc_html_field_content', wp_kses_post( $allowed_html ) );
        }
    }
}