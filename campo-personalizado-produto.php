<?php
/**
 * Plugin Name: Campo Personalizado WooProduto
 * Plugin URI: https://www.devnascimento.com.br/campo-personalizado-produto
 * Description: Adiciona um campo personalizado ao produto Woo e exibe-o na página do produto, apos a descrição curta.
 * Version: 1.0.0
 * Author: Marcelo Nascimento
 * Author URI: https://www.devnascimento.com.br/
 * License: GPL2
 * WC tested up to: 8.5
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Carrega os arquivos das classes
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mpc-dependencies.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mpc-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-mpc-display.php';

// 2. Inicializa o plugin
add_action( 'plugins_loaded', 'mpc_start_plugin' );

function mpc_start_plugin() {
    // Verifica se o WooCommerce está ativo através da classe de dependências
    if ( class_exists( 'WooCommerce' ) ) {
        
        // Inicializa a aba de configurações (Admin)
        MPC_Settings::init();
        
        // Inicializa a exibição e os shortcodes (Front-end)
        MPC_Display::init();
        
    } else {
        // Se o WC não estiver ativo, mostra o aviso que criamos antes
        MPC_Dependencies::init(); 
    }
}

// 3. Declaração de compatibilidade HPOS
add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );