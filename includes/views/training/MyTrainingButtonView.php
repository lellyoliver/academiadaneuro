<?php
$current_user = wp_get_current_user();
$allowed_roles = ['training'];
if (array_intersect($allowed_roles, $current_user->roles)): ?>
    <a class="btn btn-sm btn-3" href="<?php echo site_url('/novo-treinamento', 'https') ?>"> <i
            class="fa-solid fa-clipboard-list"></i></a>
    <?php endif;?>