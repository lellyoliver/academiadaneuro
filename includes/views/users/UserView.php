<h2 class="mb-5"><?php echo esc_html('Criar novo usuário'); ?></h2>
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
        <label for="password" class="mb-2"><?php echo esc_html('Senha'); ?></label>
        <input class="form-control" type="password" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="cnpj" class="mb-2"><?php echo esc_html('CNPJ'); ?></label>
        <input class="form-control" type="text" id="cnpj" name="cnpj">
    </div>
    <div class="mb-3">
        <label for="phone" class="mb-2"><?php echo esc_html('Telefone'); ?></label>
        <input class="form-control" type="text" id="phone" name="phone">
    </div>
    <div class="mb-3">
        <label for="cep" class="mb-2"><?php echo esc_html('CEP'); ?></label>
        <input class="form-control" type="text" id="cep" name="cep">
    </div>
    <div class="mb-3">
        <label for="address" class="mb-2"><?php echo esc_html('Endereço'); ?></label>
        <input class="form-control" type="text" id="address" name="address">
    </div>
    <div class="mb-3">
        <label for="number_house" class="mb-2"><?php echo esc_html('Número'); ?></label>
        <input class="form-control" type="text" id="number_house" name="number_house">
    </div>
    <div class="mb-3">
        <label for="neighborhood" class="mb-2"><?php echo esc_html('Bairro'); ?></label>
        <input class="form-control" type="text" id="neighborhood" name="neighborhood">
    </div>
    <button type="submit" class="btn btn-primary"><?php echo esc_html('Criar usuário'); ?></button>
</form>