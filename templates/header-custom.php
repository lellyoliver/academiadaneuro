<?php require_once plugin_dir_path(__FILE__) . '../includes/NotificationUser.php'; ?>
<!DOCTYPE html>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#00a9e7" />
    <?php wp_head();?>
    <!-- Adicione isso ao seu arquivo HTML -->
</head>

<?php
$navbar_scheme = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
$current_user = wp_get_current_user();
$allowed_roles_1 = ['coachingRelation', 'training', 'administrator'];
$allowed_roles_2 = ['coach', 'health-pro', 'administrator'];
$allowed_roles_3 = ['training'];


$user = new NotificationUser;
$messages = $user->updateNotification();
?>

<body id="body-home">
    <?php wp_body_open();?>

    <a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'lellyoliver');?></a>

    <div id="wrapper">
        <header id="header-home">
            <nav class="navbar navbar-expand-lg navbar-light bg-header">
                <div class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <?php if (array_intersect($allowed_roles_1, $current_user->roles)): ?>
                    <a class="navbar-brand mx-auto" href="<?php echo get_site_url(); ?>/dashboard">
                        <img src="https://cdn.institutodeneurociencia.com.br/image/logo-vertical-branco.svg" alt="Logo">
                    </a>
                    <?php else: ?>
                    <a class="navbar-brand mx-auto" href="<?php echo get_site_url(); ?>/meus-treinamentos">
                        <img src="https://cdn.institutodeneurociencia.com.br/image/logo-vertical-branco.svg" alt="Logo">
                    </a>
                    <?php endif;?>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <a type="button" id="closeOffcanvas"><i class="fa-solid fa-xmark"></i></a>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item display-mobile mb-5">
                                <a class="nav-link">
                                    <img src="https://cdn.institutodeneurociencia.com.br/image/logo-vertical.svg"
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
                                <a class="nav-link"
                                    href="<?php echo wp_logout_url(site_url('/login', 'https')); ?>">Sair</a>
                            </li>
                        </ul>
                    </div>
                    <div class="status-toggle dropdown">
                        <button class="btn btn-link" id="status-notify" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <?php if($messages){
                                echo '<span class="circle-notify"></span>';
                            } ?>
                        </button>
                        <?php if($messages):?>
                        <ul class="dropdown-menu dropdown-notify">
                            
                            <li class="notify_list__item fw-bold text-uppercase">
                                Notificações
                            </li>

                            <?php 
                            $messages_4 = $messages['message_4'];
                            if($messages_4):
                            ?>
                            <li class="notify_list__item">
                                <?php echo $messages_4;?>
                            </li>
                            <?php endif;?>

                            <?php 
                            $messages_1 = $messages['message_1'];
                            foreach ($messages_1 as $message_1):
                            if($message_1):
                            ?>
                            <li class="notify_list__item">
                                <?php echo $message_1;?>
                            </li>
                            <?php endif;endforeach;?>

                            <?php 
                            $messages_2 = $messages['message_2'];
                            
                            foreach ($messages_2 as $message_2):
                            if($message_2):
                            ?>
                            <li class="notify_list__item">
                                <?php echo $message_2;?>
                            </li>
                            <?php endif; endforeach;?>

                            <?php 
                            $messages_3 = $messages['message_3'];
                            if($messages_3):
                            ?>
                            <li class="notify_list__item">
                                <?php echo $messages_3;?>
                            </li>
                            <?php endif;?>

                            <?php 
                            $messages_5 = $messages['message_5'];
                            if($messages_5):
                            ?>
                            <li class="notify_list__item">
                                <?php echo $messages_5;?>
                            </li>
                            <?php endif;?>
                            
                        </ul>
                        <?php endif;?>

                    </div>

                </div>
            </nav>
        </header>

        <main id="main-custom" class="container">
            <?php
// If Single or Archive (Category, Tag, Author or a Date based page).
if (is_single()):
?>
            <div class="row">
                <div class="col-md-12">
                    <?php
endif;
?>