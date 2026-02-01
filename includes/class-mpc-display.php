<?php
/**
 * Classe responsável pela exibição no Front-end e Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class MPC_Display {

    /**
     * Inicializa os hooks de exibição e registra os shortcodes
     */
    public static function init() {
        // 1. Exibição na PÁGINA DO PRODUTO (Logo abaixo do preço)
        add_action( 'woocommerce_single_product_summary', [ __CLASS__, 'render_custom_content' ], 11 );

        // 2. Exibição no GRID / LOJA / HOME / CARROSSEIS
        add_action( 'woocommerce_after_shop_loop_item_title', [ __CLASS__, 'render_custom_content' ], 15 );
        
        // Registro dos Shortcodes
        add_shortcode( 'preco_produto', [ __CLASS__, 'shortcode_preco_produto' ] );
        add_shortcode( 'preco_calculado', [ __CLASS__, 'shortcode_preco_calculado' ] );
    }

    /**
     * Renderiza o conteúdo configurado no painel do WooCommerce
     */
    public static function render_custom_content() {
        global $product;

        // Se o objeto do produto não existir ou o preço for zero/vazio, encerra a função
        if ( ! $product || ! is_a( $product, 'WC_Product' ) ) {
            return;
        }

        $price = $product->get_price();
        if ( empty( $price ) || $price <= 0 ) {
            return;
        }

        // Busca o conteúdo salvo no banco de dados
        $html = get_option( 'mpc_html_field_content', '' );

        if ( ! empty( $html ) ) {
            // Define classes diferentes para facilitar a estilização via CSS
            $context = is_product() ? 'mpc-single-product' : 'mpc-archive-product';
            
            echo '<div class="mpc-custom-html-container ' . esc_attr($context) . '" style="margin: 5px 0; font-size: 0.9em;">';
            echo do_shortcode( $html ); 
            echo '</div>';
        }
    }

    /**
     * Shortcode: [preco_produto]
     * Retorna o preço formatado do produto atual
     */
    public static function shortcode_preco_produto( $atts ) {
        global $product;

        $atts = shortcode_atts( array(
            'id' => ( $product ) ? $product->get_id() : get_the_ID(),
        ), $atts, 'preco_produto' );

        if ( ! class_exists( 'WooCommerce' ) ) return '';

        $target_product = wc_get_product( $atts['id'] );
        
        // Verifica se o produto existe e se tem preço maior que zero
        if ( ! $target_product || $target_product->get_price() <= 0 ) {
            return '';
        }

        return '<span class="mpc-price-display">' . $target_product->get_price_html() . '</span>';
    }

    /**
     * Shortcode: [preco_calculado fator="0.10"]
     * Realiza cálculos matemáticos baseados no preço do produto
     */
    public static function shortcode_preco_calculado( $atts ) {
        global $product;

        $atts = shortcode_atts( array(
            'id'    => ( $product ) ? $product->get_id() : get_the_ID(),
            'fator' => '1',
        ), $atts, 'preco_calculado' );

        if ( ! class_exists( 'WooCommerce' ) ) return '';

        $target_product = wc_get_product( $atts['id'] );
        
        // Verifica se o produto existe e se tem preço maior que zero
        if ( ! $target_product || $target_product->get_price() <= 0 ) {
            return '';
        }

        // Obtém o preço numérico bruto
        $preco_original = (float) $target_product->get_price();
        
        // Converte a string do fator para float (ex: "0,10" vira 0.10)
        $fator = (float) str_replace(',', '.', $atts['fator']);
        
        // Realiza a operação matemática
        $resultado = $preco_original * $fator;

        // Retorna o valor formatado com o símbolo da moeda da loja
        return '<span class="mpc-calculated-price">' . wc_price( $resultado ) . '</span>';
    }
}