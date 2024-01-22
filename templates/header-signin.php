<!DOCTYPE html>
<html <?php language_attributes();?>>

<head>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="theme-color" content="#00a9e7" />
    <link rel="manifest" href="https://app.academiadaneurociencia.com.br/wp-content/plugins/academiadaneuro/assets/js/manifest.json">
    <?php wp_head();?>
</head>

<?php
$navbar_scheme = get_theme_mod('navbar_scheme', 'navbar-light bg-light'); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<body id="body-signin">

    <?php wp_body_open();?>

    <a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'lellyoliver');?></a>

    <div id="wrapper">
        <main id="main" class="m-0">

            <?php
// If Single or Archive (Category, Tag, Author or a Date based page).
if (is_single() || is_archive()):
?>
            <div class="row">
                <div class="col-md-12">
                    <?php
endif;
?>