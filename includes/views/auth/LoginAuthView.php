<div class="main_sign">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 form_order">
                <div class="container">
                    <div class="w-100 d-flex mt-3 text-center">
                        <a class="navbar-brand-signin" href="<?php echo site_url('/login', 'https') ?>">
                            <img src="https://cdn.institutodeneurociencia.com.br/image/logo-vertical.svg"
                                alt="Logo">
                        </a>
                    </div>
                    <div class="spacing_signin"></div>
                    <h1 class="fs-2 fw-bold">Faça o login</h1>
                    <h3 class="fs-6 fw-normal">Plataforma de Treinamento Cerebral para uso pessoal ou para pacientes de profissionais da
                        saúde
                    </h3>
                    <div class="mb-5"></div>
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
                        <button type="submit" name="submit"
                            class="btn btn-lg btn-secondary col-12"><?php echo esc_html__('Entrar'); ?>
                        </button>
                        <div class="mb-3"></div>
                        <p class="mobile_text__footer"><a href="<?php echo site_url('/forgot-password', 'https'); ?>">Esqueceu sua senha?</a> | Não
                            tem uma conta? <a href="<?php echo site_url('/register', 'https'); ?>">Crie uma!</a></p>
                    </form>
                </div>
                <div class="mb-4"></div>
            </div>
            <div class="col-md-7 bg-signin-photo"
                style="background-image:url(https://cdn.institutodeneurociencia.com.br/image/bg_login_1.jpg)">
                <div class="box-signin-text">
                    <img src="https://cdn.institutodeneurociencia.com.br/image/brain_icon.svg" width="50"
                        height="50" class="me-3">
                    <span>Observe o <b>progresso dos seus pacientes</b> <br>no treinamento de maneira personalizada.
                        <br> <b>Conheça mais <i class="fa-solid fa-arrow-right"></i></b></span>
                </div>
            </div>
        </div>
    </div>
</div>