<?php
/**
 * Template Name: Single training
 */

include_once plugin_dir_path(__FILE__) . 'header-custom.php';

?>
<div class="loading" style="display:none" id="loading">
    <div class="overlay"></div>
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0 mb-4">
                <?php echo esc_html('Estímulo Cerebral'); ?>
            </h6>
            <div class="row">
                <div class="col-md-6">
                    <!--1-->
                    <div class="class_training__video">
                        <iframe width="100%" height="500" src="https://www.youtube.com/embed/" frameborder="0"
                            allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture;"></iframe>
                    </div>
                    <div class="class_training__text mb-5">
                        <h5 class="mb-3">Como isso vai me ajudar no dia-a-dia?</h5>
                        <div class="accordion" id="accordionHelp">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        1. Alguns dos benefícios dessa Estimulação Cerebral:
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionHelp">
                                    <div class="accordion-body">
                                        <p id="textTraining" class="m-3"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        2. Dicas para usar a Estimulação Cerebral:
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionHelp">
                                    <div class="accordion-body">
                                        <p id="usageTips" class="m-3"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        3. Recomendações para usar a estimulação cerebral:
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionHelp">
                                    <div class="accordion-body">
                                        <p id="recommendations" class="m-3"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!--2-->
                    <div class="timeline__trainings mb-5">
                        <div class="lines__trainings">
                            <div class="dot__trainings "><img src="https://cdn.institutodeneurociencia.com.br/image/icon-neuralResonance.svg
" alt="Ressonância Neural" width="40" height="40"></div>
                            <div class="line-trainings"></div>
                        </div>
                        <div class="class__trainings">
                            <h5 class="fw-bold text-uppercase mb-3">Ressonância neural</h5>
                            <audio controls controlsList="nodownload" class="class_training__audio" width="100%"
                                id="audioPlayer">
                                <source src="" type="audio/wav">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                    <!--3-->
                    <div class="timeline__trainings mb-5">
                        <div class="lines__trainings">
                            <div class="dot__trainings"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-neuralBreathing.svg" alt="Respiração Neural" width="40" height="40"></div>
                            <div class="line-trainings"></div>
                        </div>
                        <div class="class__trainings">
                            <h5 class="fw-bold text-uppercase mb-3">Respiração Neural</h5>
                            <video width="100%" height="100%" class="class_training__video_2" id="videoPlayer" controls>
                                <source src="" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                    <!--4-->
                    <div class="timeline__trainings mb-5">
                        <div class="lines__trainings">
                            <div class="dot__trainings"><img src="https://cdn.institutodeneurociencia.com.br/image/icon-cognitiveStimulation_2.svg" alt="Estimulação Cognitiva" width="40" height="40"></div>
                            <div class="line-trainings"></div>
                        </div>
                        <div class="class__trainings">
                            <h5 class="fw-bold text-uppercase mb-3">Estimulação Cognitiva</h5>
                            <a role="button" class="btn btn-lg col-3 btn-secondary class_trainings__gameplay"
                                target="_blank" href="" id="gameplay">Iniciar</a>
                        </div>
                    </div>
                    <form id="create-progress" method="post">
                        <input type="hidden" value="<?php echo date('Y-m-d H:i:s', current_time('timestamp', 0)); ?>"
                            id="DH_enter" name="DH_enter">
                        <input type="hidden" value="" id="DH_exit" name="DH_exit">
                        <input type="hidden" value="" id="neuralResonance" name="neuralResonance">
                        <input type="hidden" value="" id="neuralBreathing" name="neuralBreathing">
                        <input type="hidden" value="" id="cognitiveStimulation" name="cognitiveStimulation">
                        <input type="hidden" value="<?php echo date('Y-m-d', current_time('timestamp', 0)); ?>"
                            id="updateProgress" name="updateProgress">
                        <input type="hidden" value="<?php echo get_current_user_id(); ?>" id="user_id" name="user_id">
                        <input type="hidden" value="<?php echo the_ID(); ?>" id="post_id" name="post_id">
                        <button type="submit" class=" mt-5 btn btn-lg btn-secondary btn__save col-12 float-end"
                            id="saveTraining">Salvar
                            Progresso</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
function identifyBtn() {
    const divButtonClassTraining = document.getElementById('divButtonClassTraining');
    const screenWidth = window.screen.width;

    if (screenWidth < 900) { // Verifica se o elemento foi encontrado
        var div = document.createElement("div");
        div.classList.add("row m-0 m-auto");
        Element.prototype.prependChild = function prependChild(element) {
            this.insertBefore(element, this.firstChild);
        };

        t.prependChild(div);
    }

}
</script>