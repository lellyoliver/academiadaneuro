<form id="create-choice-form" method="post">
    <div class="selected-questions" id="selected-question-id" required>
        <select name="user_id" class="form-select mb-4" id="user_id">
            <option value="">Selecione um paciente</option>
            <?php foreach ($users as $user): ?>
            <option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></option>
            <?php endforeach;?>
        </select>
        <p class="fw-bold mt-3">Perguntas Selecionadas:</p>
    </div>
    <button class="btn btn-secondary col-12 mb-3" type="submit">Gerar TEC</button>
</form>

<div class="row">
    <?php
foreach ($trainings as $training) {
    foreach ($training as $post) {
        echo '<div class="col-md-3">';
        echo '<div class="question-container-2" draggable="true" data-post-id="' . $post->ID . '" data-question-title="' . $post->post_title . '">';
        echo $post->post_title;
        echo '</div>';
        echo '</div>';
    }
}
?>
</div>