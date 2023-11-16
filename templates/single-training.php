<?php
/**
 * Template Name: Single training
 */

include_once plugin_dir_path(__FILE__) . 'header-custom.php';

?>
<div class="breadcrumbs-text mb-3" id="breadcrumb"></div>
<div class="card mb-3">
    <div class="container padding_container__card">
        <div class="card-body">
            <!--1-->
            <div class="class_training__video">
                <h5 class="fw-bold text-uppercase mb-3">Vídeo explicativo</h5>
                <iframe width="100%" height="500" src="https://www.youtube.com/embed/"
                    frameborder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture;"></iframe>
            </div>
            <!--2-->
            <div class="timeline__trainings mb-5">
                <div class="lines__trainings">
                    <div class="dot__trainings "><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralResonance.svg
" alt="Video Treinamento" width="40" height="40"></div>
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
                    <div class="dot__trainings"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-cognitiveStimulation.svg
" alt="Video Treinamento" width="40" height="40"></div>
                    <div class="line-trainings"></div>
                </div>
                <div class="class__trainings">
                    <h5 class="fw-bold text-uppercase mb-3">Estimulação Cognitiva</h5>
                    <a role="button" class="btn btn-lg col-3 btn-secondary class_trainings__gameplay" target="_blank"
                        href="" id="gameplay">Iniciar</a>
                </div>
            </div>
            <!--4-->
            <div class="timeline__trainings mb-5">
                <div class="lines__trainings">
                    <div class="dot__trainings"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralBreathing.svg
" alt="Video Treinamento" width="40" height="40"></div>
                    <div class="line-trainings"></div>
                </div>
                <div class="class__trainings">
                    <h5 class="fw-bold text-uppercase mb-3">Respiração Neural</h5>
                    <video width="100%" height="500" class="class_training__video_2" id="videoPlayer" controls>
                        <source src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
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
                <button type="submit" class="btn btn-lg btn-secondary" id="saveTraining">Salvar Progresso</button>
        </div>
        </form>
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