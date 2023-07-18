<?php
class UserCustomFields
{

    private $fields;

    public function __construct()
    {
        $this->fields = array(
            'cnpj' => 'CNPJ',
            'phone' => 'Telefone',
            'cep' => 'CEP',
            'address' => 'Endereço',
            'number_house' => 'Número',
            'neighborhood' => 'Bairro',
            'city' => 'Cidade',
            'state' => 'Estado',
        );
        add_action('show_user_profile', array($this, 'custom_fields_user'));
        add_action('edit_user_profile', array($this, 'custom_fields_user'));
        add_action('personal_options_update', array($this, 'save_custom_fields'));
        add_action('edit_user_profile_update', array($this, 'save_custom_fields'));
    }

    public function custom_fields_user($user)
    {
        ?>
        <h3><?php _e('Informações Adicionais');?></h3>

        <table class="form-table">
            <?php foreach ($this->fields as $field_name => $field_label): ?>
                <tr>
                    <th><label for="<?php echo $field_name; ?>"><?php echo $field_label; ?></label></th>
                    <td>
                        <input type="text" name="<?php echo $field_name; ?>" id="<?php echo $field_name; ?>" value="<?php echo esc_attr(get_user_meta($user->ID, $field_name, true)); ?>" class="regular-text" /><br />
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
        <?php
}
    public function save_custom_fields($user_id)
    {
        foreach ($this->fields as $field_name => $field_label) {
            if (isset($_POST[$field_name])) {
                update_user_meta($user_id, $field_name, sanitize_text_field($_POST[$field_name]));
            }
        }
    }

}
new UserCustomFields();
