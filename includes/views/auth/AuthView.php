<div class="row">
    <div class="img-logo-login mb-5 p-5">
        <a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>"
            title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" style="color:#000;" rel="home">
            <?php
                    $header_logo = get_theme_mod('header_logo'); // Get custom meta-value.

                    if (!empty($header_logo)):
                    ?>
            <img src="<?php echo esc_url($header_logo); ?>"
                alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" />
            <?php
                    else:
                        echo esc_attr(get_bloginfo('name', 'display'));
                    endif;
                ?>
        </a>
    </div>
    <div class="col-md-4 bg-login-form g-0 p-5">
        <p class="text-center" id="alert-form-login"></p>
        <form method="POST" id="login-form">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="email" id="email-login" required>
                <label for="email-login">E-mail</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password-login" required>
                <label for="email-login">Senha</label>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary col-12" name="login-submit"><?php echo esc_html('LOGIN'); ?></button>
            </div>
            <p class="text-center">Não tem uma conta?<a href="" class=""> <u>Cadastre-se</ul></a></p>
        </form>

    </div>
    <div class="col-md-8 bg-login-foto g-0">
        <div class="img-login-foto"></div>
    </div>
</div>