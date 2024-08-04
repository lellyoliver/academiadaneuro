<div class="accordion" id="accordionUser">
    <div class="mb-3">
        <input type="text" class="form-control" id="search-patient" placeholder="Search" />
    </div>
    <?php if (empty($progresses)): ?>
    <p class="fw-normal">Sem pacientes em progresso.</p>
    <?php else: ?>
    <?php foreach ($progresses as $progress): ?>
    <div class="accordion-item" data-name-user="<?php echo esc_html($progress['name']); ?>">
        <div class="accordion-header" id="heading<?php echo esc_html($progress['ID']); ?>" data-bs-toggle="collapse"
            data-bs-target="#collapse<?php echo esc_html($progress['ID']) ?>" aria-expanded="true"
            aria-controls="collapse<?php echo esc_html($progress['ID']) ?>">
            <div class="accordion-wrapper">
                <div class="progress-accordion-custom w-100">
                    <p class="text-uppercase" style="font-size:12px;margin-bottom:-1px;">
                        <?php echo esc_html($progress['updated']); ?>
                    </p>
                    <span class="accordion-name fw-bold w-100 name-patient"><?php echo esc_html($progress['name']); ?>
                    </span>
                    <span class="progress m-0" style="width: 100%;">
                        <span class="progress-bar" role="progressbar"
                            style="width: <?php echo esc_html($progress['porcentagem']); ?>%;"
                            aria-valuenow="<?php echo esc_html($progress['porcentagem']); ?>%" aria-valuemin="0"
                            aria-valuemax="100"><?php echo esc_html($progress['porcentagem']); ?>%
                        </span>
                    </span>
                </div>
                <button class="btn btn-sm btn-secondary view-user ms-2" style="padding:5px!important;"
                    title="Ver Treinamento" id="list-13" data-index="0"
                    data-userid="<?php echo esc_html($progress['ID']); ?>" data-bs-target="#viewUserRelated"
                    data-bs-toggle="offcanvas">Treinamento</button>
                <span class="accordion-arrow"><i class="fa-solid fa-chevron-down"></i></span>
            </div>

        </div>
        <div id="collapse<?php echo esc_html($progress['ID']); ?>" class="accordion-collapse collapse"
            aria-labelledby="heading<?php echo esc_html($progress['ID']); ?>" data-bs-parent="#accordionUser">
            <div class="accordion-body">
                <div class="accordion-wrapper">
                    <span class="accordion-icon"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-neuralResonance.svg
			                                    " alt="icon ressonancia" srcset="https://cdn.institutodeneurociencia.com.br/image/icon-neuralResonance.svg
			                                    " width="80"></span>
                    <span class="progress" style="width: 100%;">
                        <span class="progress-bar progress-bar-orange" role="progressbar"
                            style="width: <?php echo esc_html($progress['neural_resonance']); ?>%;"
                            aria-valuenow="<?php echo esc_html($progress['neural_resonance']); ?>" aria-valuemin="0"
                            aria-valuemax="100"><?php echo esc_html($progress['neural_resonance']); ?>%</span>
                    </span>
                    <span class="accordion-icon"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-cognitiveStimulation_2.svg
			                                    " alt="icon ressonancia" srcset="https://cdn.institutodeneurociencia.com.br/image/icon-cognitiveStimulation_2.svg
			                                    " width="80"></span>
                    <span class="progress" style="width: 100%;">
                        <span class="progress-bar progress-bar-green" role="progressbar"
                            style="width: <?php echo esc_html($progress['cognitive_stimulation']); ?>%;"
                            aria-valuenow="<?php echo esc_html($progress['cognitive_stimulation']); ?>"
                            aria-valuemin="0"
                            aria-valuemax="100"><?php echo esc_html($progress['cognitive_stimulation']); ?>%</span>
                    </span>
                    <span class="accordion-icon"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-neuralBreathing.svg
			                                " alt="icon ressonancia" srcset="https://cdn.institutodeneurociencia.com.br/image/icon-neuralBreathing.svg
			                                " width="80"></span>
                    <span class="progress" style="width: 100%;">
                        <span class="progress-bar progress-bar-blue" role="progressbar"
                            style="width: <?php echo esc_html($progress['neural_breathing']); ?>%;"
                            aria-valuenow="<?php echo esc_html($progress['neural_breathing']); ?>" aria-valuemin="0"
                            aria-valuemax="100"><?php echo esc_html($progress['neural_breathing']); ?>%</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach;?>
    <?php endif;?>
</div>
<div class="pagination-container mt-3">
    <ul class="pagination justify-content-center" id="pagination">
        teste
    </ul>
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