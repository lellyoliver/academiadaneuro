<?php
/**
 * Template Name: Single training
 */

include_once plugin_dir_path(__FILE__) . 'header-custom.php';
$videoTraining = get_post_meta($post->ID, 'videoTraining', true);
$neuralResonance = get_post_meta($post->ID, 'neuralResonance', true);
$neuralBreathing = get_post_meta($post->ID, 'neuralBreathing', true);
$cognitiveStimulation = get_post_meta($post->ID, 'cognitiveStimulation', true);
?>

<div class="card mb-3">
    <div class="container padding-container-card">
        <div class="card-body">
            <!--1-->
            <div class="timeline-trainings mb-5">
                <div class="lines-trainings">
                    <div class="dot-trainings class-videoTraining"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-videoTraining.svg
" alt="Video Treinamento" width="40" height="40"></div>
                    <div class="line-trainings"></div>
                </div>
                <div class="class-trainings">
                    <h5 class="fw-bold text-uppercase mb-3">Vídeo explicativo</h5>
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/?controls=0" frameborder="0"
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture;"></iframe>
                </div>
            </div>
            <!--2-->
            <div class="timeline-trainings mb-5">
                <div class="lines-trainings">
                    <div class="dot-trainings class-videoTraining"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralResonance.svg
" alt="Video Treinamento" width="40" height="40"></div>
                    <div class="line-trainings"></div>
                </div>
                <div class="class-trainings">
                    <h5 class="fw-bold text-uppercase mb-3">Ressonância neural</h5>
                    <audio controls controlsList="nodownload" width="100%" id="audioPlayer">
                        <source src="<?php echo $neuralResonance; ?>" type="audio/wav">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
            <!--3-->
            <div class="timeline-trainings mb-5">
                <div class="lines-trainings">
                    <div class="dot-trainings class-videoTraining"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-cognitiveStimulation.svg
" alt="Video Treinamento" width="40" height="40"></div>
                    <div class="line-trainings"></div>
                </div>
                <div class="class-trainings">
                    <h5 class="fw-bold text-uppercase mb-3">Estimulação Cognitiva</h5>
                    <div class="row m-0 m-auto">
                        <a role="button" class="btn btn-lg btn-secondary" target="_blank"
                            href="<?php echo $cognitiveStimulation; ?>" id="gameplay">Iniciar</a>
                    </div>
                </div>
            </div>
            <!--4-->
            <div class="timeline-trainings mb-5">
                <div class="lines-trainings">
                    <div class="dot-trainings class-videoTraining"><img src="https://lellyoliver.com.br/academiadaneurociencia/wp-content/uploads/2023/09/icon-neuralBreathing.svg
" alt="Video Treinamento" width="40" height="40"></div>
                    <div class="line-trainings"></div>
                </div>
                <div class="class-trainings">
                    <h5 class="fw-bold text-uppercase mb-3">Respiração Neural</h5>
                    <video width="100%" height="500" id="videoPlayer" controls>
                        <source src="<?php echo $neuralBreathing; ?>" type="video/mp4">
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
                <input type="hidden" value="<?php echo date('Y-m-d', current_time('timestamp', 0));?>"
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