<?php
if (!empty($trainings)) {
    echo '<div class="class-mytrainings-container-list">';
    $week = 1;

    foreach ($trainings as $training) {
        $post = get_post($training);
        // Correção na condição para verificar se a porcentagem é 100
        $finalizado = (isset($porcent[$training]) && $porcent[$training]->porcentagem == "100") ? '<span class="badge text-bg-success"><i class="fa-solid fa-check"></i> Concluído</span>' : '';

        echo '<div data-post="' . $training . '" class="class-mytrainings-list" onclick="window.location.href=\'' . esc_url(site_url('training/' . $post->post_name)) . '\'">';
        echo '<p style="font-size:14px;margin-bottom:6px;"><span class="badge text-bg-primary me-2">Semana ' . $week++ . '</span> ' . $finalizado . '</p>';

        echo '<div class="text-uppercase class-mytrainings-progress">';
        echo '<p>' . $post->post_title . '</p>';
        echo '<div class="progress w-100">';
        if (isset($porcent[$training])) { // Verifica se o ID existe no array
            echo '<div class="progress-bar" role="progressbar" style="width: ' . $porcent[$training]->porcentagem . '%;" aria-valuenow="' . $porcent[$training]->porcentagem . '" aria-valuemin="0" aria-valuemax="100">' . $porcent[$training]->porcentagem . '%</div>';
        } else {
            echo '<div class="progress-bar" role="progressbar" style="width:0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>';
        }
        echo '</div>';

        echo '</div>';
        echo '</div>';

    }
    echo '</div>';
} else {
    echo '<p>Nenhum treinamento disponível.</p>';
}
?>