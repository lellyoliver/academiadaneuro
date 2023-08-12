<?php
class MetaCustomUser
{

    private $fields;

    public function __construct()
    {
        $this->fields = array(
            'connected_user' => 'Relação de Usuário',
        );
        add_action('show_user_profile', array($this, 'render_custom_fields'));
        add_action('edit_user_profile', array($this, 'render_custom_fields'));
    }
    
    public function displayConnectedUser() {
        $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0; // Obtém o ID do usuário da URL
        $connected_user_id = get_user_meta($user_id, 'connected_user', true);

        if ($connected_user_id) {
            $connected_user = get_userdata($connected_user_id);

            if ($connected_user) {
                return esc_html($connected_user->display_name) . ' (ID: ' . $connected_user->ID . ')';
            }
        } else {
            return 'Não há relação nenhuma.';
        }
    }

    public function render_custom_fields($user) {
        ?>
        <h3><?php _e('Informações Adicionais', 'text_domain'); ?></h3>

        <table class="form-table">
            <tr>
                <th><label for="user_relation_info">Relação de Usuário</label></th>
                <td>
                    <?php
                    echo '<span class="regular-text">' . $this->displayConnectedUser() . '</span>';
                    ?>
                </td>
            </tr>
        </table>
        <?php
    }
}

new MetaCustomUser();