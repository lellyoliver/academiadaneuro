<?php
$_plan_mensal_coachingRelation = get_option('_plan_mensal_coachingRelation');
$_plan_trimestral_coachingRelation = get_option('_plan_trimestral_coachingRelation');
$_plan_semestral_coachingRelation = get_option('_plan_semestral_coachingRelation');
?>
<div class="loading" style="display:none" id="loading">
    <div class="overlay"></div>
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<table class="table" id="tableRelated" data-toggle="table" data-search="true" data-pagination="true" data-page-size="5"
    data-pagination-parts="[pageList]">
    <thead>
        <tr>
            <th data-field="display_name">Nome do Paciente</th>
            <th data-field="user_email">E-mail</th>
            <th data-field="description">Quadro Clínico</th>
            <th data-field="status"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($getUser as $getUsers): ?>
        <tr class="view-user" data-bs-toggle="offcanvas" data-bs-target="#viewUserRelated"
            data-userid="<?php echo $getUsers['ID']; ?>" id="list-<?php echo $getUsers['ID']; ?>">
            <td data-label="Nome do Paciente"><?php echo $getUsers['billing_first_name']; ?></td>
            <td data-label="E-mail"><?php echo $getUsers['user_email']; ?></td>
            <td data-label="Quadro Clínico"><?php echo $getUsers['description']; ?></td>
            <td class="status" style="background-color:transparent!important;">
                <button type="submit" class="btn btn-sm btn-secondary me-2 mb-1 view-cart"
                    id="cart-user-<?php echo $getUsers['ID']; ?>" data-bs-target="#cartUserRelated"
                    data-bs-toggle="offcanvas" data-userid="<?php echo $getUsers['ID']; ?>">
                    <i class="fa-solid fa-cart-shopping"></i>
                </button>
                <?php
                if (!empty($expired)) {
                    foreach ($expired as $expireds) {
                        if ($expireds['user_id'] == $getUsers['ID']) {
                            if ($expireds['status']) {
                                echo '<i data-bs-toggle="tooltip" data-bs-placement="right" title="ativo" class="fa-solid fa-circle-check check__mobile color-success" style="font-size:16px;"></i>';
                            } else {
                                echo '<i data-bs-toggle="tooltip" data-bs-placement="right" title="inativo" class="fa-solid fa-triangle-exclamation check__mobile color-danger" style="font-size:16px;"></i>';
                            }
                        }
                    }
                }
                ?>
            </td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>
<div class="row m-0 m-auto mt-3 display-mobile">
    <button type="button" class="btn btn-lg btn-secondary" data-bs-toggle="offcanvas"
        data-bs-target="#viewCreateRelated" id="btn_user"><i class="fa-solid fa-user-plus me-5"></i> Novo
        Paciente
    </button>
</div>


<!-- Modal Create -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewCreateRelated" style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h6 class="card-title fw-bold title-cards text-uppercase">Adicione um novo paciente</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="form-create" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <span class="label-float">
                            <input type="text" id="name" name="name">
                            <label for="name" class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="label-float">
                            <input type="date" id="date_birth" name="date_birth">
                            <label for="date_birth" class="mb-2"><?php echo esc_html('Data de Nascimento'); ?></label>
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
                <input type="hidden" name="connected_user" value="<?php echo get_current_user_id(); ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal" id="cancel-create">Cancelar</button>
                <button type="submit" class="btn btn-secondary"><?php echo esc_html('Criar Usuário'); ?></button>
            </div>
        </form>
    </div>
</div>
<!-- end Modal Create -->


<!-- Modal Update -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewUserRelated" style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">Visualizar paciente</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="form-update" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <span class="label-float">
                            <input type="text" id="nameUpdate" name="nameUpdate">
                            <label for="nameUpdate" class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="label-float">
                            <input type="date" id="date_birthUpdate" name="date_birthUpdate">
                            <label for="date_birthUpdate"
                                class="mb-2"><?php echo esc_html('Data de Nascimento'); ?></label>
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
                            <a href="" target="_blank" class="btn whatsapp_button" id="phone_wpp"><i
                                    class="fa-brands fa-whatsapp"></i></a>
                        </span>
                    </div>
                    <div class="col-md-12 mb-3">
                        <span class="label-float mb-3">
                            <input type="password" id="passwordUpdate" name="passwordUpdate">
                            <label for="passwordUpdate" class="mb-2"><?php echo esc_html('Alterar Senha'); ?></label>
                        </span>
                    </div>
                </div>
                <input type="hidden" name="user_id" id="userId" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger-custom me-2" id="deleteUser"><i
                        class="fa-solid fa-trash"></i></button>
                <button type="submit" class="btn btn-secondary"
                    id="updateUser"><?php echo esc_html('Atualizar'); ?></button>
            </div>
        </form>
    </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="cartUserRelated" aria-labelledby="planos"
    style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0" id="planos" style="margin-right:12px;">
            Selecione o plano desejado para este novo
            paciente:</h6>
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
                            <h6><?php echo wc_price(get_post_meta($_plan_mensal_coachingRelation, '_price', true)); ?>
                            </h6>
                            <p><?php echo $description = wc_get_product($_plan_mensal_coachingRelation) ? wc_get_product($_plan_mensal_coachingRelation)->get_description() : 'Descrição não encontrada'; ?>
                            </p>
                            <input type="hidden" name="product_id"
                                value="<?php echo $_plan_mensal_coachingRelation; ?>">
                            <input type="hidden" name="user_related_id" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md mb-4">
                <form method="post">
                    <div class="card card-plans" onclick="this.closest('form').submit()">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Plano Prata</span>
                            <h5 class="card-title fw-bold">Assinatura Trimestral</h5>
                            <h6><?php echo wc_price(get_post_meta($_plan_trimestral_coachingRelation, '_price', true)); ?>
                            </h6>
                            <p><?php echo $description = wc_get_product($_plan_trimestral_coachingRelation) ? wc_get_product($_plan_trimestral_coachingRelation)->get_description() : 'Descrição não encontrada'; ?>
                            </p>
                            <input type="hidden" name="product_id"
                                value="<?php echo $_plan_trimestral_coachingRelation; ?>">
                            <input type="hidden" name="user_related_id" value="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md mb-4">
                <form method="post">
                    <div class="card card-plans" onclick="this.closest('form').submit()">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Plano Premium</span>
                            <h5 class="card-title fw-bold">Assinatura Semestral</h5>
                            <h6><?php echo wc_price(get_post_meta($_plan_semestral_coachingRelation, '_price', true)); ?>
                            </h6>
                            <p><?php echo $description = wc_get_product($_plan_semestral_coachingRelation) ? wc_get_product($_plan_semestral_coachingRelation)->get_description() : 'Descrição não encontrada'; ?>
                            </p>
                            <input type="hidden" name="product_id"
                                value="<?php echo $_plan_semestral_coachingRelation; ?>">
                            <input type="hidden" name="user_related_id" value="">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>