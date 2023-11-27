<!DOCTYPE html>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head();?>
</head>

<?php
$navbar_scheme = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
$current_user = wp_get_current_user();
$allowed_roles_1 = ['coachingRelation', 'training', 'administrator'];
$allowed_roles_2 = ['coach', 'health-pro', 'administrator'];

?>

<body id="body-home">

    <?php wp_body_open();?>

    <a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'lellyoliver');?></a>

    <div id="wrapper">
        <header id="header-home">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand mx-auto" href="#">
                        <img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/08/logo-ADC_01.svg"
                            alt="Logo">
                    </a>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <a type="button" id="closeOffcanvas"><i class="fa-solid fa-xmark"></i></a>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item display-mobile mb-5">
                                <a class="nav-link">
                                    <img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/08/logo-ADC_01.svg"
                                        alt="Logo" width="150">
                                </a>
                            </li>

                            <?php if (array_intersect($allowed_roles_2, $current_user->roles)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo get_site_url(); ?>/dashboard">Dashboard</a>
                            </li>
                            <?php endif;?>

                            <?php if (array_intersect($allowed_roles_1, $current_user->roles)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo get_site_url(); ?>/meus-treinamentos">Meus
                                    Treinamentos</a>
                            </li>
                            <?php endif;?>

                            <?php ///if (in_array('health-pro', $current_user->roles)): ?>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="<?php //echo get_site_url(); ?>/cursos">Cursos</a>
                            </li> -->
                            <?php ////endif;?>

                            <?php if (array_intersect($allowed_roles_2, $current_user->roles)): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo get_site_url(); ?>/meus-pacientes">Meus
                                    Pacientes</a>
                            </li>
                            <?php endif;?>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo get_site_url(); ?>/meu-perfil">Perfil</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo wp_logout_url( site_url( '/login', 'https' ) ); ?>">Sair</a>
                            </li>
                        </ul>
                    </div>
                    <div class="status-toggle dropdown">
                        <button class="btn btn-link" id="status-notify" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span class="circle"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-notify">
                            <li><a class="dropdown-item">Menu</a></li>
                            <li><a class="dropdown-item" href="#">O paciente</a></li>
                            <li><a class="dropdown-item" href="#">Novidades</a></li>
                            <li><a class="dropdown-item" href="#">Comentários</a></li>
                        </ul>

                    </div>

                </div>
            </nav>
        </header>

        <main id="main" class="container"
            <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position): echo ' style="padding-top: 0px;"';elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position): echo ' style="padding-bottom: 0px;"';endif;?>>
            <?php
// If Single or Archive (Category, Tag, Author or a Date based page).
if (is_single()):
?>
            <div class="row">
                <div class="col-md-12">
                    <?php
endif;
?>