<?php
require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';

class RefundedManagerTable extends WP_List_Table
{
    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'manager_refund',
            'plural' => 'manager_refunds',
            'ajax' => false,
        ));
    }

    public function no_items()
    {
        echo 'Nenhum registro encontrado.';
    }

    public function get_columns()
    {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'comment_author' => 'Verificação',
            'comment_post_ID' => 'Nº do Pedido',
            'comment_date' => 'Data do pedido de Reembolso',
        );

        return $columns;
    }

    public function prepare_items()
    {
        global $wpdb;

        $per_page = 10;
        $current_page = $this->get_pagenum();
        $offset = ($current_page - 1) * $per_page;

        $sql = $wpdb->prepare(
            "SELECT * FROM $wpdb->comments
            WHERE comment_approved = 1
            AND comment_author = %s
            AND comment_content LIKE %s
            ORDER BY comment_date DESC
            LIMIT %d OFFSET %d",
            'WooCommerce',
            '%Pedido de Reembolso%',
            $per_page,
            $offset
        );

        $comments = $wpdb->get_results($sql);

        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_approved = 1 AND comment_author = 'WooCommerce' AND comment_content LIKE '%Pedido de Reembolso%'");

        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
        ));

        $this->_column_headers = array($this->get_columns(), array(), array());
        $this->items = array();
        foreach ($comments as $comment) {
            $href = "https://app.institutodeneurociencia.com.br/wp-admin/admin.php?page=wc-orders&action=edit&id=" . $comment->comment_post_ID;

            $this->items[] = array(
                'comment_author' => $comment->comment_author,
                'comment_post_ID' => $comment->comment_post_ID,
                'comment_date' => $comment->comment_date,
            );
        }

        $this->process_bulk_action();

    }

    public function process_bulk_action()
    {
        if (isset($_POST['delete_refunds'])) {
            global $wpdb;

            $selected_refunds = isset($_POST['refund_ids']) ? $_POST['refund_ids'] : array();

            foreach ($selected_refunds as $refund_id) {
                $user_id = get_post_field('post_author', $refund_id);

                $table_name = $wpdb->prefix . 'usermeta';

                $sql = $wpdb->prepare(
                    "SELECT umeta.meta_key
                FROM {$table_name} umeta
                WHERE umeta.user_id = %d AND umeta.meta_value LIKE %s",
                    $user_id,
                    '%' . $refund_id . '%'
                );

                $meta_keys = $wpdb->get_col($sql);

                $meta_value = json_decode(get_user_meta($user_id, $meta_keys[0], true));
                $timezone = new DateTimeZone('America/Sao_Paulo');
                $date = new DateTime('now', $timezone);
                $date->sub(new DateInterval('P1D'));
                $date_local = $date->format('Y-m-d');
                $meta_value->expiration_date = $date_local;

                update_user_meta($user_id, $meta_keys[0], json_encode($meta_value));

                $wpdb->delete($wpdb->comments, array('comment_post_ID' => $refund_id), array('%d'));
            }

            wp_redirect(admin_url('admin.php?page=wc-reembolsos'));
            exit();
        }
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'comment_post_ID':
                return '<a href="' . $this->get_edit_order_url($item['comment_post_ID']) . '">' . $item[$column_name] . '</a>';

            default:
                return $item[$column_name];
        }
    }

    private function get_edit_order_url($order_id)
    {
        return admin_url('admin.php?page=wc-orders&action=edit&id=' . $order_id);
    }

    public function display_page()
    {
        $this->prepare_items();
        $this->display();
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="refund_ids[]" value="%s" />',
            $item['comment_post_ID']
        );
    }

    public function extra_tablenav($which)
    {
        if ($which == 'top') {

        }

        if ($which == 'bottom') {
            echo '<div class="alignleft actions">';
            echo '<input type="hidden" name="action" value="delete" />';
            echo '<input type="submit" class="button" name="delete_refunds" value="Atualizar Reembolsos" />';
            echo '</div>';
        }
    }
}

class ClassRefundedAdminPage
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu()
    {
        $count_unseen_refunds = $this->get_unseen_refunds_count();
        $count = ($count_unseen_refunds > 0 ? $count_unseen_refunds : '');

        if ($count > 0) {
            $count_admin = '<span class="awaiting-mod update-plugins count-1"><span class="processing-count">' . $count . '</span></span>';
            $count_title = '(' . $count . ')';
        }

        add_submenu_page(
            'woocommerce',
            'Pedidos de Reembolsos' . ' ' . $count_title,
            'Reembolsos' . ' ' . $count_admin,
            'manage_woocommerce',
            'wc-reembolsos',
            array($this, 'adn_refunded_manager')
        );
    }

    public function get_unseen_refunds_count()
    {
        global $wpdb;

        $count_sql = $wpdb->prepare(
            "SELECT COUNT(*) FROM $wpdb->comments
            WHERE comment_approved = 1
            AND comment_author = %s
            AND comment_content LIKE %s",
            'WooCommerce',
            '%Pedido de Reembolso%'
        );

        return $wpdb->get_var($count_sql);
    }

    public function adn_refunded_manager()
    {
        echo '<div class="wrap">';
        echo '<h2>Gerenciar Reembolsos</h2>';
        echo '<p>O cliente recebeu um e-mail sobre o reembolso parcial. Dentro de 72 horas, por favor, proceda com o reembolso correspondente. Confira o número do pedido abaixo e entre em contato com o usuário através da plataforma, caso seja necessário.</p>';
        echo '<form method="post">';
        $list_table = new RefundedManagerTable();
        $list_table->prepare_items();
        $list_table->display();

        echo '</form>';

        echo '</div>';
    }

}

new ClassRefundedAdminPage();
