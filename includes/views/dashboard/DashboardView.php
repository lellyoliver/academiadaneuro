<div class="card mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                <?php echo esc_html('Pacientes em Progresso'); ?>
            </h6>
            <br>
            <div class="accordion" id="accordionUser">
                <?php foreach ($name_patient as $patient): ?>
                <?php
// Verifique se há progresso para o paciente atual
if (isset($progress[$patient->ID])):
?>
                <div class="accordion-item">
                    <div class="accordion-header" id="heading<?php echo $patient->ID; ?>" data-bs-toggle="collapse"
                        data-bs-target="#collapse<?php echo $patient->ID; ?>" aria-expanded="true"
                        aria-controls="collapse<?php echo $patient->ID; ?>">
                        <div class="accordion-wrapper">
                            <span class="accordion-name"><?php echo $patient->display_name; ?></span>
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
                                <span class="accordion-icon"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralResonance.svg
			                                    " alt="icon ressonancia" srcset="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralResonance.svg
			                                    " width="25"></span>
                                <span class="progress" style="width: 100%;">
                                    <span class="progress-bar progress-bar-orange" role="progressbar"
                                        style="width: <?php echo $progress[$patient->ID]['neuralResonance']; ?>%;"
                                        aria-valuenow="<?php echo $progress[$patient->ID]['neuralResonance']; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100"><?php echo $progress[$patient->ID]['neuralResonance']; ?>%</span>
                                </span>
                                <span class="accordion-icon"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-cognitiveStimulation.svg
			                                    " alt="icon ressonancia" srcset="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-cognitiveStimulation.svg
			                                    " width="25"></span>
                                <span class="progress" style="width: 100%;">
                                    <span class="progress-bar progress-bar-yellow" role="progressbar"
                                        style="width: <?php echo $progress[$patient->ID]['cognitiveStimulation']; ?>%;"
                                        aria-valuenow="<?php echo $progress[$patient->ID]['cognitiveStimulation']; ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100"><?php echo $progress[$patient->ID]['cognitiveStimulation']; ?>%</span>
                                </span>
                                <span class="accordion-icon"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralBreathing.svg
			                                " alt="icon ressonancia" srcset="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralBreathing.svg
			                                " width="25"></span>
                                <span class="progress" style="width: 100%;">
                                    <span class="progress-bar progress-bar-green" role="progressbar"
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
            </div>
        </div>
    </div>
</div>