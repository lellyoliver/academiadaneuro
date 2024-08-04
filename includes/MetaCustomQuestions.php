<?php
class MetaCustomQuestions
{
    public function __construct()
    {
        add_action('manage_posts_extra_tablenav', array($this, 'add_btn_tablenav'));
    }

    public function add_btn_tablenav($which)
    {
        global $pagenow;
        global $typenow;
        if ('questions' == $typenow && $pagenow == 'edit.php' && $which == 'top') {
            echo '<div class="alignleft actions">';
            echo '<a type="button" id="categoria" class="button" href="'.admin_url('edit-tags.php?taxonomy=question-category&post_type=questions').'">Ver Categorias das Questões</a>';
            echo '</div>';
        }
    }
}

new MetaCustomQuestions();