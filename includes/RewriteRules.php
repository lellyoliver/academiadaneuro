<?php

class RewriteRules
{
    public function __construct()
    {
        add_action('init', array($this, 'changeAuthorPermalinks'));
        register_activation_hook(__FILE__, array($this, 'activate'));
    }

    public function changeAuthorPermalinks()
    {
        global $wp_rewrite;
        $author_base = 'paciente';
        $wp_rewrite->author_base = $author_base;

        flush_rewrite_rules();

    }

    public function activate()
    {
        flush_rewrite_rules();
    }
}

new RewriteRules();
