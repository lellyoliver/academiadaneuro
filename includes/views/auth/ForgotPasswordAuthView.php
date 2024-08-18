<form id="form-auth-forgot-password" method="post">
    <div id="alert"></div>
    <span class="label-float">
        <input type="text" id="data_register" name="data_register"
            onchange="this.value = formatCPFOrCNPJ(this.value)" />
        <label for="data_register"><?php echo esc_html__('CPF/CNPJ/Nome de Usuário*'); ?></label>
    </span>
    <div class="mb-3"></div>
    <span id="forgot-password"></span>
    <div class="mb-3"></div>
    <button type="submit" class="btn btn-lg btn-secondary col-12"><?php echo esc_html__('Redefinir Senha'); ?></button>

    <p class="text_forgot_signin"></p>
    <div class="mb-3"></div>
    <p class="mobile_text__footer"><a href="<?php echo site_url('/login', 'https');?>">Voltar para o login</a> | Não
        tem uma conta? <a href="<?php echo site_url('/register', 'https');?>">Crie uma!</a></p>
</form>