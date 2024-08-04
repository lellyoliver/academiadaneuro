<?php

class CustomerSupportModel
{

    /**
     * Create a new support in WordPress database.
     *
     * @return int|WP_Error The comment ID if successful, or WP_Error object on failure.
     */

    public function createSupport($comment_data)
    {

        $i = get_option('protocol', 10);

        $title = 'Protocolo #' . $i++ . date('Y');

        $post_data = array(
            'post_title' => wp_strip_all_tags($title),
            'post_status' => 'private',
            'post_content' => $comment_data['comment_support'],
            'post_type' => 'customer-support',
            'post_author' => $comment_data['user_id'],
        );

        $post_id = wp_insert_post($post_data);

        wp_set_post_terms($post_id, 23, 'customer-support-category');

        update_option('protocol', $i);

        return $post_id;
    }

    public function handleSupportUpload($file, $post_id, $comment_data)
    {
        if (isset($file, $post_id)) {
            require_once ABSPATH . 'wp-admin/includes/image.php';
            require_once ABSPATH . 'wp-admin/includes/file.php';
            require_once ABSPATH . 'wp-admin/includes/media.php';

            $attachment_id = media_handle_upload('attachment_support', $post_id);

            if (!is_wp_error($attachment_id)) {
                
                update_post_meta($post_id, '_attachment_support', $attachment_id);
                
                return $attachment_id;
            } else {
                return false;
            }
        }
    }

    public function getSupportID($user_id)
    {
        $args = array(
            'post_author' => $user_id,
            'post_type' => 'customer-support',
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'private',
            'post_per_page' => 10,
        );

        $results = get_posts($args);
        $support_data = array();

        foreach ($results as $result) {
            $user = $result->post_author;
            $id = $result->ID;
            $date = $result->post_date;
            $formatted_date = date("d/m/Y \à\s H\hi", strtotime($date));
            $protocolo = $result->post_title;
            $message = $result->post_content;

            $taxonomies = get_object_taxonomies(get_post($id), 'names');
            $comments = get_comments(array('post_id' => $id, 'status' => 'approve'));
            $anexo = get_post_meta( $id, '_attachment_support', true);

            $support_item = array(
                'id' => $id,
                'date' => $formatted_date,
                'protocolo' => $protocolo,
                'message' => $message,
                'user_id' => $user,
                'anexo' => $anexo,
                'comments' => array(),
                'taxonomies' => array(),
            );

            foreach ($comments as $comment) {
                $comment_date = $comment->comment_date;
                $formatted_comment_date = date("d/m/Y \à\s H\hi", strtotime($comment_date));
                $support_item['comments'] = array(
                    'content' => $comment->comment_content,
                    'date' => $formatted_comment_date,
                );
            }

            foreach ($taxonomies as $taxonomy) {
                $terms = wp_get_post_terms($id, $taxonomy);
                foreach ($terms as $term) {
                    $icon = ($term->name === 'Não Resolvido') ? 'fa-xmark' : (($term->name === 'Em Análise') ? 'fa-gear' : 'fa-check');
                    $term_valid = ($term->name === 'Resolvido');

                    $support_item['taxonomies'] = array(
                        'icon' => $icon,
                        'term' => $term->name,
                        'valid' => $term_valid,
                    );
                }
            }

            $support_data[] = $support_item;
        }

        return $support_data;
    }

}