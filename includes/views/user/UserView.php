<?php
$current_user = wp_get_current_user();
$current_user_id = get_current_user_id();
$allowed_roles_1 = ['coachingRelation'];
$allowed_roles_2 = ['coach', 'health-pro', 'administrator', 'training'];
$allowed_roles_3 = ['training', 'administrator', 'coach'];
$data = get_user_meta($current_user_id, 'connected_user', true);
$billing_phone = get_user_meta($data, 'billing_phone', true);
$profissional = get_userdata($data);
$_plan_mensal_training = get_option('_plan_mensal_training');
$_plan_trimestral_training = get_option('_plan_trimestral_training');
$_plan_semestral_training = get_option('_plan_semestral_training');

?>
<div class="loading" style="display:none" id="loading">
    <div class="overlay"></div>
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

<form id="form-update" method="post" enctype="multipart/form-data">
    <div class="row d-flex align-items-center">
        <div class="col-md">
            <div class="row mb-3 perfil">
                <img id="avatar-preview" alt="user-perfil" class="img-perfil mb-3">
                <input type="file" class="display-none" name="avatar_file" id="avatar_file" accept="image/*" />
                <input type="hidden" name="post_id" id="post_id" value="<?php echo get_the_ID() ?>">
                <button class="btn btn-secondary btn-sm edit-pen-perfil" id="edit-avatar">
                    <i class="fa-solid fa-pen"></i></button>
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
                <?php endif;?>
                <div class="col-md-12 mb-3">
                    <span class="label-float">
                        <input type="password" id="user_pass" name="user_pass">
                        <label for="states"><?php echo esc_html('Alterar Senha'); ?></label>
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

<?php if (array_intersect($allowed_roles_2, $current_user->roles)): ?>
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
                            <h6><?php echo wc_price(get_post_meta($_plan_mensal_training, '_price', true)); ?></h6>
                            <p><?php echo $description = wc_get_product($_plan_mensal_training) ? wc_get_product($_plan_mensal_training)->get_description() : 'Descrição não encontrada'; ?>
                            </p>
                            <input type="hidden" name="product_id" value="<?php echo $_plan_mensal_training; ?>">
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
                            <h6><?php echo wc_price(get_post_meta($_plan_trimestral_training, '_price', true)); ?>
                            </h6>
                            <p><?php echo $description = wc_get_product($_plan_trimestral_training) ? wc_get_product($_plan_trimestral_training)->get_description() : 'Descrição não encontrada'; ?>
                            </p>
                            <input type="hidden" name="product_id" value="<?php echo $_plan_trimestral_training; ?>">
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
                            <h6><?php echo wc_price(get_post_meta($_plan_semestral_training, '_price', true)); ?>
                            </h6>
                            <p><?php echo $description = wc_get_product($_plan_semestral_training) ? wc_get_product($_plan_semestral_training)->get_description() : 'Descrição não encontrada'; ?>
                            </p>
                            <input type="hidden" name="product_id" value="<?php echo $_plan_semestral_training; ?>">
                            <input type="hidden" name="user_related_id" value="<?php echo $current_user_id ?>">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif;?>

<script>
document.getElementById('edit-avatar').addEventListener('click', function() {
    document.getElementById('avatar_file').click();
});
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
</script>