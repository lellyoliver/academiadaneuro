<div class="card mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <form id="form-update" method="post">
                <div class="row d-flex align-items-center">
                    <div class="col-md">
                        <div class="row mb-3">
                            <img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/user-perfil.svg"
                                alt="user-perfil" class="img-perfil mb-3">
                            <h5 class="card-title text-center fw-bold mb-3 title-cards text-uppercase">
                                <?php echo esc_html('Meu Perfil'); ?>
                            </h5>
                            <p id="user_name" class="text-center"></p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <p class="fw-bold color-secondary text-center-perfil">Dados Pessoais</p>
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
                            <input type="hidden" name="user_id" id="userId"
                                value="<?php echo get_current_user_id(); ?>">
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

<div class="card mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <h5 class="card-title fw-bold title-cards text-uppercase">
                <?php echo esc_html('Pedidos e Assinaturas'); ?>
            </h5><small>Mostra os 5 últimos</small>
            <div class="mb-3"></div>
            <?
                        foreach ($orders as $order) :
                            $order_id = $order->ID;
                            $order_data = wc_get_order($order_id);

                            // Informações específicas do pedido
                            $order_number = $order_data->get_order_number();
                            $order_date = $order_data->get_date_created();
                            $order_end_date = $order_data->get_date_completed();
                            $order_status = $order_data->get_status();
                            
                             // Obtendo os itens do pedido
                            $items = $order_data->get_items();
                            $product_names = array();
                            $total_price = 0; // Total do preço dos produtos
                            foreach ($items as $item) {
                                $product = $item->get_product();
                                $product_names[] = $product->get_name();
                                $total_price += $product->get_price() * $item->get_quantity();
                            }
                            $product_names_string = implode(', ', $product_names);
                            $classe_css = ($order_status == "Completed") ? "dot-bg-pending" : "dot-bg-completed";

                        ?>
            <div class="timeline">
                <div class="lines">
                    <div class="dot <?php echo $classe_css; ?>"></div>
                    <div class="line"></div>
                </div>
                <div>
                    <p>#<?php echo $order_number;?></p>
                    <h5><?php echo $product_names_string; ?> &minus; <?php echo wc_price($total_price); ?></h5>
                    <p><?php echo $order_date->format('d/m/Y H:i'); ?> |
                        <?php echo $order_end_date->format('d/m/Y H:i'); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>