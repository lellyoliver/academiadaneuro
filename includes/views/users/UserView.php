<div class="card card-blue mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <form id="form-update" method="post">
                <h5 class="card-title fw-bold mb-3 mt-3 title-cards text-uppercase">
                    <?php echo esc_html('Meu Perfil'); ?>
                    <button type="submit" class="btn btn-secondary save" id="updateUser"><i
                            class="fa-solid fa-floppy-disk"></i></button>
                </h5>
                <hr>
                <div class="row mb-3">
                    <p class="fw-bold color-secondary">Dados Pessoais</p>
                    <div class="col-md-2">
                        <label for="billing_data" class=" label-perfil"><?php echo esc_html('CNPJ / CPF'); ?></label>
                        <input class="form-control form-perfil" type="text" id="billing_data" name="billing_data">
                    </div>
                    <div class="col-md-4">
                        <label for="name" class=" label-perfil"><?php echo esc_html('Nome / Razão Social'); ?></label>
                        <input class="form-control form-perfil" type="text" id="name" name="name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class=" label-perfil"><?php echo esc_html('Email'); ?></label>
                        <input class="form-control form-perfil" type="email" id="email" name="email" required>
                    </div>
                    <div class="col-md-2">
                        <label for="phone" class=" label-perfil"><?php echo esc_html('Telefone'); ?></label>
                        <input class="form-control form-perfil" type="text" id="phone" name="phone">
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <p class="fw-bold color-secondary">Endereço de Faturamento</p>
                    <div class="col-md-2">
                        <label for="cep" class=" label-perfil"><?php echo esc_html('CEP'); ?></label>
                        <input class="form-control form-perfil" type="text" id="cep" name="cep">
                    </div>
                    <div class="col-md-4">
                        <label for="address" class=" label-perfil"><?php echo esc_html('Endereço'); ?></label>
                        <input class="form-control form-perfil" type="text" id="address" name="address">
                    </div>
                    <div class="col-md-4">
                        <label for="city" class=" label-perfil"><?php echo esc_html('Cidade'); ?></label>
                        <input class="form-control form-perfil" type="text" id="city" name="city">
                    </div>
                    <div class="col-md-2">
                        <label for="states" class=" label-perfil"><?php echo esc_html('Estado'); ?></label>
                        <input class="form-control form-perfil" type="text" id="states" name="states">
                    </div>
                    <input type="hidden" name="user_id" id="userId" value="<?php echo get_current_user_id(); ?>">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="card card-blue mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <h5 class="card-title fw-bold mb-3 mt-3 title-cards text-uppercase"><?php echo esc_html('Pedidos'); ?>
            </h5><small>Mostra os 5 últimos</small>
            <hr>
            <div class="table-responsive">
                <table class="table table-striped
                table-hover
                table-borderless
                align-middle">
                    <thead>
                        <tr>
                            <th>Número do Pedido</th>
                            <th>D/H Pedido</th>
                            <th>D/H Aprovação</th>
                            <th>Nome do Produto</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
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

                        ?>
                        <tr>
                            <td data-label="Número do Pedido"><?php echo $order_number;?></td>
                            <td data-label="D/H pedido"><?php echo $order_date->format('d/m/Y H:i'); ?></td>
                            <td data-label="D/H Aprovação"><?php echo $order_end_date->format('d/m/Y H:i'); ?></td>
                            <td data-label="Nome do produto"><?php echo $product_names_string; ?></td>
                            <td data-label="Valor"><?php echo wc_price($total_price); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>