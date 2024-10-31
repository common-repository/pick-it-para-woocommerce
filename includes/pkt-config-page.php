 <?php 
    include_once PICKIT_PATH . 'includes/pkt-class-utilities.php';
 ?>
 <div class="wrap pickit_wrap">
        <div class="pickit_top">
            <h1 class="title_pickit_global">Configuración de Pickit</h1>
        </div>
        <p class="desc_pickit_global"> Configuración del módulo de Pickit para Woo Commerce.</p>
    <form name="pickit_global_config" id="pickit_global_config" action="#" method="POST">
        <hr>
        <div class="div_pickit_subtitle">
            <span class="dashicons dashicons-admin-tools"></span>
            <h2 class="subtitle_pickit_global">Configuración Global</h2>
        </div>
        <table class="form-table pickit_table">
            <tbody>

            <?php

            $table_name_global = $wpdb->prefix . 'woocommerce_pickit_global';

            global $wpdb;
            $results_global = $wpdb->get_results(
                "SELECT * FROM $table_name_global"
            );

            if ($results_global) {
                $hayConfig = true;
                $testmode = $results_global[0]->pickit_testing_mode;
                //$titledom = $results_global[0]->pickit_titledom;
                //$apikeyr = $results_global[0]->pickit_apikey_retailer;
                $apikeyw = $results_global[0]->pickit_apikey_webapp;
                $tokenid = $results_global[0]->pickit_token_id;
                $country = $results_global[0]->pickit_shop_country;
                $urlwebs = $results_global[0]->pickit_url_webservice;
                $urlwebst = $results_global[0]->pickit_url_webservice_test;
                $weight = $results_global[0]->pickit_product_weight;
                $dim = $results_global[0]->pickit_product_dim;
                $imposav = $results_global[0]->pickit_imposition_available;
                $estado_actual = $results_global[0]->pickit_estado_actual;
                //$type = $results_global[0]->pickit_ship_type;
                //$price_opt_dom = $results_global[0]->pickit_ship_price_opt_dom;
                //$price_fijo_dom = $results_global[0]->pickit_ship_price_fijo_dom;
                //$price_porcentual_dom = $results_global[0]->pickit_ship_price_porcentual_dom;
                $campo_dni = $results_global[0]->pickit_ship_campo_dni;
                $campo_dni_id = $results_global[0]->pickit_ship_campo_dni_id;
                $price_opt_punto = $results_global[0]->pickit_ship_price_opt_punto;
                $price_fijo_punto = $results_global[0]->pickit_ship_price_fijo_punto;
                $price_porcentual_punto = $results_global[0]->pickit_ship_price_porcentual_punto;
            } else {
                $hayConfig = false;
            }

            ?>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_testing_mode">Modo de Testeo:</label>
                </th>
                <td>
                    <select name="pickit_testing_mode" id="pickit_testing_mode">
                        <option <?php if($hayConfig == true) if($testmode == 0)echo('selected="selected"');?> value="0">Deshabilitado</option>
                        <option <?php if($hayConfig == true) if($testmode == 1)echo('selected="selected"');?> value="1">Habilitado</option>
                    </select>
                </td>
            </tr>

            <!---
            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_titledom">Título de envío:</label>
                </th>
                <td>
                    <input type="text" value="<?php echo($titledom)?>" name="pickit_titledom" id="pickit_titledom" maxlength="255">
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_apikey_retailer">ApiKey (Retailer):</label>
                </th>
                <td>
                    <input type="text" value="<?php echo($apikeyr)?>" name="pickit_apikey_retailer" id="pickit_apikey_retailer" maxlength="255">
                </td>
            </tr>
            --->

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_apikey_webapp">ApiKey (WebApp):</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig == true) echo($apikeyw)?>" name="pickit_apikey_webapp" id="pickit_apikey_webapp" maxlength="255">
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_token_id">Token ID:</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig == true) echo($tokenid)?>" name="pickit_token_id" id="pickit_token_id" maxlength="255">
                </td>
            </tr>

            <?php
            $urlPaises = PKT_UTILITIES::obtenerUrlPaises();
            $urlUAT = PKT_UTILITIES::obtenerUrlUAT();

            $urlArg = $urlPaises[0];
            $urlUru = $urlPaises[1];
            $urlMex = $urlPaises[2];
            $urlCol = $urlPaises[3];
            ?>

            <script>
            
            function selectCountry(){
                switch (document.getElementById("pickit_shop_country").value){
                    case '0':
                        document.getElementById("pickit_url_webservice").value = "<?php echo($urlArg)?>";
                        document.getElementById("pickit_url_webservice_test").value = "<?php echo($urlUAT)?>";
                        console.log(1);
                        break;
                    case '1':
                        document.getElementById("pickit_url_webservice").value = "<?php echo($urlUru)?>";
                        document.getElementById("pickit_url_webservice_test").value = "<?php echo($urlUAT)?>";
                        console.log(2);
                        break;
                    case '2':
                        document.getElementById("pickit_url_webservice").value = "<?php echo($urlMex)?>";
                        document.getElementById("pickit_url_webservice_test").value = "<?php echo($urlUAT)?>";
                        console.log(3);
                        break;
                    case '3':
                        document.getElementById("pickit_url_webservice").value = "<?php echo($urlCol)?>";
                        document.getElementById("pickit_url_webservice_test").value = "<?php echo($urlUAT)?>";
                        console.log(4);
                        break;
                }
                return;
            }

            </script>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_shop_country">Pais de la tienda:</label>
                </th>
                <td>
                    <select name="pickit_shop_country" id="pickit_shop_country" onchange="selectCountry()">
                        <option <?php if($hayConfig == true) if($country == 0)echo('selected="selected"');?> value="0">Argentina</option>
                        <option <?php if($hayConfig == true) if($country == 1)echo('selected="selected"');?> value="1">Uruguay</option>
                        <option <?php if($hayConfig == true) if($country == 2)echo('selected="selected"');?> value="2">México</option>
                        <option <?php if($hayConfig == true) if($country == 3)echo('selected="selected"');?> value="3">Colombia</option>
                    </select>
                </td>
            </tr>
            
            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_url_webservice">URL Web Service:</label>
                </th>
                <td>
                    <input type="text" value="<?php
                    if ($hayConfig) {
                        if ($urlwebs)
                            echo($urlwebs);
                        else
                            echo($urlArg);
                    } else 
                        echo($urlArg)
                    ?>" name="pickit_url_webservice" id="pickit_url_webservice" maxlength="255">
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_url_webservice_test">URL Web Service (Testing):</label>
                </th>
                <td>    
                    <input type="text" value="<?php 
                    if ($hayConfig) {
                        if ($urlwebst)
                            echo($urlwebst); 
                        else
                            echo($urlUAT);
                    } else 
                        echo($urlUAT);
                    ?>" name="pickit_url_webservice_test" id="pickit_url_webservice_test" maxlength="255">
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_product_weight">Peso del producto en:</label>
                </th>
                <td>
                    <select name="pickit_product_weight" id="pickit_product_weight">
                        <option <?php if($hayConfig) if(0==$weight)echo('selected="selected"');?> value="0">Kilogramos</option>
                        <option <?php if($hayConfig) if(1==$weight)echo('selected="selected"');?> value="1">Gramos</option>
                        <option <?php if($hayConfig) if(2==$weight)echo('selected="selected"');?> value="2">Libras</option>
                    </select>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_product_dim">Dimensiones del producto en:</label>
                </th>
                <td>
                    <select name="pickit_product_dim" id="pickit_product_dim">
                        <option <?php if($hayConfig) if(2==$dim)echo('selected="selected"');?> value="2">Milímetros</option>
                        <option <?php if($hayConfig) if(0==$dim)echo('selected="selected"');?> value="0">Centímetros</option>
                        <option <?php if($hayConfig) if(1==$dim)echo('selected="selected"');?> value="1">Metros</option>
                    </select>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_imposition_available">Imposición:</label>
                </th>
                <td>
                    <select name="pickit_imposition_available" id="pickit_imposition_available">
                        <option <?php if($hayConfig) if(0==$imposav)echo('selected="selected"');?> value="0">Automática según estado definido.</option>
                        <option <?php if($hayConfig) if(1==$imposav)echo('selected="selected"');?> value="1">Manual al realizar envío.</option>
                    </select>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_estado_actual">Estado inicial:</label>
                </th>
                <td>
                    <select name="pickit_estado_actual" id="pickit_estado_actual">
                        <option <?php if($hayConfig) if(1==$estado_actual)echo('selected="selected"');?> value="1">En retailer</option>
                        <option <?php if($hayConfig) if(2==$estado_actual)echo('selected="selected"');?> value="2">Disponible para retiro</option>
                    </select>
                </td>
            </tr>
            
<!---
            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_ship_type">Tipo de envío:</label>
                </th>
                <td>
                    <select name="pickit_ship_type" id="pickit_ship_type">
                        <option <?php if($hayConfig) if(0==$type)echo('selected="selected"');?> value="0">Envío a punto.</option>
                        <option <?php if($hayConfig) if(1==$type)echo('selected="selected"');?> value="1">Envío a domicilio.</option>
                        <option <?php if($hayConfig) if(2==$type)echo('selected="selected"');?> value="2">Ambos.</option>
                    </select>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_ship_country_available">Disponible en:</label>
                </th>
                <td>
                    <select name="pickit_ship_country_available" id="pickit_ship_country_available">
                        <option <?php if($hayConfig) if(0 == $coav) echo('selected="selected"');?> value="0">Todos los paises permitidos.</option>
                        <option <?php if($hayConfig) if(1 == $coav) echo('selected="selected"');?> value="1">Solo a algunos paises.</option>
                    </select>
                </td>
            </tr>

            <script type="text/javascript">
            jQuery('#pickit_ship_country_available').change(function(){
                if (1 == jQuery(this).val()){
                    jQuery('#tr_country_list').fadeIn();
                } else {
                    jQuery('#tr_country_list').fadeOut();
                }
            });
            </script>

            <tr class="form-field tr_country_list" style="display: <?php if($hayConfig) if(0 == $coav) echo('none'); ?> ;" id="tr_country_list">
                <th scope="row">
                    <label for="pickit_ship_country_list">Seleccione los paises:</label>
                </th>
                <td class="pickit_ship_list_select_td">
                    <select multiple class="pickit_ship_list_select" name="pickit_ship_country_list[]" id="pickit_ship_country_list">
                        <?php
                            $paises = WC()->countries->get_countries();
                            foreach ($paises as $pais){
                                echo('<option value="'.$pais.'">'.$pais.'</option>');
                            }
                        ?>
                    </select>
                </td>
            </tr>
--->
<!---
            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_ship_price_opt_dom">Precio de envío a domicilio:</label>
                </th>
                <td>
                    <select name="pickit_ship_price_opt_dom" id="pickit_ship_price_opt_dom">
                        <option <?php if($hayConfig) if(0==$price_opt_dom)echo('selected="selected"');?> value="0">Automático.</option>
                        <option <?php if($hayConfig) if(1==$price_opt_dom)echo('selected="selected"');?> value="1">Fijo.</option>
                        <option <?php if($hayConfig) if(2==$price_opt_dom)echo('selected="selected"');?> value="2">Porcentaje personalizado.</option>
                    </select>
                </td>
            </tr>

            <script type="text/javascript">
            jQuery('#pickit_ship_price_opt_dom').change(function(){
                if (1 == jQuery(this).val()){
                    jQuery('#tr_ship_price_fijo_dom').fadeIn();
                    jQuery('#tr_ship_price_porcentual_dom').css("display", "none");
                } else {
                    if (2 == jQuery(this).val()){
                        jQuery('#tr_ship_price_porcentual_dom').fadeIn();
                        jQuery('#tr_ship_price_fijo_dom').css("display", "none");
                    } else {
                        jQuery('#tr_ship_price_fijo_dom').fadeOut();
                        jQuery('#tr_ship_price_porcentual_dom').fadeOut();
                    }
                };
            });
            </script>

            <tr class="form-field tr_ship_price_fijo_dom" id="tr_ship_price_fijo_dom" style="display: <?php if($hayConfig) if(1!=$price_opt_dom)echo("none"); ?>;">
                <th scope="row">
                    <label for="pickit_ship_price_fijo_dom">Precio fijo (Domicilio):</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig) echo($price_fijo_dom)?>" name="pickit_ship_price_fijo_dom" id="pickit_ship_price_fijo_dom" maxlength="255">
                </td>
            </tr>

            <tr class="form-field tr_ship_price_porcentual_dom" id="tr_ship_price_porcentual_dom" style="display: <?php if($hayConfig) if(2!=$price_opt_dom)echo("none"); ?>;">
                <th scope="row">
                    <label for="pickit_ship_price_porcentual_dom">Porcentaje (Domicilio):</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig) echo($price_porcentual_dom)?>" name="pickit_ship_price_porcentual_dom" id="pickit_ship_price_porcentual_dom" maxlength="255">
                </td>
            </tr>
--->

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_ship_campo_dni">Campo DNI:</label>
                </th>
                <td>
                    <select name="pickit_ship_campo_dni" id="pickit_ship_campo_dni">
                        <option <?php if($hayConfig) if(0==$campo_dni)echo('selected="selected"');?> value="0">Crear nuevo campo</option>
                        <option <?php if($hayConfig) if(1==$campo_dni)echo('selected="selected"');?> value="1">Usar campo existente</option>
                    </select>
                </td>
            </tr>

            <script type="text/javascript">

            jQuery('#pickit_ship_campo_dni').change(function(){
                if (1 == jQuery(this).val()){
                    jQuery('#tr_ship_campo_dni_id').fadeIn();
                } else if (0 == jQuery(this).val()){
                    jQuery('#tr_ship_campo_dni_id').fadeOut();
                }
            });

            </script>

            <tr class="form-field tr_ship_campo_dni_id" id="tr_ship_campo_dni_id" style="display: <?php
            if($hayConfig) {
                if($campo_dni == 0)
                    echo("none"); 
            } else 
                echo("none");
            ?>;">
                <th scope="row">
                    <label for="pickit_ship_campo_dni_id">ID del campo DNI de la tienda:</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig) echo($campo_dni_id)?>" name="pickit_ship_campo_dni_id" id="pickit_ship_campo_dni_id" maxlength="255">
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row">
                    <label for="pickit_ship_price_opt_punto">Precio de envío a punto:</label>
                </th>
                <td>
                    <select name="pickit_ship_price_opt_punto" id="pickit_ship_price_opt_punto">
                        <option <?php if($hayConfig) if(0==$price_opt_punto)echo('selected="selected"');?> value="0">Automático.</option>
                        <option <?php if($hayConfig) if(1==$price_opt_punto)echo('selected="selected"');?> value="1">Fijo.</option>
                        <option <?php if($hayConfig) if(2==$price_opt_punto)echo('selected="selected"');?> value="2">Porcentaje personalizado.</option>
                    </select>
                </td>
            </tr>

            <script type="text/javascript">
            jQuery('#pickit_ship_price_opt_punto').change(function(){
                if (1 == jQuery(this).val()){
                    jQuery('#tr_ship_price_fijo_punto').fadeIn();
                    jQuery('#tr_ship_price_porcentual_punto').css("display", "none");
                } else {
                    if (2 == jQuery(this).val()){
                        jQuery('#tr_ship_price_porcentual_punto').fadeIn();
                        jQuery('#tr_ship_price_fijo_punto').css("display", "none");
                    } else {
                        jQuery('#tr_ship_price_fijo_punto').fadeOut();
                        jQuery('#tr_ship_price_porcentual_punto').fadeOut();
                    }
                };
            });
            </script>

            <tr class="form-field tr_ship_price_fijo_punto" id="tr_ship_price_fijo_punto" style="display: <?php 
            if($hayConfig) {
                if(1!=$price_opt_punto)
                    echo("none");
            } else
                echo("none");
            ?>;">
                <th scope="row">
                    <label for="pickit_ship_price_fijo_punto">Precio fijo (Punto):</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig) echo($price_fijo_punto)?>" name="pickit_ship_price_fijo_punto" id="pickit_ship_price_fijo_punto" maxlength="255">
                </td>
            </tr>

            <tr class="form-field tr_ship_price_porcentual_punto" id="tr_ship_price_porcentual_punto" style="display: <?php 
            if($hayConfig) {
                if(2!=$price_opt_punto)
                    echo("none"); 
            } else
                echo("none");
            ?>;">
                <th scope="row">
                    <label for="pickit_ship_price_porcentual_punto">Porcentaje (Punto):</label>
                </th>
                <td>
                    <input type="text" value="<?php if($hayConfig) echo($price_porcentual_punto)?>" name="pickit_ship_price_porcentual_punto" id="pickit_ship_price_porcentual_punto" maxlength="255">
                </td>
            </tr>

            </tbody>
        </table>

        <input type="hidden" name="action" value="pickit_global_config">

        <p class="submit">
            <input type="submit" name="submit_pickit_global" id="submit_pickit_global" class="button button-primary submit_pickit_global" value="Confirmar">
        </p>

    </form>
</div>