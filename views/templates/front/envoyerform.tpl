{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='Envoyer mes articles' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
   <p>Bonjour, nous vous remercions d'avoir pris le temps de renseigner ces informations. Vous avez indiqué avoir
    {if $qtyToSubmit['qtySelected'] == 4}
      moins de 4 articles à nous envoyer.
    {elseif $qtyToSubmit['qtySelected'] == 5}
      entre 5 et 20 articles à nous envoyer.
    {elseif $qtyToSubmit['qtySelected'] == 20}
      plus de 20 articles à nous envoyer.
    {/if}
    <p>Merci de bien vouloir compléter le formulaire ci-dessous afin que l'on prenne contact avec vous pour le ramassage des articles à récupérer :</p>
    <form action="/index.php?controller=receivedform&fc=module&module=clientassupplier" method="post">
      {foreach from=$qtyToSubmit key=k item=v}
          <input type="hidden" name="{$k}" value="{$v}" />
      {/foreach}
      <input type="text" name="firstname" placeholder="Prénom" minlength="2" maxlength="40" required>
      <input type="text" name="lastname" placeholder="Nom" minlength="2" maxlength="40" required><br />
      <input type="email" name="email" placeholder="votremail@mail.com" minlength="2" maxlength="140" required>
      <p class="fakeTitle">Votre adresse :</p>
      <input type="text" name="address" placeholder="Numéro de rue + rue" minlength="2" maxlength="140" required><br />
      <input type="number" name="ZIP" placeholder="45100" required>
      <input type="text" name="city" placeholder="Ville" minlength="2" maxlength="140" required>
      <p><input type='submit' class="pinkButton" style="margin-top: 1rem;display: inline-block;" value='Envoyer !'/></p>
    </form>
   </p>
   
{/block}