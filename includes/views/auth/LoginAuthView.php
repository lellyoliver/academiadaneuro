<div class="main_sign">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 form_order">
                <div class="container">
                    <div class="w-100 d-flex mt-3 text-center">
                        <a class="navbar-brand-signin">
                            <img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/08/logo-ADC_01.svg"
                                alt="Logo">
                        </a>
                    </div>
                    <div class="spacing_signin"></div>
                    <h1 class="fs-3 fw-bold">Faça o login</h1>
                    <h3 class="fs-6 fw-normal">Plataforma de Treinamento Cerebral para estudantes e profissionais da
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
                            </span>
                        </div>
                        <button type="submit" name="submit"
                            class="btn btn-lg btn-primary col-12"><?php echo esc_html__('Entrar'); ?>
                        </button>
                        <div class="mb-3"></div>
                        <p><a href="<?php echo site_url('/forgot-password', 'https');?>">Esqueceu sua senha?</a> | Não tem uma conta? <a href="<?php echo site_url('/register', 'https');?>">Crie uma!</a></p>
                    </form>
                </div>
                <div class="mb-4"></div>
            </div>
            <div class="col-md-7 bg-signin-photo">
            </div>
        </div>
    </div>
</div>