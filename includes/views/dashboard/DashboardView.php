<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <div class="d-flex align-items-center align-self-center">
                <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                    <?php echo esc_html('Pacientes em Progresso'); ?>
                </h6>
                <a class="btn btn-sm btn-3 display-desktop" href="<?php echo site_url('/novo-treinamento', 'https') ?>"
                    title="criar treinamento"> <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <?php echo esc_html('Criar novo treinamento'); ?></a>
            </div>
            <br>
            <div class="accordion" id="accordionUser">
                <?php if (empty($patients)): ?>
                <p class="fw-normal">Sem pacientes em progresso.</p>
                <?php else: ?>
                <?php foreach ($patients as $patient): ?>
                <?php if (isset($progress[$patient->ID])): ?>
                <div class="accordion-item">
                    <div class="accordion-header" id="heading<?php echo $patient->ID; ?>" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?php echo $patient->ID; ?>" aria-expanded="true"
                        aria-controls="collapse<?php echo $patient->ID; ?>">
                        <div class="accordion-wrapper">
                            <div class="d-flex flex-column align-content-start w-100">
                                <p class="text-uppercase" style="font-size:12px;margin-bottom:-1px;">
                                    <?php echo date_i18n('d M', strtotime($progress[$patient->ID]['updateProgress'])); ?>
                                </p>
                                <span class="accordion-name fw-bold w-100"><?php echo $patient->display_name; ?> <button
                                        class="btn btn-sm btn-secondary view-user" title="Ver Treinamento" id="list-13"
                                        data-index="0" data-userid="<?php echo $patient->ID; ?>"
                                        data-bs-target="#viewUserRelated" data-bs-toggle="offcanvas"> <i
                                            class="fa-solid fa-clipboard"></i> Ver treinamento</button></span>
                            </div>
                            <span class="progress" style="width: 100%;">
                                <span class="progress-bar" role="progressbar"
                                    style="width: <?php echo $progress[$patient->ID]['totalProgress']; ?>%;"
                                    aria-valuenow="<?php echo $progress[$patient->ID]['totalProgress']; ?>%"
                                    aria-valuemin="0"
                                    aria-valuemax="100"><?php echo $progress[$patient->ID]['totalProgress']; ?>%
                                </span>
                            </span>
                            <span class="accordion-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                        </div>
                    </div>
                    <div id="collapse<?php echo $patient->ID; ?>" class="accordion-collapse collapse"
                        aria-labelledby="heading<?php echo $patient->ID; ?>" data-bs-parent="#accordionUser">
                        <div class="accordion-body">
                            <div class="accordion-wrapper">
                                <span class="accordion-icon"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-neuralResonance.svg
			                                    " alt="icon ressonancia" srcset="https://cdn.institutodeneurociencia.com.br/image/icon-neuralResonance.svg
			                                    " width="25"></span>
                                <span class="progress" style="width: 100%;">
                                    <span class="progress-bar progress-bar-orange" role="progressbar"
                                        style="width: <?php echo $progress[$patient->ID]['neuralResonance']; ?>%;"
                                        aria-valuenow="<?php echo $progress[$patient->ID]['neuralResonance']; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100"><?php echo $progress[$patient->ID]['neuralResonance']; ?>%</span>
                                </span>
                                <span class="accordion-icon"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-cognitiveStimulation_2.svg
			                                    " alt="icon ressonancia" srcset="https://cdn.institutodeneurociencia.com.br/image/icon-cognitiveStimulation_2.svg
			                                    " width="25"></span>
                                <span class="progress" style="width: 100%;">
                                    <span class="progress-bar progress-bar-green" role="progressbar"
                                        style="width: <?php echo $progress[$patient->ID]['cognitiveStimulation']; ?>%;"
                                        aria-valuenow="<?php echo $progress[$patient->ID]['cognitiveStimulation']; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100"><?php echo $progress[$patient->ID]['cognitiveStimulation']; ?>%</span>
                                </span>
                                <span class="accordion-icon"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-neuralBreathing.svg
			                                " alt="icon ressonancia" srcset="https://cdn.institutodeneurociencia.com.br/image/icon-neuralBreathing.svg
			                                " width="25"></span>
                                <span class="progress" style="width: 100%;">
                                    <span class="progress-bar progress-bar-blue" role="progressbar"
                                        style="width: <?php echo $progress[$patient->ID]['neuralBreathing']; ?>%;"
                                        aria-valuenow="<?php echo $progress[$patient->ID]['neuralBreathing']; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100"><?php echo $progress[$patient->ID]['neuralBreathing']; ?>%</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
                <?php endforeach;?>
                <?php endif;?>
            </div>
            <div class="row m-0 m-auto mt-3 display-mobile">
                <a class="btn btn-lg btn-3" href="<?php echo site_url('/novo-treinamento', 'https') ?>"
                    title="criar treinamento"> <i class="fa-solid fa-wand-magic-sparkles"></i>
                    <?php echo esc_html('Criar novo treinamento'); ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update -->
<div class="offcanvas offcanvas-bottom" tabindex="-1" id="viewUserRelated" style="z-index:9999!important;">
    <div class="offcanvas-header">
        <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">Visualizar Treinamento</h6>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="row" id="list-replies">

        </div>
    </div>
</div>