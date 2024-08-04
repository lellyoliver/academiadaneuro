<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <div class="d-flex align-items-center align-self-center">
                <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                    <?php echo esc_html('Meus Treinamentos'); ?>
                </h6>
                <?php 
                $current_user = wp_get_current_user();
                $allowed_roles = ['training'];
                if (array_intersect($allowed_roles, $current_user->roles)): ?>
                <a class="btn btn-sm btn-3" href="<?php echo site_url('/novo-treinamento', 'https')?>"> <i
                        class="fa-solid fa-clipboard-list"></i></a>
                <?php endif;?>
            </div>
            <br>
            <?php

            if (!empty($trainings)) {
                echo '<div class="class-mytrainings-container-list">';
                $week = 1;

                foreach ($trainings as $categoryName => $postList) {
                    if (!empty($postList)) {

                        foreach ($postList as $post) {
                            $postID = $post->ID;
                            $progressValue = isset($progress[$postID]) ? $progress[$postID] : '';
                            echo '<div class="class-mytrainings-list d-flex text-uppercase align-items-center" onclick="window.location.assign(\'' . get_permalink($post) . '\')">';
                            echo '<p>Semana ' . $week++ . '</p>';

                            if (!empty($progressValue)) {
                                echo '<span class="progress-container ms-3 d-flex align-items-center"' . $progressValue . '</span>';
                            }
                            echo '</div>';
                        }
                    } else {
                        echo '<p>Nenhum treinamento disponível.</p>';
                    }
                }
                echo '</div>';
            } else {
                echo '<p>Nenhum treinamento disponível.</p>';
            }
            ?>

        </div>
    </div>
</div>