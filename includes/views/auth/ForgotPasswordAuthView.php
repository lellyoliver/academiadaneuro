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
                    <h1 class="fs-3 fw-bold">Esqueci minha senha</h1>
                    <h3 class="fs-6 fw-normal">Mantenha-se atento! Você receberá um e-mail para verificação. Se não
                        encontrar nenhum e-mail, entre em contato com nosso suporte ao cliente.</h3>
                    <div class="mb-5"></div>
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
                        <button type="submit"
                            class="btn btn-lg btn-secondary col-12"><?php echo esc_html__('Redefinir Senha'); ?></button>

                        <p class="text_forgot_signin"></p>
                        <div class="mb-3"></div>
                        <p class="mobile_text__footer"><a href="<?php echo site_url('/login', 'https');?>">Voltar para o login</a> | Não
                            tem uma conta? <a href="<?php echo site_url('/register', 'https');?>">Crie uma!</a></p>
                    </form>
                </div>
            </div>
            <div class="col-md-7 bg-signin-photo"
                style="background-image:url(https://cdn.institutodeneurociencia.com.br/image/bg_forgot_1.jpg)">
                <div class="box-signin-text">
                    <img src="https://cdn.institutodeneurociencia.com.br/image/brain_icon_2.svg"
                        width="50" height="50" class="me-3">
                    <span>Acompanhe seus avanços e <b>estabeleça um ritmo<br> consistente</b> com seu treinamento
                        personalizado. <br><b>Conheça mais <i class="fa-solid fa-arrow-right"></i></b></span>
                </div>
            </div>
        </div>
    </div>
</div>