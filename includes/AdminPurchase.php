<?php

class AdminPurchase
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'purchase_admin_menu'));
    }

    public function purchase_admin_menu()
    {
        add_submenu_page(
            'woocommerce',
            'Comprar como Administrador',
            'Comprar como Administrador',
            'manage_woocommerce',
            'wc-purchase-admin',
            array($this, 'render_purchase_admin_page')
        );
    }

    private function getListUserRelated()
    {
        $current_user_id = get_current_user_id();

        $metadata = array(
            'meta_key' => 'connected_user',
            'meta_value' => $current_user_id,
            'fields' => 'all_with_meta',
            'orderby' => 'display_name',
            'order' => 'ASC',
        );

        $users_data = get_users($metadata);

        return $users_data;
    }

    private function getProducts()
    {
        $product_ids = get_posts(array(
            'post_type' => 'product',
            'numberposts' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
        ));

        return $product_ids;

    }

    public function render_purchase_admin_page()
    {
        $product_ids = $this->getProducts();
        $user_related_id = $this->getListUserRelated();

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
    <h1 class="header-title">Comprar como administrador</h1>
</div>
<div class="wrap">
    <div class="container-plans">
        <form method="post">
            <?php wp_nonce_field('custom_fields_nonce', 'custom_fields_nonce');?>
            <div class="plans">
                <div class="card-plans">
                    <div style="border-bottom:1px solid rgba(0, 0, 0, 0.2);margin-bottom:20px;">
                        <h1 style="margin-bottom:20px;">Selecione o plano para o cliente</h1>
                    </div>
                    <div class="form-plans">
                        <?php if ($product_ids): ?>
                        <div class="form-group">
                            <label for="selected_product_ids">Plano:</label>
                            <select id="product_id" name="product_id" class="select-form">
                                <option>selecione o produto</option>
                                <?php
foreach ($product_ids as $product_id) {
            echo '<option value="' . esc_attr($product_id) . '" >' . esc_html(get_the_title($product_id)) . '</option>';
        }
        ?>
                            </select>
                        </div>
                        <?php else: ?>
                        <p>Nenhum produto encontrado.</p>
                        <?php endif;?>
                        <?php if ($user_related_id): ?>

                        <div class="form-group">
                            <label for="selected_product_ids">Cliente:</label>
                            <select id="user_related_id" name="user_related_id" class="select-form">
                                <option>Selecione o cliente</option>
                                <?php
foreach ($user_related_id as $user_related_ids) {
            echo '<option value="' . esc_attr($user_related_ids->ID) . '">' . esc_html($user_related_ids->display_name) . '</option>';
        }
        ?>
                            </select>
                        </div>
                        <?php else: ?>
                        <p>Nenhum usuário encontrado.</p>
                        <?php endif;?>


                    </div>
                </div>
            </div>
            <div class="mt-3">
                <input type="submit" name="submit" class="button button-primary" value="Concluir Pedido">
            </div>
            <?php $this->adn_plans_submit();?>
        </form>
    </div>
</div>
<?php
}
    private function userExpired($user_related_id, $product_id)
    {
        $user_current_id = get_current_user_id();
        $order = wc_create_order();

        $order->add_product(wc_get_product($product_id), 1);
        $order->set_customer_id($user_current_id);
        $order->calculate_totals();
        $order->save();

        $order_id = $order->get_id();
        $order = wc_get_order($order_id);

        $_plan_mensal_training = get_option('_plan_mensal_training');
        $_plan_trimestral_training = get_option('_plan_trimestral_training');
        $_plan_semestral_training = get_option('_plan_semestral_training');
        $_plan_mensal_coachingRelation = get_option('_plan_mensal_coachingRelation');
        $_plan_trimestral_coachingRelation = get_option('_plan_trimestral_coachingRelation');
        $_plan_semestral_coachingRelation = get_option('_plan_semestral_coachingRelation');

        $product_data = array(
            $_plan_semestral_coachingRelation => '+6 months',
            $_plan_trimestral_coachingRelation => '+3 months',
            $_plan_mensal_coachingRelation => '+1 month',
            $_plan_semestral_training => '+6 months',
            $_plan_trimestral_training => '+3 months',
            $_plan_mensal_training => '+1 month',
        );

        if ($order && count($order->get_items()) > 0) {
            $order_date = $order->get_date_created()->format('Y-m-d');

            foreach ($order->get_items() as $item_id => $item) {
                if (in_array($product_id, array_keys($product_data))) {
                    $expiration_date = date('Y-m-d', strtotime($order_date . $product_data[$product_id]));

                    $response_data = array(
                        'order_id' => $order_id,
                        'order_date' => $order_date,
                        'user_id' => $user_related_id,
                        'expiration_date' => $expiration_date,
                    );

                    $json_response = json_encode($response_data);

                    update_user_meta($user_current_id, $user_related_id . '_user_expired', $json_response);
                }
            }

            if ($order->update_status('completed')) {
                update_post_meta($order_id, 'billing_user_related', $user_related_id);
                echo '<span style="margin-top:20px;">Pedido criado com sucesso.</span>';
            } else {
                echo '<span style="margin-top:20px;">Erro ao marcar o pedido como concluído.</span>';
            }
        } else {
            echo '<span style="margin-top:20px;">Erro: Nenhum item encontrado no pedido.</span>';
        }
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
            $user_related_id = sanitize_text_field($_POST["user_related_id"]);
            $product_id = sanitize_text_field($_POST["product_id"]);
            $userExpired = $this->userExpired($user_related_id, $product_id);

            // wp_redirect(site_url('/wp-admin/admin.php?page=wc-purchase-admin'));
            exit;
        }
    }
}
new AdminPurchase();