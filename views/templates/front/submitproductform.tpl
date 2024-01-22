{extends file='customer/page.tpl'}

{block name='page_title'}
  {l s='Je souhaite vendre mes vêtements' d='Shop.Theme.Customeraccount'}
{/block}

{block name='page_content'}
    <div class="formSubmitProduct">
        <div class="productForm">
            <label class="label">Combien d'articles souhaitez-vous nous confier ?</label>
            <label><input type="radio" name="radioqty" value="1to4">1 à 4</label>
            <label><input type="radio" name="radioqty" value="5to20">5 à 20</label>
            <label><input type="radio" name="radioqty" value="20more">Plus de 20</label>
        </div>
        <div class="conditional" data-condition="radioqty === '1to4'">
            <p>Veuillez ne remplir que les champs pour lesquels vous avez des vêtements à vendre.</p>
            <div id="products">
                <form action="/index.php?controller=envoyeruncolis&fc=module&module=clientassupplier" id="1to4form" method="post">
                    <input type="hidden" name="qtySelected" value="4" />
                <div id="product1" style="display: grid;">
                    <label>Vêtement n° 1 :</label>
                    <div class="rowVetements">
                        <div class="col-md-6">
                            <label for="selectgenre1">Genre</label>
                            <select name="selectgenre1" id="selectgenre1" required>
                                <option value=""></option>
                                <option value="femme">Femme</option>
                                <option value="homme">Homme</option>
                            </select>
                            <label for="catevetements1">Type d'article</label>
                            <select name="catevetements1" id="catevetements1" required>
                                <option value=""></option>
                                <option value="Sac, pièce cuir, veste, manteau">Sac, pièce cuir, veste, manteau</option>
                                <option value="T-Shirt, débardeur, accessoire">T-Shirt, débardeur, accessoire</option>
                                <option value="Autre type de vêtement">Autre type de vêtement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="selectmarque1" required>Qualité</label>
                            <select name="selectmarque1" id="selectmarque1">
                                <option value=""></option>
                                <option value="Luxe">Luxe</option>
                                <option value="Semi-luxe">Semi-luxe</option>
                                <option value="Premium">Premium</option>
                            </select>
                            <label for="selectetiquette1" required>État</label>
                            <select name="selectetiquette1" id="selectetiquette1">
                                <option value=""></option>
                                <option value="Bon état">Bon état</option>
                                <option value="Très bon état">Très bon état</option>
                                <option value="neuf">Neuf</option>
                                <option value="neuf avec étiquette">Neuf avec étiquette</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="product2" style="display: grid;margin-top: 30px;">
                    <label>Vêtement n° 2 :</label>
                    <div class="rowVetements">
                        <div class="col-md-6">
                            <label for="selectgenre2">Genre</label>
                            <select name="selectgenre2" id="selectgenre2">
                                <option value=""></option>
                                <option value="femme">Femme</option>
                                <option value="homme">Homme</option>
                            </select>
                            <label for="catevetements2">Type d'article</label>
                            <select name="catevetements2" id="catevetements2">
                                <option value=""></option>
                                <option value="Sac, pièce cuir, veste, manteau">Sac, pièce cuir, veste, manteau</option>
                                <option value="T-Shirt, débardeur, accessoire">T-Shirt, débardeur, accessoire</option>
                                <option value="Autre type de vêtement">Autre type de vêtement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="selectmarque2">Qualité</label>
                            <select name="selectmarque2" id="selectmarque2">
                                <option value=""></option>
                                <option value="Luxe">Luxe</option>
                                <option value="Semi-luxe">Semi-luxe</option>
                                <option value="Premium">Premium</option>
                            </select>
                            <label for="selectetiquette2">État</label>
                            <select name="selectetiquette2" id="selectetiquette2">
                                <option value=""></option>
                                <option value="Bon état">Bon état</option>
                                <option value="Très bon état">Très bon état</option>
                                <option value="neuf">Neuf</option>
                                <option value="neuf avec étiquette">Neuf avec étiquette</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="product3" style="display: grid;margin-top: 30px;">
                    <label>Vêtement n° 3 :</label>
                    <div class="rowVetements">
                        <div class="col-md-6">
                            <label for="selectgenre3">Genre</label>
                            <select name="selectgenre3" id="selectgenre3">
                                <option value=""></option>
                                <option value="femme">Femme</option>
                                <option value="homme">Homme</option>
                            </select>
                            <label for="catevetements3">Type d'article</label>
                            <select name="catevetements3" id="catevetements3">
                                <option value=""></option>
                                <option value="Sac, pièce cuir, veste, manteau">Sac, pièce cuir, veste, manteau</option>
                                <option value="T-Shirt, débardeur, accessoire">T-Shirt, débardeur, accessoire</option>
                                <option value="Autre type de vêtement">Autre type de vêtement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="selectmarque3">Qualité</label>
                            <select name="selectmarque3" id="selectmarque3">
                                <option value=""></option>
                                <option value="Luxe">Luxe</option>
                                <option value="Semi-luxe">Semi-luxe</option>
                                <option value="Premium">Premium</option>
                            </select>
                            <label for="selectetiquette3">État</label>
                            <select name="selectetiquette3" id="selectetiquette3">
                                <option value=""></option>
                                <option value="Bon état">Bon état</option>
                                <option value="Très bon état">Très bon état</option>
                                <option value="neuf">Neuf</option>
                                <option value="neuf avec étiquette">Neuf avec étiquette</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div id="product4" style="display: grid;margin-top: 30px;">
                    <label>Vêtement n° 4 :</label>
                    <div class="rowVetements">
                        <div class="col-md-6">
                            <label for="selectgenre4">Genre</label>
                            <select name="selectgenre4" id="selectgenre4">
                                <option value=""></option>
                                <option value="femme">Femme</option>
                                <option value="homme">Homme</option>
                            </select>
                            <label for="catevetements4">Type d'article</label>
                            <select name="catevetements4" id="catevetements4">
                                <option value=""></option>
                                <option value="Sac, pièce cuir, veste, manteau">Sac, pièce cuir, veste, manteau</option>
                                <option value="T-Shirt, débardeur, accessoire">T-Shirt, débardeur, accessoire</option>
                                <option value="Autre type de vêtement">Autre type de vêtement</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="selectmarque4">Qualité</label>
                            <select name="selectmarque4" id="selectmarque4">
                                <option value=""></option>
                                <option value="Luxe2">Luxe</option>
                                <option value="Semi-luxe">Semi-luxe</option>
                                <option value="Premium">Premium</option>
                            </select>
                            <label for="selectetiquette4">État</label>
                            <select name="selectetiquette4" id="selectetiquette4">
                                <option value=""></option>
                                <option value="Bon état">Bon état</option>
                                <option value="Très bon état">Très bon état</option>
                                <option value="neuf">Neuf</option>
                                <option value="neuf avec étiquette">Neuf avec étiquette</option>
                            </select>
                        </div>
                    </div>
                </div>
                <p><input type='submit' class="pinkButton" style="margin-top: 1rem;display: inline-block;" value='Poursuivre'/></p>
            </form>
            </div>
        </div>
        <div class="conditional" data-condition="radioqty === '5to20'">
            <form action="/index.php?controller=envoyerform&fc=module&module=clientassupplier" method="post">
                <input type="hidden" name="qtySelected" value="5" />
            <div class="productForm">
                <label class="label">Avez-vous vérifié que vos articles correspondent à notre charte ?</label>
                <label><input type="radio" name="radioconv" value="non">Non</label>
                <label><input type="radio" name="radioconv" value="oui">Oui</label>
            </div>
            <div class="conditional" data-condition="radioconv === 'non'"><p><a href="#" class="pinkButton">Vérifier la charte</a></p></div>
            <div class="conditional" data-condition="radioconv === 'oui'"><p><input type='submit' class="pinkButton" style="margin-top: 1rem;display: inline-block;" value='Poursuivre'/></p></div>
            </form>
        </div>
        <div class="conditional" data-condition="radioqty === '20more'">
            <form action="/index.php?controller=envoyerform&fc=module&module=clientassupplier" method="post">
                <input type="hidden" name="qtySelected" value="20" />
                <p>Nous allons prendre contact avec vous afin d'organiser l'enlèvement. En cliquant sur "poursuivre", il vous suffira de remplir le formulaire de coordonnées et de nous indiquer dans la case message le jour et l'heure à laquelle vous souhaitez que l'on vous rappelle.</p>
                <p><input type='submit' class="pinkButton" style="margin-top: 1rem;display: inline-block;" value='Poursuivre'/></p>
            </form>
        </div>
    </div>
{/block}