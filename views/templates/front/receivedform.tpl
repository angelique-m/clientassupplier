{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='Envoyer mes articles' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
    {if $messagetodisplay ==1}
        <p>Nous avons bien reçu votre demande. Vous recevrez prochaînement un e-mail avec le bon de transport. À bientôt sur <a href="#">#</a>.</p>
    {else}
        <p>Malheureusement, une erreur est survenue. Veuillez réessayer.</p>
    {/if}
{/block}