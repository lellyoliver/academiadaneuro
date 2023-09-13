<?php
class MetaCustomQuestion
{

    private $fields;

    public function __construct()
    {
        $this->fields = [
            "1" => [
                "category" => "Qualidade de sono",
                "question" => "Você tem dificuldade para dormir à noite?",
                "replies" => ["sempre", "quase sempre", "às vezes", "raramente", "Nunca"],
            ],
            "2" => [
                "category" => "Qualidade de sono",
                "question" => "Você tem dificuldade para dormir à noite?",
                "replies" => ["sempre", "quase sempre", "às vezes", "raramente", "Nunca"],
            ],

        ];
        add_action('add_meta_boxes', array($this, 'add_custom_fields_metabox'));
        // add_action('save_post', array($this, 'save_custom_fields'), 10, 2);
    }

    public function add_custom_fields_metabox()
    {
        add_meta_box(
            'custom_fields_metabox',
            __('Informações Adicionais'),
            array($this, 'render_custom_fields_metabox'),
            'traningquestion',
            'normal',
            'high'
        );
    }

    public function render_custom_fields_metabox($post)
    {
        wp_nonce_field('custom_fields_nonce', 'custom_fields_nonce');

        ?>
<table class="wp-list-table widefat fixed striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Categoria</th>
            <th>Pergunta</th>
            <th>Respostas</th>
        </tr>
    </thead>
    <tbody>
        <?php
foreach ($this->fields as $key => $field) {
            $keys = ($key + 0);
            echo '<tr>';
            echo '<td>' . $keys . '</td>';
            echo '<td>' . $field['category'] . '</td>';
            echo '<td>' . $field['question'] . '</td>';
            echo '<td>';
            echo '<select name="reply_' . $keys . '" id="reply_' . $keys . '">';
            if (is_array($field['replies'])) {
                foreach ($field['replies'] as $reply) {
                    echo '<option value="' . $reply . '">' . $reply . '</option>';
                }
            }
            echo '</select>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
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
            $keys = ($key + 0);
            $field_name = 'reply_' . $keys;
            if (isset($_POST[$field_name])) {
                update_post_meta($post_id, $field_name, sanitize_text_field($_POST[$field_name]));
            }
        }
    }
}

new MetaCustomQuestion();