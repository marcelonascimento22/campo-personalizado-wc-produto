<?php
/**
 * Classe responsável por verificar dependências do plugin
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class MPC_Dependencies {

    public static function init() {
        // Se o WooCommerce NÃO estiver ativo
        if ( ! class_exists( 'WooCommerce' ) ) {
            add_action( 'admin_notices', [ __CLASS__, 'render_notice' ] );
            return false;
        }
        return true;
    }

    public static function render_notice() {
        $screen = get_current_screen();
        // Opcional: Mostra apenas na página de plugins para não ser invasivo
        // if ( $screen->id !== 'plugins' ) return;

        ?>
        <div class="notice notice-warning is-dismissible">
            <p>
                <strong>Atenção:</strong> O plugin <em>Meu Plugin</em> precisa do 
                <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">WooCommerce</a> 
                instalado e ativo para funcionar corretamente.
            </p>
        </div>
        <?php
    }
}