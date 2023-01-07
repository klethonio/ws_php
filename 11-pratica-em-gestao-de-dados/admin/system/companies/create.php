<?php
if (!class_exists('Login')) :
    header('Location: ../../panel.php');
    exit;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Cadastrar Empresa:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['sendPostForm'])){
            $data['company_status'] = ($data['sendPostForm'] == 'Cadastrar' ? '0' : '1');
            unset($data['sendPostForm']);
            $data['company_capa'] = ($_FILES['company_capa']['tmp_name'] ? $_FILES['company_capa'] : null);

            require('_models/AdminCompany.class.php');

            $addCompany = new AdminCompany;
            $company = $addCompany->exeCreate($data);

            if (!$addCompany->getResult()){
                WSMessage($addCompany->getError()[0], $addCompany->getError()[1]);
            } else {
                $_SESSION['success'] = "A empresa <b>{$company['company_title']}</b> foi cadastada com sucesso.";
                header("Location:panel.php?view=companies/update&id={$company['company_id']}");
                exit;
            }
        }
        ?>

        <form name="postForm" action="" method="post" enctype="multipart/form-data">

            <label class="label">
                <span class="field">Logo da empresa: <sup>Exatamente 578x288px (JPG ou PNG)</sup></span>
                <input type="file" name="company_capa" />
            </label>

            <label class="label">
                <span class="field">Nome da Empresa:</span>
                <input type="text" name="company_title" value="<?php if (isset($data['company_title'])) echo $data['company_title']; ?>" />
            </label>

            <label class="label">
                <span class="field">Ramo de atividade:</span>
                <input type="text" name="company_branch" value="<?php if (isset($data['company_branch'])) echo $data['company_branch']; ?>" />
            </label>

            <label class="label">
                <span class="field">Sobre a empresa:</span>
                <textarea name="company_about" rows="3"><?php if (isset($data['company_about'])) echo $data['company_about']; ?></textarea>
            </label>

            <div class="label_line">
                <label class="label_medium">
                    <span class="field">Site da Empresa:</span>
                    <input type="url" placeholder="http://www.upinside.com.br" name="company_site" value="<?php if (isset($data['company_site'])) echo $data['company_site']; ?>" />
                </label>

                <label class="label_medium">
                    <span class="field">Facebook Page:</span>
                    <input type="text" placeholder="upinside" name="company_facebook" value="<?php if (isset($data['company_facebook'])) echo $data['company_facebook']; ?>" />
                </label>                
            </div><!-- line -->

            <label class="label">
                <span class="field">Nome da rua / Número:</span>
                <input type="text" placeholder="Rua Nome da Rua / 1287" name="company_address" value="<?php if (isset($data['company_address'])) echo $data['company_address']; ?>" />
            </label>            

            <div class="label_line">
                <label class="label_small">
                    <span class="field">Estado UF:</span>
                    <select class="j_loadstate" name="company_state">
                        <option value="" selected> Selecione o estado </option>
                        <?php
                        $read = new Read;
                        $read->exeRead("app_states", "ORDER BY state_name ASC");
                        foreach ($read->getResult() as $state) {
                            extract($state);
                            echo "<option value=\"{$state_id}\" ";
                            if (isset($data['company_state']) && $data['company_state'] == $state_id) {
                                echo 'selected';
                            }
                            echo "> {$state_uf} / {$state_name} </option>";
                        }
                        ?>                        
                    </select>
                </label>

                <label class="label_small">
                    <span class="field">Cidade:</span>
                    <select class="j_loadcity" name="company_city">
                        <?php if (!isset($data['company_city'])) { ?>
                            <option value="" selected disabled> Selecione antes um estado </option>
                            <?php
                        } else {
                            $read = new Read;
                            $read->exeRead("app_cities", "WHERE state_id = :uf ORDER BY city_name ASC", ['uf' => $data['company_state']]);
                            if ($read->count()) {
                                foreach ($read->getResult() as $city) {
                                    extract($city);
                                    echo "<option value=\"{$city_id}\" ";
                                    if (isset($data['company_city']) && $data['company_city'] == $city_id) {
                                        echo "selected";
                                    }
                                    echo "> {$city_name} </option>";
                                }
                            }
                        }
                        ?>
                    </select>
                </label>

                <label class="label_small">
                    <span class="field">Indicação:</span>
                    <select name="company_category">
                        <option value="" selected> Indique a empresa como </option>
                        <option value="onde-comer" <?php if (isset($data['company_category']) && $data['company_category'] == 'onde-comer') echo 'selected'; ?>> Onde Comer </option>
                        <option value="onde-ficar" <?php if (isset($data['company_category']) && $data['company_category'] == 'onde-ficar') echo 'selected'; ?>> Onde Ficar </option>
                        <option value="onde-comprar" <?php if (isset($data['company_category']) && $data['company_category'] == 'onde-comprar') echo 'selected'; ?>> Onde Comprar </option>
                        <option value="onde-se-divertir" <?php if (isset($data['company_category']) && $data['company_category'] == 'onde-se-divertir') echo 'selected'; ?>> Onde se Divertir </option>
                    </select>
                </label>
            </div><!--/line-->

            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Cadastrar" name="sendPostForm" />
            <input type="submit" class="btn green" value="Cadastrar & Publicar" name="sendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content form- -->