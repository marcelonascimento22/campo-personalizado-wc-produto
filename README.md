# Campo Personalizado WooProduto

Este plugin para WordPress/WooCommerce permite adicionar uma área de conteúdo dinâmico (HTML, textos e shortcodes) logo abaixo do preço dos produtos. Ele foi projetado para funcionar de forma inteligente: realiza cálculos matemáticos baseados no preço atual do produto e se adapta tanto às páginas individuais quanto aos grids de produtos e carrosséis.



## ✨ Funcionalidades

- **Painel de Configuração**: Nova aba em *WooCommerce > Configurações* para gerenciar o conteúdo global.
- **Editor Visual**: Suporte total ao editor nativo do WordPress para formatação de texto e links.
- **Cálculos Matemáticos**: Shortcode para exibir frações, porcentagens ou parcelas do preço.
- **Exibição Inteligente**: 
    - Aparece na página do produto (abaixo do preço).
    - Aparece em Loops (Loja, Home, Categorias e Carrosséis).
- **Filtro de Preço Zero**: Oculta automaticamente o campo se o produto não tiver preço definido ou for gratuito (R$ 0,00).
- **Compatibilidade Total**: Preparado para o *High Performance Order Storage* (HPOS).

## 🛠️ Estrutura do Projeto

O plugin é organizado de forma modular para facilitar a manutenção:

```text
/campo-personalizado-wc-produto
├── campo-personalizado-wc-produto.php   # Inicializador e Compatibilidade
├── includes/
│   ├── class-mpc-dependencies.php       # Verificador de WooCommerce Ativo
│   ├── class-mpc-settings.php           # Interface Administrativa (Aba WC)
│   └── class-mpc-display.php            # Lógica de Front-end e Shortcodes
└── README.md                            # Documentação
```

## 📖 Como Usar os Shortcodes

Dentro da aba Campo Personalizado nas configurações do WooCommerce, você pode utilizar os seguintes comandos:


| Shortcode | Exemplo de Uso | Resultado |
|---|---|---|
| [preco_produto] | Preço: [preco_produto] | Exibe o preço atual (R$ 100,00) |
| [preco_calculado] | 10x de [preco_calculado fator="0.1"] | Exibe 10% do valor (R$ 10,00) |

## Exemplos Práticos:
#### Desconto à vista (10% OFF): Pix: [preco_calculado fator="0.9"]
#### Parcelamento (12x): 12x de [preco_calculado fator="0.0833"]
#### Valor da entrada (30%): Entrada de [preco_calculado fator="0.3"]