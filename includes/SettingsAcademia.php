<?php

class PlansActive
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'plans_admin_menu'));
    }

    public function plans_admin_menu()
    {
        add_submenu_page(
            'woocommerce',
            'Planos Ativos',
            'Planos Ativos',
            'manage_woocommerce',
            'wc-plans',
            array($this, 'adn_plans_manager')
        );
    }

    public function adn_plans_manager()
    {
        // Obter todos os IDs de produtos
        $product_ids = get_posts(array(
            'post_type' => 'product',
            'numberposts' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
        ));

        ?>
<style>
body {
    background-color: #f0f0f1;
}

.container-plans {
    display: flex;
    max-width: 1032px;
    margin: 0 auto;
    justify-content: space-between;
    flex-direction: column;
}

.header-plans {
    background: #fff;
    top: 32px;
    padding: 20px 0px 20px 20px;
}

#wpcontent {
    height: calc(100vh - 32px);
    padding-left: 0px;
}

h1,
h2,
h3,
h4,
h5,
h6 {
    margin: 0px;
}

form {
    margin-top: 20px;
}

.form-group {
    /* margin-bottom: 20px; */
    margin-right: 10px;
}
.plans {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input.button-primary {
    margin-top: 10px;
}

.card-plans {
    background-color: rgb(255, 255, 255);
    color: rgb(30, 30, 30);
    position: relative;
    box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 0px 1px;
    outline: none;
    padding: 30px;
}

.form-plans {
    display: flex;
    justify-content: space-between;
}

.mt-3 {
    margin-top: 20px;
}

select.select-form {
    width: 100%;
}

.header-title {
    font-size: 14px;
}

@media screen and (max-width: 600px) {
    .wrap {
        clear: both;
        margin-right: 12px;
        margin-left: 12px;
    }

    .auto-fold #wpcontent {
        padding-left: 0px !important;
    }

    .header-plans {
        top: 49px;
    }

    .card-plans {
        padding: 15px;
    }
}
</style>
<div class="header-plans">
    <h1 class="header-title">Planos Ativos</h1>
</div>
<div class="wrap">
    <div class="container-plans">
    <p>Página para adicionar os planos atuais dos clientes, conforme as roles!</p>
        <form method="post">
            <?php wp_nonce_field('custom_fields_nonce', 'custom_fields_nonce');?>
            <div class="plans">
                <div class="card-plans">
                    <div style="border-bottom:1px solid rgba(0, 0, 0, 0.2);margin-bottom:20px;">
                        <h1 style="margin-bottom:20px;">Planos de Assinatura para Uso Pessoal</h1>
                    </div>
                    <div class="form-plans">
                        <?php if ($product_ids): ?>
                        <div class="form-group">
                            <label for="selected_product_ids">Mensal:</label>
                            <select id="select_plan_1" name="select_plan_1" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_mensal_training') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selected_product_ids">Trimestral:</label>
                            <select id="select_plan_2" name="select_plan_2" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_trimestral_training') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:0px;">
                            <label for="selected_product_ids">Semestral:</label>
                            <select id="select_plan_3" name="select_plan_3" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_semestral_training') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <?php else: ?>
                        <p>Nenhum produto encontrado.</p>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="plans">
                <div class="card-plans">
                    <div style="border-bottom:1px solid rgba(0, 0, 0, 0.2);margin-bottom:20px;">
                        <h1 style="margin-bottom:20px;">Planos de Assinatura para Profissional da Saúde</h1>
                    </div>
                    <div class="form-plans">
                        <?php if ($product_ids): ?>
                        <div class="form-group">
                            <label for="selected_product_ids">Mensal:</label>
                            <select id="select_plan_4" name="select_plan_4" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_mensal_coachingRelation') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selected_product_ids">Trimestral:</label>
                            <select id="select_plan_5" name="select_plan_5" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_trimestral_coachingRelation') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <div class="form-group" style="margin-bottom:0px;">
                            <label for="selected_product_ids">Semestral:</label>
                            <select id="select_plan_6" name="select_plan_6" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_semestral_coachingRelation') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <?php else: ?>
                        <p>Nenhum produto encontrado.</p>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="plans">
                <div class="card-plans">
                    <div style="border-bottom:1px solid rgba(0, 0, 0, 0.2);margin-bottom:20px;">
                        <h1 style="margin-bottom:20px;">Trial</h1>
                    </div>
                    <div class="form-plans">
                        <?php if ($product_ids): ?>
                        <div class="form-group" style="margin-bottom:0px;">
                            <label for="selected_product_ids">Semestral:</label>
                            <select id="select_plan_7" name="select_plan_7" class="select-form">
                                <option>selecione o produto</option>
                                <?php
                                foreach ($product_ids as $product_id) {
                                            $selected = (get_option('_plan_trial') == $product_id) ? 'selected' : '';
                                            echo '<option value="' . esc_attr($product_id) . '" ' . $selected . '>' . esc_html(get_the_title($product_id)) . '</option>';
                                        }
                                        ?>
                            </select>
                        </div>
                        <?php else: ?>
                        <p>Nenhum produto encontrado.</p>
                        <?php endif;?>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <input type="submit" name="submit" class="button button-primary" value="Salvar Plano">
            </div>
            <?php $this->adn_plans_submit();?>
        </form>
    </div>
</div>
<?php
}
    public function adn_plans_submit()
    {
        if (!isset($_POST['custom_fields_nonce']) || !wp_verify_nonce($_POST['custom_fields_nonce'], 'custom_fields_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (isset($_POST["submit"])) {
            $select_plan_1 = $_POST["select_plan_1"];
            $select_plan_2 = $_POST["select_plan_2"];
            $select_plan_3 = $_POST["select_plan_3"];
            $select_plan_4 = $_POST["select_plan_4"];
            $select_plan_5 = $_POST["select_plan_5"];
            $select_plan_6 = $_POST["select_plan_6"];
            $select_plan_7 = $_POST["select_plan_7"];

            $plan_data = [
                "_plan_mensal_training" => $select_plan_1,
                "_plan_trimestral_training" => $select_plan_2,
                "_plan_semestral_training" => $select_plan_3,
                "_plan_mensal_coachingRelation" => $select_plan_4,
                "_plan_trimestral_coachingRelation" => $select_plan_5,
                "_plan_semestral_coachingRelation" => $select_plan_6,
                "_plan_trial" => $select_plan_7,
            ];

            foreach ($plan_data as $name => $value) {
                // print_r($name . "->" . $value);
                update_option($name, $value);
            }
            
            wp_redirect(site_url('/wp-admin/admin.php?page=wc-plans'));
            exit;
        }
    }
}
new PlansActive();