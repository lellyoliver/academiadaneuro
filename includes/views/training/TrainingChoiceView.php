<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0 mb-3">
                <?php echo esc_html('Crie um treinamento personalizado'); ?>
            </h6>
            <p class="display-desktop">Arraste o treinamento para <b>caixa traçada azul</b> e <b>selecione um
                    paciente</b>, que nossa IA realizará um treinamento personalizado para abordar diretamente as
                necessidades do seu paciente.</p>
            <p class="display-mobile">Click no treinamento para <b>caixa traçada azul</b> e <b>selecione um paciente</b>
                abaixo, que nossa IA realizará um treinamento personalizado para abordar diretamente as necessidades do
                seu paciente.</p>

            <div class="mb-5"></div>
            <div class="row">
                <div class="col-md-6 mobile-order-2">
                    <?php
                    $categorias = [
                        'categoria-1',
                        'categoria-2',
                        'categoria-3',
                        'categoria-4',
                        'categoria-5',
                    ];

                    foreach ($categorias as $categoria) {
                        foreach ($training[$categoria] as $trainings) {
                            echo '<div class="question-container" draggable="true" data-post-id="' . $trainings->ID . '" data-question-title="' . $trainings->post_title . '">';
                            echo $trainings->post_title;
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
                <div class="col-md-6 mobile-order-1">
                    <form id="create-choice-form" method="post">
                        <div class="selected-questions" id="selected-questions" required>
                            <select name="user_id" class="form-select mb-4" id="user_id">
                                <option value="">Selecione um paciente</option>
                                <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user->ID; ?>"><?php echo $user->display_name; ?></option>
                                <?php endforeach;?>
                            </select>
                            <p class="fw-bold">Perguntas Selecionadas:</p>
                        </div>
                        <button class="btn btn-secondary col-12 fw-bolder mb-3 display-desktop" type="submit">Gerar
                            Estímulo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>