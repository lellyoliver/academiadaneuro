<div class="card mt-2 mb-3">
    <div class="container p-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="card-title"><?php echo esc_html('Lista de Usuário'); ?></h2>
                </div>
                <div class="col-md-6 d-flex justify-content-end float-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalAddUserRelated">
                        <?php echo esc_html('Adicionar novo usuário'); ?>
                    </button>
                </div>
            </div>
            <form id="form-create" method="post">
                <div class="mb-3">
                    <label for="name" class="mb-2"><?php echo esc_html('Nome / Razão Social'); ?></label>
                    <input class="form-control" type="text" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="mb-2"><?php echo esc_html('Email'); ?></label>
                    <input class="form-control" type="email" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="billing_data" class="mb-2"><?php echo esc_html('CNPJ/CPF'); ?></label>
                    <input class="form-control" type="text" id="billing_data" name="billing_data">
                </div>
                <div class="mb-3">
                    <label for="phone" class="mb-2"><?php echo esc_html('Telefone'); ?></label>
                    <input class="form-control" type="text" id="phone" name="phone">
                </div>
                <?php if (is_page(11)): ?>
                <div class="mb-3">
                    <label for="role" class="mb-2"><?php echo esc_html('Área de Atuação'); ?></label>
                    <select class="form-control" id="role" name="role">
                        <option value="health-pro">Profissional da Saúde</option>
                        <option value="coach">Profissional da Educação</option>
                        <option value="training">Quero apenas para treinamento</option>
                    </select>
                </div>
                <?php endif;?>

                <?php if (is_page(18)): ?>
                <input type="hidden" name="role" value="coachingRelation">
                <input type="hidden" name="meta_user" value="<?php echo get_current_user_id(); ?>">
                <?php endif;?>

                <div class="mb-3">
                    <label for="address" class="mb-2"><?php echo esc_html('Endereço'); ?></label>
                    <input class="form-control" type="text" id="address" name="address">
                </div>
                <div class="mb-3">
                    <label for="city" class="mb-2"><?php echo esc_html('Cidade'); ?></label>
                    <input class="form-control" type="text" id="city" name="city">
                </div>
                <div class="mb-3">
                    <label for="cep" class="mb-2"><?php echo esc_html('CEP'); ?></label>
                    <input class="form-control" type="text" id="cep" name="cep">
                </div>
                <div class="mb-3">
                    <label for="states" class="mb-2"><?php echo esc_html('Estado'); ?></label>
                    <input class="form-control" type="text" id="states" name="states">
                </div>
                <div class="mb-3">
                    <label for="password" class="mb-2"><?php echo esc_html('Senha'); ?></label>
                    <input class="form-control" type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary"><?php echo esc_html('Criar usuário'); ?></button>
            </form>
        </div>
    </div>
</div>