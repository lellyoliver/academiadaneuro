<form method="post">
    <div id="alert"></div>
    <div class="mb-3">
        <span class="label-float">
            <input type="text" id="username" name="user_name" />
            <label for="email"><?php echo esc_html__('E-mail'); ?></label>
        </span>
    </div>
    <div class="mb-3">
        <span class="label-float">
            <input type="password" id="user-password" name="user_password" />
            <label for="password"><?php echo esc_html__('Senha'); ?></label>
            <i class="fa-solid fa-eye-slash" id="show-password"></i>
        </span>
    </div>
    <button type="submit" name="submit" class="btn btn-lg btn-secondary col-12"><?php echo esc_html__('Entrar'); ?>
    </button>
    <div class="mb-3"></div>
    <p class="mobile_text__footer"><a href="<?php echo site_url('/forgot-password', 'https'); ?>">Esqueceu sua
            senha?</a> | Não
        tem uma conta? <a href="<?php echo site_url('/register', 'https'); ?>">Crie uma!</a></p>
</form>