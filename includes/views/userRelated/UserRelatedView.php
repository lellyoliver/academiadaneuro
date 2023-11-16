<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <div class="d-flex align-items-center align-self-center mb-3">
                <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                    <?php echo esc_html('Meus Pacientes'); ?>
                </h6>
                <button type="submit" class="btn btn-secondary me-2" data-bs-target="#cartUserRelated"
                    data-bs-toggle="offcanvas">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>
                <?php if ($can_register): ?>
                <a role="button" class="btn btn-secondary display-desktop" data-bs-toggle="offcanvas"
                    data-bs-target="#viewCreateRelated" id="btn_user"><i class="fa-solid fa-user-plus"></i>
                </a>
                <?php endif;?>
            </div>

            <table class="table" id="tableRelated" data-toggle="table" data-pagination="true" data-page-size="3"
                data-search="false" data-pagination-parts="[pageList]">
                <thead>
                    <tr>
                        <th data-field="display_name">Nome do Paciente</th>
                        <th data-field="user_email">E-mail</th>
                        <th data-field="description">Quadro Clinico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
foreach ($getUser as $getUsers): ?>
                    <tr class="view-user" data-bs-toggle="offcanvas" data-bs-target="#viewUserRelated"
                        data-userid="<?php echo $getUsers['ID']; ?>" id="list-<?php echo $getUsers['ID']; ?>">
                        <td data-label="Nome do Paciente"><?php echo $getUsers['billing_first_name']; ?></td>
                        <td data-label="E-mail"><?php echo $getUsers['user_email']; ?></td>
                        <td data-label="Quadro Clinico"><?php echo $getUsers['description']; ?></td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            <?php if ($can_register): ?>
            <div class="row m-0 m-auto mt-3 display-mobile">
                <button type="button" class="btn btn-lg btn-secondary" data-bs-toggle="offcanvas"
                    data-bs-target="#viewCreateRelated" id="btn_user"><i class="fa-solid fa-user-plus me-5"></i> Novo
                    Paciente
                </button>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>


<!-- Modal Create -->
<?php if ($can_register): ?>
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewCreateRelated" aria-labelledby="offcanvasBottomLabel"
    style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Adicione um novo paciente</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="form-create" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <span class="label-float">
                            <input type="text" id="name" name="name">
                            <label for="name" class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float">
                            <input type="text" id="billing_data" name="billing_data">
                            <label for="billing_data" class="mb-2"><?php echo esc_html('CPF / CNPJ'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="email" id="email" name="email">
                            <label for="email" class="mb-2"><?php echo esc_html('Email'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <textarea id="description" name="description" style="height: 200px"></textarea>
                            <label for="description"
                                class="mb-2 textarea"><?php echo esc_html('Quadro Clínico'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="text" id="phone" name="phone">
                            <label for="phone" class="mb-2"><?php echo esc_html('Telefone'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="password" id="password" name="password">
                            <label for="password" class="mb-2"><?php echo esc_html('Senha'); ?></label>
                        </span>
                    </div>
                </div>
                <input type="hidden" name="role" value="coachingRelation">
                <input type="hidden" name="connected_user" value="<?php echo get_current_user_id(); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-create">Cancelar</button>
                <button type="submit" class="btn btn-primary"><?php echo esc_html('Criar Usuário'); ?></button>
            </div>
        </form>
    </div>
</div>
<?php endif;?>
<!-- end Modal Create -->


<!-- Modal Update -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewUserRelated" aria-labelledby="offcanvasBottomLabel"
    style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Visualizar paciente</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="form-update" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <span class="label-float">
                            <input type="text" id="nameUpdate" name="nameUpdate">
                            <label for="nameUpdate" class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="email" id="emailUpdate" name="emailUpdate">
                            <label for="emailUpdate" class="mb-2"><?php echo esc_html('Email'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <textarea id="descriptionUpdate" name="descriptionUpdate" style="height: 200px"></textarea>
                            <label for="descriptionUpdate"
                                class="mb-2 textarea"><?php echo esc_html('Quadro Clínico'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="text" id="phoneUpdate" name="phoneUpdate">
                            <label for="phoneUpdate" class="mb-2"><?php echo esc_html('Telefone'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="password" id="passwordUpdate" name="passwordUpdate">
                            <label for="passwordUpdate" class="mb-2"><?php echo esc_html('Senha'); ?></label>
                        </span>
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
        </form>
    </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="cartUserRelated" aria-labelledby="planos"
    style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="planos" style="margin-right:12px;">Selecione o plano desejado para este novo
            paciente:</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="row">
            <div class="col-md mb-4">
                <form method="post">
                    <div class="card card-plans" onclick="this.closest('form').submit()">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Plano Bronze</span>
                            <h5 class="card-title fw-bold">Assinatura Mensal</h5>
                            <p class="card-text">Seu paciente terá acesso durante um mês à mentoria e aos exercícios de
                                estimulação cerebral.</p>
                            <input type="hidden" name="product_id" value="26">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md mb-4">
                <form method="post">
                    <div class="card card-plans" onclick="this.closest('form').submit()">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Plano Prata</span>
                            <h5 class="card-title fw-bold">Assinatura Semestral</h5>
                            <p class="card-text">Acesso semestral à mentoria e aos exercícios de estimulação cerebral
                                para um compromisso mais prolongado.</p>
                            <input type="hidden" name="product_id" value="109">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md mb-4">
                <form method="post">
                    <div class="card card-plans" onclick="this.closest('form').submit()">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Plano Premium</span>
                            <h5 class="card-title fw-bold">Assinatura Anual</h5>
                            <p class="card-text">Acesso anual à mentoria e aos exercícios de estimulação cerebral para
                                um compromisso de longo prazo.</p>
                            <input type="hidden" name="product_id" value="110">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>