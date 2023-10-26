<div class="card mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                <?php echo esc_html('Meus Treinamentos'); ?>
            </h6>
            <br>
            <?php

?>
            <?php
// Verifica se há categorias
if (!empty($trainings)) {
    echo '<div class="class-mytrainings-container-list">';
    $day = 1;

    foreach ($trainings as $categoryName => $postList) {
        // Verifica se há postagens para esta categoria
        if (!empty($postList)) {

            foreach ($postList as $post) {
                // Verifique se há progresso para este post
                $postID = $post->ID;
                $progressValue = isset($progress[$postID]) ? $progress[$postID] : '';
                echo '<div class="class-mytrainings-list d-flex align-items-center" onclick="window.location.assign(\'' . get_permalink($post) . '\')">';
                echo '<p>Dia ' . $day++ . '</p>';

                if (!empty($progressValue)) {
                    echo '<span class="progress-container ms-3"' . $progressValue . '</span>';
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