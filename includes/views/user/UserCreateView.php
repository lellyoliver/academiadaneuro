<div class="loading" style="display:none" id="loading">
    <div class="overlay"></div>
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
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
                    <h1 class="fs-3 fw-bold">Venha fazer parte conosco!</h1>
                    <h3 class="fs-6 fw-normal">Plataforma de Treinamento Cerebral para uso pessoal ou para pacientes de profissionais da
                        saúde
                    </h3>
                    <div class="mb-5"></div>
                    <form id="form-create" method="post">
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="name" name="name" />
                                <label for="name"><?php echo esc_html__('Nome Completo'); ?></label>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="billing_data" name="billing_data"
                                    onchange="this.value = formatCPFOrCNPJ(this.value)" />
                                <label for="billing_data"><?php echo esc_html__('CPF ou CNPJ'); ?></label>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="email" name="email" />
                                <label for="email"><?php echo esc_html__('E-mail'); ?></label>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="city" name="city" />
                                <label for="city"><?php echo esc_html__('Cidade'); ?></label>
                            </span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <span class="label-float">
                                    <input type="text" id="phone" name="phone"
                                        onchange="this.value = formatPhone(this.value)" />
                                    <label for="phone"><?php echo esc_html__('Telefone'); ?></label>
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <span class="label-float label-select">
                                    <select class="form-select" name="role" id="role">
                                        <option selected><?php echo esc_html__('Selecione'); ?>
                                        </option>
                                        <option value="health-pro">
                                            <?php echo esc_html__('Profissional da Saúde'); ?>
                                        </option>
                                        <option value="coach">
                                            <?php echo esc_html__('Profissional da Educação'); ?>
                                        </option>
                                        <option value="training">
                                            <?php echo esc_html__('Uso Pessoal'); ?></option>
                                    </select>
                                    <label for="role"
                                        class="form-label"><?php echo esc_html__('Área de Atuação'); ?></label>
                                </span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="label-float">
                                <input type="password" id="password" name="password" />
                                <label for="password"><?php echo esc_html__('Senha'); ?></label>
                                <p style="font-size:12px;">
                                    <?php echo esc_html__('*8 a 12 dígitos, letra maiúscula e número.'); ?>
                                </p>
                            </span>
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="termsAndServices"
                                    name="termsAndServices" />
                                <label class="form-check-label" for="termsAndServices">
                                    Eu aceito os <a href="#">termos</a> e <a href="#">serviços</a>
                                </label>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-lg btn-secondary col-12"><?php echo esc_html__('Começar Agora'); ?>
                        </button>
                        <div class="mb-3"></div>
                        <p class="mobile_text__footer">Já tem uma conta? <a href="<?php echo site_url('/login', 'https');?>">Faça o login!</a></p>
                    </form>
                </div>
                <div class="mb-4"></div>
            </div>
            <div class="col-md-7 bg-signin-photo"
                style="background-image:url(https://cdn.institutodeneurociencia.com.br/image/bg_signin_1.jpg)">
                <div class="box-signin-text">
                    <img src="https://cdn.institutodeneurociencia.com.br/image/brain_icon_4.svg" width="50"
                        height="50" class="me-3">
                    <span>Alcance seu potencial máximo<br>
                        com <b>orientação especializada!</b><br><b>Conheça mais <i
                                class="fa-solid fa-arrow-right"></i></b></span>
                </div>
            </div>
        </div>
    </div>
</div>