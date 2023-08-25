<div class="card card-blue-dark mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <h6 class="card-title fw-bold mb-3 mt-3 title-cards text-uppercase">
                <?php echo esc_html('Meus Pacientes'); ?>
                <?php if ($can_register): ?>
                <a role="button" class="btn btn-sm btn-primary font-uppercase fw-bold btn-user" data-bs-toggle="modal"
                    data-bs-target="#modalAddUserRelated">
                    <i class="fa-solid fa-user-plus"></i>
                </a>
                <?php endif;?>
                <a role="button"
                    href="https://lellyoliver.com.br/academiadaneurociencia/product/estimulacao-cerebral-menrsal/"
                    class="btn btn-sm btn-primary font-uppercase fw-bold btn-buy">Comprar Agora <i
                        class="fa-solid fa-cart-shopping"></i></a>

            </h6>
            <hr>
            <table class="table" id="tableRelated" data-toggle="table" data-pagination="true" data-page-size="5"
                data-search="false" data-pagination-parts="[pageList]">
                <p class="mb-3 mt-3 display-mobile text-center"><small><i class="fa-solid fa-hand"></i> Click para ver
                        mais</small>
                <p>
                    <thead>
                        <tr>
                            <th data-field="display_name">Nome do Paciente</th>
                            <th data-field="user_email">E-mail</th>
                            <th data-field="description">Quadro Clinico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listUser as $listUsers): ?>
                        <tr class="view-user" data-bs-toggle="modal" data-bs-target="#modalViewUserRelated"
                            data-userid="<?php echo $listUsers->ID; ?>">
                            <td data-label="Nome do Paciente"><?php echo $listUsers->display_name; ?></td>
                            <td data-label="E-mail"><?php echo $listUsers->user_email; ?></td>
                            <td data-label="Quadro Clinico"><?php echo $listUsers->description; ?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal Related -->

<div class="modal fade" id="modalAddUserRelated" aria-hidden="true" data-bs-keyboard="true"
    aria-labelledby="modalAddUserRelated">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><?php echo esc_html('Adicionar novo usuário'); ?>
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-create" method="post">
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="name" name="name">
                        <label for="name" class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="billing_data" name="billing_data">
                        <label for="billing_data" class="mb-2"><?php echo esc_html('CPF / CNPJ'); ?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="email" id="email" name="email">
                        <label for="email" class="mb-2"><?php echo esc_html('Email'); ?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="description" name="description"
                            style="height: 200px"></textarea>
                        <label for="description" class="mb-2"><?php echo esc_html('Quadro Clínico'); ?></label>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="phone" name="phone">
                                <label for="phone" class="mb-2"><?php echo esc_html('Telefone'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="cep" name="cep">
                                <label for="cep" class="mb-2"><?php echo esc_html('CEP'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="address" name="address">
                        <label for="address" class="mb-2"><?php echo esc_html('Endereço'); ?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="city" name="city">
                        <label for="city" class="mb-2"><?php echo esc_html('Cidade'); ?></label>
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" id="states" name="states">
                        <label for="states" class="mb-2"><?php echo esc_html('Estado'); ?></label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" type="password" id="password" name="password">
                        <label for="password" class="mb-2"><?php echo esc_html('Senha'); ?></label>
                    </div>
                    <input type="hidden" name="role" value="coachingRelation">
                    <input type="hidden" name="connected_user" value="<?php echo get_current_user_id(); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-gray" data-bs-dismiss="modal"
                        id="cancel-create">Cancelar</button>
                    <?php if ($can_register): ?>
                    <button type="submit"
                        class="btn btn-primary"><?php echo esc_html('Salvar novo usuário'); ?></button>
                    <?php endif;?>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Update -->
<div class="modal fade" id="modalViewUserRelated" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1"
    aria-hidden="true" aria-labelledby="modalViewUserRelated">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="viewer-name"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="nameUpdate" name="name">
                                <label for="nameUpdate"
                                    class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="email" id="emailUpdate" name="email">
                                <label for="emailUpdate" class="mb-2"><?php echo esc_html('Email'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="descriptionUpdate" name="description"
                                    style="height: 200px"></textarea>
                                <label for="descriptionUpdate"
                                    class="mb-2"><?php echo esc_html('Quadro Clínico'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="phoneUpdate" name="phone">
                                <label for="phoneUpdate" class="mb-2"><?php echo esc_html('Telefone'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="cepUpdate" name="cep">
                                <label for="cepUpdate" class="mb-2"><?php echo esc_html('CEP'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="addressUpdate" name="address">
                                <label for="addressUpdate" class="mb-2"><?php echo esc_html('Endereço'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="cityUpdate" name="city">
                                <label for="cityUpdate" class="mb-2"><?php echo esc_html('Cidade'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="text" id="statesUpdate" name="states">
                                <label for="statesUpdate" class="mb-2"><?php echo esc_html('Estado'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input class="form-control" type="password" id="passwordUpdate" name="password">
                                <label for="passwordUpdate" class="mb-2"><?php echo esc_html('Senha'); ?></label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_id" id="userId" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-create">Sair</button>
                    <button type="button" class="btn btn-danger" id="deleteUser">Excluir</button>
                    <button type="submit" class="btn btn-primary"
                        id="updateUser"><?php echo esc_html('Atualizar'); ?></button>
                </div>
                <div id="message"></div>
            </form>
        </div>
    </div>
</div>