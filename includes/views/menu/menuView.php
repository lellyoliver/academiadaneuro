<ul class="nav-menu m-0">
    <?php if (array_intersect($role['nivel_2'], $role['current_user']->roles)): ?>
    <li>
        <a class="nav-link" href="<?php echo get_site_url(); ?>/dashboard">Dashboard</a>
    </li>
    <?php endif;?>

    <?php if (array_intersect($role['nivel_1'], $role['current_user']->roles)): ?>
    <li>
        <a class="nav-link" href="<?php echo get_site_url(); ?>/meus-treinamentos">Meus
            Treinamentos</a>
    </li>
    <?php endif;?>

    <?php if (array_intersect($role['nivel_2'], $role['current_user']->roles)): ?>
    <li>
        <a class="nav-link" href="<?php echo get_site_url(); ?>/meus-pacientes">Meus
            Pacientes</a>
    </li>
    <?php endif;?>

    <li>
        <a class="nav-link" href="<?php echo get_site_url(); ?>/meu-perfil">Perfil</a>
    </li>

    <li>
        <a class="nav-link" href="<?php echo wp_logout_url(site_url('/login', 'https')); ?>">Sair</a>
    </li>
</ul>