<?php
class MetaCustomCourses
{
    private $fields;

    public function __construct()
    {
        $this->fields = [
            "Objetivo" => "objetivo_course",
        ];

        add_action('add_meta_boxes', array($this, 'add_custom_fields_metabox'));
        add_action('save_post', array($this, 'save_custom_fields'), 10, 2);
    }

    public function add_custom_fields_metabox()
    {
        add_meta_box(
            'custom_fields_metabox',
            __('Descrição Curso'),
            array($this, 'render_custom_fields_metabox'),
            'sfwd-courses',
            'normal',
            'high'
        );
    }

    public function render_custom_fields_metabox($post)
    {
        wp_nonce_field('custom_fields_nonce', 'custom_fields_nonce');

        ?>
<div class="row">
    <?php
foreach ($this->fields as $key => $field):
            $field_value = get_post_meta($post->ID, $field, true);
            ?>

	    <?php wp_editor($field_value, $field, array('textarea_rows' => 5, 'textarea_name' => $field));?>

	    <?php endforeach;?>

</div>
<?php
}

    public function save_custom_fields($post_id)
    {
        if (!isset($_POST['custom_fields_nonce']) || !wp_verify_nonce($_POST['custom_fields_nonce'], 'custom_fields_nonce')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        foreach ($this->fields as $key => $field) {
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, $_POST[$field]);
            }
        }
    }
}

new MetaCustomCourses();