<div class="main-sign">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5 form-order">
                <div class="container">
                    <div class="w-100 d-flex mt-3 text-center">
                        <a class="navbar-brand-signin">
                            <img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/08/logo-ADC_01.svg"
                                alt="Logo">
                        </a>
                    </div>
                    <div class="spacing-signin"></div>
                    <h1 class="fs-3 fw-bold">Venha fazer parte conosco!</h1>
                    <h3 class="fs-6 fw-normal">Plataforma de Treinamento Cerebral para estudantes e profissionais da
                        saúde
                    </h3>
                    <div class="mb-5"></div>
                    <form id="form-create" method="post">
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="name" name="name" />
                                <label for="name"><?php echo esc_html('Nome Completo'); ?></label>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="billing_data" name="billing_data" />
                                <label for="billing_data"><?php echo esc_html('CNPJ OU CPF'); ?></label>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="email" name="email" />
                                <label for="email"><?php echo esc_html('Cidade'); ?></label>
                            </span>
                        </div>
                        <div class="mb-3">
                            <span class="label-float">
                                <input type="text" id="city" name="city" />
                                <label for="city"><?php echo esc_html('Cidade'); ?></label>
                            </span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <span class="label-float">
                                    <input type="text" id="phone" name="phone" />
                                    <label for="phone"><?php echo esc_html('Telefone'); ?></label>
                                </span>
                            </div>
                            <div class="mb-3 col-md-6">
                                <span class="label-float label-select">
                                    <select class="form-select" name="role" id="role">
                                        <option selected>Selecione</option>
                                        <option value="health-pro">Profissional da Saúde</option>
                                        <option value="coach">Profissional da Educação</option>
                                        <option value="training">Outras àreas</option>
                                    </select>
                                    <label for="" class="form-label"><?php echo esc_html('Área de Atuação'); ?></label>
                                </span>
                            </div>

                        </div>

                        <div class="mb-3">
                            <span class="label-float">
                                <input type="password" id="password-signin" name="password-signin" />
                                <label for="password-signin"><?php echo esc_html('Senha'); ?></label>
                                <p style="font-size:12px;">*8 a 12 dígitos, letra maiúscula e número.</p>
                            </span>
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="termsAndServices">
                                <label class="form-check-label" for="termsAndServices">
                                    Você aceita os <a><u>termos</u></a> e <a><u>serviços</u></a>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-lg btn-primary col-12">Começar Agora</button>
                    </form>
                </div>
                <div class="mb-4"></div>

            </div>
            <div class="col-md-7 bg-signin-photo">
            </div>
        </div>
    </div>
</div>