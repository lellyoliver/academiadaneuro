<?php if ($questions): ?>
<div class="question-container">
    <?php
$i = 1;

foreach ($questions as $field => $values):
    foreach ($values as $key => $value):
    ?>
	    <div class="question" data-question="<?php echo $i++; ?>" style="display: none;">
	        <h5 class="text-center mb-5"><?php echo esc_html($value); ?></h5>
	        <div class="options">
	            <button class="option" data-value="5"
	                data-question="<?php echo esc_attr($field . '-' . $key); ?>">Sempre</button>
	            <button class="option" data-value="4"
	                data-question="<?php echo esc_attr($field . '-' . $key); ?>">Quase Sempre</button>
	            <button class="option" data-value="3" data-question="<?php echo esc_attr($field . '-' . $key); ?>">Às
	                Vezes</button>
	            <button class="option" data-value="2"
	                data-question="<?php echo esc_attr($field . '-' . $key); ?>">Raramente</button>
	            <button class="option" data-value="1"
	                data-question="<?php echo esc_attr($field . '-' . $key); ?>">Nunca</button>
	        </div>
	        <input type="hidden" class="fields" id="<?php echo esc_attr($field . '-' . $key); ?>"
	            name="<?php echo esc_attr($field . '-' . $key); ?>">
	    </div>
	    <?php endforeach;endforeach;?>
    <input type="hidden" name="user_id" id="user_id" value="<?php echo get_current_user_id(); ?>">
    <!-- <button type="submit" class="btn btn-primary" id="submit-new-training">Gera treinamento </button> -->

</div>
<?php endif;?>

<div class="navigation-buttons">
    <button id="prevButton" onclick="showPreviousQuestion()" disabled>Anterior</button>
    <button id="nextButton" onclick="showNextQuestion()">Próximo</button>
</div>

<script>
	let currentQuestion = 1;
    const totalQuestions = document.querySelectorAll('.question').length;

    document.querySelectorAll('.option').forEach(button => {
        button.addEventListener('click', () => {
            const questionId = button.getAttribute('data-question');
            document.querySelectorAll(`.option[data-question="${questionId}"]`).forEach(btn => btn.classList
                .remove('selected'));
            button.classList.add('selected');
            document.getElementById(questionId).value = button.getAttribute('data-value');
        });
    });

    function updateProgressBar() {
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        const progressPercentage = (currentQuestion / totalQuestions) * 100;
        progressBar.style.width = progressPercentage + '%';
        progressBar.setAttribute('aria-valuenow', progressPercentage);
        progressText.textContent = `${currentQuestion} de ${totalQuestions}`;
    }

    function showNextQuestion() {
        if (currentQuestion < totalQuestions) {
            document.querySelector(`.question[data-question="${currentQuestion}"]`).style.display = 'none';
            currentQuestion++;
            document.querySelector(`.question[data-question="${currentQuestion}"]`).style.display = 'block';
            document.getElementById('prevButton').disabled = false;
            if (currentQuestion === totalQuestions) {
                document.getElementById('nextButton').disabled = true;
                document.getElementById('create-training').style.display = 'block'; // Show the submit button at the end
            }
            updateProgressBar();
        }
    }

    function showPreviousQuestion() {
        if (currentQuestion > 1) {
            document.querySelector(`.question[data-question="${currentQuestion}"]`).style.display = 'none';
            currentQuestion--;
            document.querySelector(`.question[data-question="${currentQuestion}"]`).style.display = 'block';
            document.getElementById('nextButton').disabled = false;
            if (currentQuestion === 1) {
                document.getElementById('prevButton').disabled = true;
            }
            updateProgressBar();
        }
    }

    // Initialize the first question and progress bar
    document.querySelector(`.question[data-question="${currentQuestion}"]`).style.display = 'block';
    updateProgressBar();
</script>