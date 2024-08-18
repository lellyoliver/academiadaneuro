<form id="form-auth-email" method="post">
    <input type="hidden" name="user_id" id="user_id" value="">
    <input type="hidden" name="token" id="token" value="">
    <button type="submit" class="btn btn-lg btn-secondary col-12">Confirmar e-mail</button>
    <div class="mb-3"></div>
    <p class="mobile_text__footer">Já tem uma conta? <a href="<?php echo site_url('/login', 'https');?>">Faça o
            login!</a></p>
</form>