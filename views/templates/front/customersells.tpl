{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='Suivi des produits en vente' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
    <div id="js-product-list">
        <div class="products row">
            {$j=0}
            {foreach $products as $product}
                {if $product["quantity"] > 0}
                    {$j=1}
                    <div class="js-product product col-xs-12 col-sm-6 col-xl-3 col-md-3 item">
                        <article class="product-miniature js-product-miniature">
                            <div class="thumbnail-container">
                                <div class="thumbnail-top">
                                    <a href="{$urls.base_url}{$product["link_rewrite"]}/{$product["id_product"]}-{$product["name"]|replace:' ':'-'|lower}.html" class="thumbnail product-thumbnail">
                                        <picture>
                                            <img src="{$urls.base_url}{$product["id_image"]}-home_default/top-kookai.jpg" alt="Top Kookaï">
                                        </picture>
                                    </a>
                                </div>
                                <div class="product-description">
                                    <span class="productBrand"><a href="{$urls.base_url}brand/{$product["id_manufacturer"]}-{$product["mnname"]|replace:' ':'-'|lower}">{$product["mnname"]}</a></span>
                                    <h3 class="h3 product-title"><a href="#">{$product["name"]}</a></h3>
                                    <div class="product-price-and-shipping">
                                        <span class="price" aria-label="Prix">Prix public : {$product["price"]|string_format:"%.2f"} €</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                {/if}
            {/foreach}
            {if $j==0}
                Aucun produit n'est en vente actuellement.
            {/if}
        </div>
    </div>
    <h1>{l s='Suivi des produits vendus ou en cours d\'achat' d='Shop.Theme.Customeraccount'}</h1>
    <div id="js-product-list">
        <div class="products row">
            {$i=0}
            {foreach $products as $product}
                {if $product["quantity"] == 0}
                    {$i=1}
                    <div class="js-product product col-xs-12 col-sm-6 col-xl-3 col-md-3 item">
                        <article class="product-miniature js-product-miniature">
                            <div class="thumbnail-container">
                                <div class="thumbnail-top">
                                    <a href="{$urls.base_url}{$product["link_rewrite"]}/{$product["id_product"]}-{$product["name"]|replace:' ':'-'|lower}.html" class="thumbnail product-thumbnail">
                                        <picture>
                                            <img src="{$urls.base_url}{$product["id_image"]}-home_default/top-kookai.jpg" alt="Top Kookaï">
                                        </picture>
                                    </a>
                                </div>
                                <div class="product-description">
                                    <span class="productBrand"><a href="{$urls.base_url}brand/{$product["id_manufacturer"]}-{$product["mnname"]|replace:' ':'-'|lower}">{$product["mnname"]}</a></span>
                                    <h2 class="h3 product-title"><a href="#">{$product["name"]}</a></h2>
                                    <div class="product-price-and-shipping">
                                        <span class="price" aria-label="Prix">Prix public : {$product["price"]|string_format:"%.2f"} €</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                {/if}
            {/foreach}
            {if $i==0}
                Aucun produit ne figure dans cette liste.
            {/if}
        </div>
    </div>
{/block}
