<?php
class MetaCustomTraining
{

    private $fields;

    public function __construct()
    {
        $this->fields = [
            "Fale um pouco mais sobre esse treinamento" => "textTraining",
            "URL Ressonância Neural" => "neuralResonance",
            "URL Respiração Neural" => "neuralBreathing",
            "URL Estímulo cognitivo" => "cognitiveStimulation",
        ];

        add_action('add_meta_boxes', array($this, 'add_custom_fields_metabox'));
        add_action('save_post', array($this, 'save_custom_fields'), 10, 2);
    }

    public function add_custom_fields_metabox()
    {
        add_meta_box(
            'custom_fields_metabox',
            __('Informações Adicionais'),
            array($this, 'render_custom_fields_metabox'),
            'training',
            'normal',
            'high'
        );
    }

    public function render_custom_fields_metabox($post)
    {
        wp_nonce_field('custom_fields_nonce', 'custom_fields_nonce');

        ?>
<table>
    <tbody>
        <?php
foreach ($this->fields as $key => $field):
            $field_value = get_post_meta($post->ID, $field, true);
            ?>
        <tr>
            <td>
                <label for="<?php echo $field; ?>"><?php echo $key; ?></label>
            <td>
            <td>
                <input type="text" id="<?php echo $field; ?>" name="<?php echo $field; ?>"
                    value="<?php echo $field_value; ?>">
            </td>
        <tr>
            <?php endforeach;?>
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
            if (isset($_POST[$field])) {
                update_post_meta($post_id, $field, $_POST[$field]);
            }
        }
    }
}

new MetaCustomTraining();