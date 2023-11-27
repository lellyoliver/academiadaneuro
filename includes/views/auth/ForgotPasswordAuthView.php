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
                    <h1 class="fs-3 fw-bold">Venha fazer parte conosco!</h1>
                    <h3 class="fs-6 fw-normal">Plataforma de Treinamento Cerebral para estudantes e profissionais da
                        saúde
                    </h3>
                    <div class="mb-5"></div>
                    <form id="form-auth-forgot-password" method="post">
                        <div id="alert"></div>
                        <span class="label-float">
                            <input type="text" id="data_register" name="data_register"
                                onchange="this.value = formatCPFOrCNPJ(this.value)" />
                            <label for="data_register"><?php echo esc_html__('CPF/CNPJ'); ?></label>
                        </span>
                        <div class="mb-3"></div>
                        <span id="forgot-password"></span>
                        <div class="mb-3"></div>
                        <button type="submit"
                            class="btn btn-lg btn-primary col-12"><?php echo esc_html__('Redefinir Senha'); ?></button>
                    </form>
                </div>
                <div class="mb-4"></div>

            </div>
            <div class="col-md-7 bg-signin-photo">
            </div>
        </div>
    </div>
</div>