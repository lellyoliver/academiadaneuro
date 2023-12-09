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
                    <h1 class="fs-3 fw-bold">Confirme seu e-mail!</h1>
                    <h3 class="fs-6 fw-normal">Plataforma de Treinamento Cerebral para uso pessoal ou para pacientes de profissionais da
                        saúde
                    </h3>
                    <div class="mb-5"></div>
                    <form id="form-auth-email" method="post">
                        <input type="hidden" name="user_id" id="user_id" value="">
                        <input type="hidden" name="token" id="token" value="">
                        <button type="submit" class="btn btn-lg btn-primary col-12">Confirmar e-mail</button>
                        <div class="mb-3"></div>
                        <p class="mobile_text__footer">Já tem uma conta? <a href="<?php echo site_url('/login', 'https');?>">Faça o login!</a></p>
                    </form>
                </div>
            </div>
            <div class="col-md-7 bg-signin-photo"
                style="background-image:url(https://cdn.institutodeneurociencia.com.br/image/bg_login_1.jpg)"
                style="height:100vh;">
                <div class="box-signin-text d-flex align-items-center">
                    <img src="https://cdn.institutodeneurociencia.com.br/image/brain_icon.svg" width="50"
                        height="50" class="me-3">
                    <span>Observe o <b>progresso dos seus pacientes</b> <br>no treinamento de maneira personalizada.
                        <br> <b>Conheça mais <i class="fa-solid fa-arrow-right"></i></b></span>
                </div>
            </div>
        </div>
    </div>
</div>