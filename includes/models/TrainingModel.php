<?php

class TrainingModel
{
    private $table_replies;
    private $wpdb;
    private $table_progress;
    private $charset_collate;

    public function __construct()
    {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_replies = $this->wpdb->prefix . 'adn_replies';
        $this->table_progress = $this->wpdb->prefix . 'adn_progress';
        $this->charset_collate = $this->wpdb->get_charset_collate();

    }

    /**
     * Recebe do Controller os dados para inserir no BD
     *
     * @param array $data
     * @return insertTrainingReplies
     */
    public function replies($data)
    {
        if (!$data['post_id']) {
            $treinamentos = $this->getTreinamentos(false, $data['replies']);
            $treinamento_ids = [];
            foreach ($treinamentos as $treinamento) {
                $treinamento_ids[] = "$treinamento->ID";
            }
        } else {
            $treinamento_ids = $data['post_id'];
        }

        return $this->insertTrainingReplies($data['replies'], $data['user_id'], $treinamento_ids);
    }

    /**
     * Inserir as respostas das questões no banco de dados
     *
     * @param array $replies
     * @param int $user_id
     * @param array $treinamentos
     * @return bool
     */
    public function insertTrainingReplies($replies, $user_id, $treinamentos)
    {
        $delete_result = $this->wpdb->delete(
            $this->table_progress,
            ['user_id' => $user_id],
            ['%d']
        );

        $exists = $this->wpdb->get_var($this->wpdb->prepare(
            "SELECT COUNT(*) FROM {$this->table_replies} WHERE user_id = %d",
            $user_id
        ));

        $replies_json = json_encode($replies);
        $treinamentos_json = json_encode($treinamentos);

        if ($exists > 0) {
            $result = $this->wpdb->update(
                $this->table_replies,
                ['replies' => $replies_json, 'treinamentos' => $treinamentos_json],
                ['user_id' => $user_id],
                ['%s', '%s'],
                ['%d']
            );
        } else {
            $result = $this->wpdb->insert(
                $this->table_replies,
                ['replies' => $replies_json, 'treinamentos' => $treinamentos_json, 'user_id' => $user_id],
                ['%s', '%s', '%d']
            );
        }

        return $result !== false;
    }

    /**
     * Get the training results for a specific user or post.
     *
     * @param int|bool $user_id The ID of the user.
     * @return array|bool An array of training results for the user or post, or false on failure.
     */
    public function getPrepareReplies($user_id = false)
    {
        if ($user_id) {
            $query = $this->wpdb->prepare(
                "SELECT replies FROM $this->table_replies WHERE user_id = %d",
                $user_id
            );
        } else {
            return false;
        }

        $results = $this->wpdb->get_results($query);

        if (!empty($results)) {
            return json_decode($results[0]->replies, true);
        }

        return false;
    }

    /**
     * Get posts in a specific category.
     *
     * @param string $categoria The category slug.
     * @return array An array of posts in the category.
     */
    public function getPostsCategory($categoria)
    {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'training',
            'tax_query' => [
                [
                    'taxonomy' => 'brainGroup',
                    'field' => 'slug',
                    'terms' => $categoria,
                ],
            ],
            'order' => 'DESC',
        ];

        $posts = get_posts($args);

        return $posts;
    }

    /**
     * Sum the replies for a specific post by category.
     *
     * @param int $post_id The ID of the post.
     * @return array An array of posts sorted by category sum.
     */
    public function getTreinamentos($user_id = false, $replies = false)
    {
        $categorias = [
            'Categoria 1' => ["sleep-quality", "mental-fatigue", "control-of-anxiety", "emotional-control"],
            'Categoria 2' => ["body-pain", "headache", "stress"],
            'Categoria 3' => ["external-stimulus-anxiety", "thoughts-invasive", "perception-mind-body"],
            'Categoria 4' => ["mental-activity", "creativity", "learning-and-memory"],
            'Categoria 5' => ["focus-and-attention", "concentration"],
        ];

        if (!empty($user_id)) {
            $get_replies = $this->getPrepareReplies($user_id);
        } else {
            $get_replies = $replies;
        }

        if ($get_replies === false) {
            return [];
        }

        $sum_categoria = [];

        foreach ($categorias as $categoria => $tags) {
            $soma = 0;
            foreach ($tags as $tag) {
                if (isset($get_replies[$tag])) {
                    $soma += array_sum($get_replies[$tag]);
                }
            }
            $sum_categoria[$categoria] = $soma;
        }

        asort($sum_categoria);

        $posts_categoria = [];
        foreach (array_keys($sum_categoria) as $categoria) {
            $posts_categoria[$categoria] = $this->getPostsCategory($categoria);
        }

        $result_posts = [];
        foreach ($posts_categoria as $categoria => $posts) {
            $result_posts = array_merge($result_posts, $posts);
        }

        return $result_posts;
    }

    /**
     * Retornos para a view
     *
     */
    public function getQuestions()
    {
        $args = [
            'post_type' => 'questions',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title',
        ];

        $questions = get_posts($args);

        return $questions;
    }

    public function getQuestionCategory($post_id)
    {
        $categories = get_the_terms($post_id, 'question-category');

        $terms = [];

        if ($categories && !is_wp_error($categories)) {
            foreach ($categories as $category) {
                $category_slug = $category->slug;
                $post_title = get_the_title($post_id);
                if (!isset($terms[$category_slug])) {
                    $terms[$category_slug] = [];
                }
                $terms[$category_slug][] = $post_title;
            }
        }
        return $terms;
    }

    public function combineArrays($arrays)
    {
        $combinedArray = [];

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (!isset($combinedArray[$key])) {
                    $combinedArray[$key] = [];
                }
                $combinedArray[$key] = array_merge($combinedArray[$key], $value);
            }
        }

        return $combinedArray;
    }

    public function getQuestionsCombine()
    {
        $all_terms = [];

        foreach ($this->getQuestions() as $post_id) {
            $terms = $this->getQuestionCategory($post_id);
            $all_terms[] = $terms;
        }

        $combined_terms = $this->combineArrays($all_terms);
        asort($all_terms);

        return $combined_terms;
    }

}
