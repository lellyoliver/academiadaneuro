<?php 
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$allowed_roles_1 = ['coachingRelation'];
$allowed_roles_2 = ['coach', 'health-pro', 'administrator', 'training'];
$allowed_roles_3 = ['training', 'administrator', 'coach'];
$data = get_user_meta( $current_user_id, 'connected_user', true );
$billing_phone = get_user_meta($data, 'billing_phone', true);
$profissional = get_userdata($data);
?>
<div class="loading" style="display:none" id="loading">
    <div class="overlay"></div>
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <form id="form-update" method="post" enctype="multipart/form-data">
                <div class="row d-flex align-items-center">
                    <div class="col-md">
                        <div class="row mb-3 perfil">
                            <img id="avatar-preview" alt="user-perfil" class="img-perfil mb-3">
                            <input type="file" class="display-none" name="avatar_file" id="avatar_file"
                                accept="image/*" />
                            <input type="hidden" name="post_id" id="post_id" value="<?php echo get_the_ID()?>">
                            <span class="edit-pen-perfil" id="edit-avatar">
                                <i class="fa-solid fa-pen"></i></span>
                            <h6 class="card-title text-center fw-bold mb-3 title-cards text-uppercase">
                                <?php echo esc_html('Meu Perfil'); ?>
                            </h6>
                            <p class="text-center" style="font-size:10px;">Permitido apenas foto 1:1
                            </p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <span class="label-float">
                                    <input type="text" id="name" name="name">
                                    <label for="name"><?php echo esc_html('Nome / Razão Social'); ?></label>
                                </span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="label-float">
                                    <input type="email" id="email" name="email">
                                    <label for="email"><?php echo esc_html('Email'); ?></label>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <span class="label-float">
                                    <input type="text" id="phone" name="phone">
                                    <label for="phone"><?php echo esc_html('Telefone'); ?></label>
                                </span>
                            </div>
                            <?php if (array_intersect($allowed_roles_2, $current_user->roles)): ?>
                            <div class="col-md-3 mb-3">
                                <span class="label-float">
                                    <input type="text" id="cep" name="cep">
                                    <label for="cep"><?php echo esc_html('CEP'); ?></label>
                                </span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="label-float">
                                    <input type="text" id="address" name="address">
                                    <label for="address"><?php echo esc_html('Endereço'); ?></label>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <span class="label-float">
                                    <input type="text" id="city" name="city">
                                    <label for="city"><?php echo esc_html('Cidade'); ?></label>
                                </span>
                            </div>
                            <div class="col-md-2 mb-3">
                                <span class="label-float">
                                    <input type="text" id="states" name="states">
                                    <label for="states"><?php echo esc_html('Estado'); ?></label>
                                </span>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-12 mb-3">
                                <span class="label-float">
                                    <input type="password" id="user_pass" name="user_pass">
                                    <label for="states"><?php echo esc_html('Senha'); ?></label>
                                    <i class="fa-solid fa-eye" id="show-password"></i>
                                </span>
                            </div>

                            <input type="hidden" name="user_id" id="userId" value="<?php echo $current_user_id; ?>">
                            <input type="hidden" name="role" id="role" value="<?php echo $current_user->roles[0]; ?>">
                            <div class="row m-0 m-auto">
                                <button type="submit" class="btn btn-lg btn-secondary" id="btnSave">Salvar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if (array_intersect($allowed_roles_1, $current_user->roles)): ?>
<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <h6 class="card-title fw-bold title-cards text-uppercase">
                <?php echo esc_html('Sua Assinatura'); ?>
            </h6>
            <div class="mb-3"></div>
            <p><b>Sua assinatura é compartilhada com seu(a) profissional: <?php echo $profissional->display_name;?></b>
                <?php 
                        if($expireds[0]['status']){
                            echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="ativo" class="color-success"><i class="fa-solid fa-circle-check"></i></span>';
                        }else{
                            echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="inativo" class="color-danger"><i class="fa-solid fa-triangle-exclamation"></i></span>';
                        }
                        ?>
            </p>
            <p>Qualquer dúvida sobre seu plano converse com seu profissional!</p>
            <p><a href="https://wa.me/+55<?php echo $billing_phone; ?>" class="btn btn-sm btn-outline-secondary"
                    target="_blank"><i class="fa-brands fa-whatsapp"></i> <?php echo $billing_phone;?></a></p>
            <!-- <hr>
            <p>Quero deixar de ter assinatura compartilhada e <a href="mailto:suporte@institutodeneurociencia.com.br">fazer uma solicitação para plano pessoal</a>!</p> -->

        </div>
    </div>
    <?php endif;?>
    <?php if (array_intersect($allowed_roles_2, $current_user->roles)): ?>
    <div class="card mb-3">
        <div class="container padding_container__card">
            <div class="card-body">
                <h6 class="card-title fw-bold title-cards text-uppercase">
                    <?php echo esc_html('Seu Plano'); ?>
                </h6>
                <div class="mb-3"></div>
                <div class="row">
                    <div class="col-md-6 mobile-order-3">
                        <h6>Últimos Pagamentos</h6>
                        <div class="mb-3"></div>
                        <?php
                        if ($orders) :
                            $total_orders = count($orders);
                            foreach ($orders as $index => $order) :
                                $order_id = $order->ID;
                                $order_data = wc_get_order($order_id);

                                $order_number = $order_data->get_order_number();
                                $order_date = $order_data->get_date_created();
                                $order_end_date = $order_data->get_date_completed();
                                $order_status = $order_data->get_status();

                                $total_price = $order_data->get_total();

                                $items = $order_data->get_items();
                                $product_names = array();

                                foreach ($items as $item) {
                                    $product = $item->get_product();
                                    $product_names[] = $product->get_name();
                                }

                                $product_names_string = implode(', ', $product_names);
                                $current_date = new DateTime();
                                $interval = $current_date->diff($order_date);
                                $is_within_7_days = $interval->days < 7;
                                ?>
                        <div class="timeline">
                            <div class="lines">
                                <div class="dot <?php echo $order_status; ?>"></div>
                                <div class="line"></div>
                            </div>
                            <div>
                                <p>#<?php echo $order_number; ?> <i class="fa-solid fa-circle-info"></i></p>
                                <h5><?php echo $product_names_string; ?> &minus;
                                    <?php echo wc_price($total_price); ?>
                                </h5>
                                <p><?php echo !empty($order_end_date) ? $order_end_date->format('d/m/Y') : ''; ?></p>
                                <?php if ($order_status == 'completed' && $is_within_7_days && $index !== $total_orders - 1) : ?>
                                <form class="form-refund" method="post" data-order-id="<?php echo $order_id; ?>">
                                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_id; ?>">
                                    <button class="btn btn-sm btn-outline-secondary mt-3" type="submit">
                                        <i class="fa-solid fa-rotate-left"></i> Pedir Reembolso
                                    </button>
                                </form>
                                <?php endif; ?>
                                <div class="mb-3"></div>
                            </div>
                        </div>
                        <?php endforeach;
                        endif;
                        ?>
                    </div>

                    <hr class="display-mobile mobile-order-2 mb-4 mt-4">
                    <?php if (array_intersect($allowed_roles_3, $current_user->roles)): ?>
                    <div class="col-md-6 mobile-order-1">
                        <h6>Cobranças</h6>
                        <div class="mb-3"></div>
                        <span>
                            <?php  if($userExpireds[0]):
                        setlocale(LC_TIME, 'pt_BR.utf8'); // Define o local para o português do Brasil
                        $expiration_date = strtotime($userExpireds[0]->expiration_date);
                        $formatted_date = strftime('%d de %B de %Y', $expiration_date);
                        $order_data = wc_get_order($userExpireds[0]->order_id);
                        $total_price = $order_data->get_total();
                        ?>
                            <p><i class="fa-solid fa-money-check-dollar"></i>
                                <b><?php echo wc_price($total_price); ?></b>
                                <br>
                                Próximo pagamento em<br> <b><?php echo $formatted_date; ?></b><br>
                            </p>
                            <?php endif;?>
                        </span>
                        <div class="mb-3"></div>
                        <button class="btn btn-sm btn-outline-secondary" data-bs-target="#cartUserRelated"
                            data-bs-toggle="offcanvas"><i class="fa-solid fa-credit-card"></i> Renovar Plano</button>
                        <?php 
                        if($expireds[0]['status']){
                            echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="ativo" class="color-success"><i class="fa-solid fa-circle-check"></i></span>';
                        }else{
                            echo '<span data-bs-toggle="tooltip" data-bs-placement="right" title="inativo" class="color-danger"><i class="fa-solid fa-triangle-exclamation"></i></span>';
                        }
                        ?>
                    </div>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>

    <!--comprar-->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="cartUserRelated" aria-labelledby="planos"
        style="z-index:9999!important;">
        <div class="offcanvas-header">
            <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0" id="planos" style="margin-right:12px;">
                Selecione um plano para você!</h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body small">
            <div class="row">
                <div class="col-md mb-4">
                    <form method="post">
                        <div class="card card-plans" onclick="this.closest('form').submit()">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">Plano I</span>
                                <h5 class="card-title fw-bold">Assinatura Mensal</h5>
                                <h6><?php echo wc_price(get_post_meta(63, '_price', true));  ?></h6>
                                <p><?php echo $description = wc_get_product(63) ? wc_get_product( 63 )->get_description() : 'Descrição não encontrada';?>
                                </p>
                                <input type="hidden" name="product_id" value="63">
                                <input type="hidden" name="user_related_id" value="<?php echo $current_user_id ?>">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md mb-4">
                    <form method="post">
                        <div class="card card-plans" onclick="this.closest('form').submit()">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">Plano II</span>
                                <h5 class="card-title fw-bold">Assinatura Trimestral</h5>
                                <h6><?php echo wc_price(get_post_meta(64, '_price', true));  ?></h6>
                                <p><?php echo $description = wc_get_product(64) ? wc_get_product( 64 )->get_description() : 'Descrição não encontrada';?>
                                </p>
                                <input type="hidden" name="product_id" value="64">
                                <input type="hidden" name="user_related_id" value="<?php echo $current_user_id ?>">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md mb-4">
                    <form method="post">
                        <div class="card card-plans" onclick="this.closest('form').submit()">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2">Plano III</span>
                                <h5 class="card-title fw-bold">Assinatura Semestral</h5>
                                <h6><?php echo wc_price(get_post_meta(65, '_price', true));  ?></h6>
                                <p><?php echo $description = wc_get_product(65) ? wc_get_product( 65 )->get_description() : 'Descrição não encontrada';?>
                                </p>
                                <input type="hidden" name="product_id" value="65">
                                <input type="hidden" name="user_related_id" value="<?php echo $current_user_id ?>">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
    document.getElementById('edit-avatar').addEventListener('click', function() {
        document.getElementById('avatar_file').click();
    });
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    </script>