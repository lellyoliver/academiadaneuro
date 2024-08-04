<div class="loading" style="display:none" id="loading">
    <div class="overlay"></div>
    <div class="spinner-container">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
<div class="card">
    <div class="container padding_container__card">
        <div class="card-body">
            <div class="d-flex align-items-center align-self-center">
                <h6 class="card-title fw-bold title-cards text-uppercase me-2 m-0">
                    <?php echo esc_html('Suporte ao Cliente'); ?>
                </h6>
            </div>
            <span>Entraremos em contato por e-mail. Fique atento!</span>
            <div class="mb-4"></div>
            <div class="row">
                <form id="form-support" method="post">
                    <div class="mb-4">
                        <label for="comment_support" class="form-label">Descreva o seu problema</label>
                        <textarea class="form-control" name="comment_support" id="comment_support" rows="3"></textarea>
                    </div>
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo get_current_user_id(); ?>">
                    <div class="row m-0 m-auto">
                        <button type="submit" class="btn btn-lg btn-secondary" id="btnSave">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="carousel-card">
        <?php if ($supports):
    foreach ($supports as $support):
        if ($support['user_id'] == get_current_user_id()):
        ?>
        <div class="carousel-item-card">
            <div class="card-support">
                <div class="card-body">
                    <p style="font-size:12px;">
                        <?php echo '<b>' . $support['protocolo'] . '</b> | ' . $support['date']; ?>
                    </p>
                    <p class="comment_user" class="m-0">
                        <?php echo $support['message']; ?>
                    </p>
                </div>
                <div class="card-footer" id="heading">
                    <div class="d-flex align-items-center align-self-center justify-content-between">
                        <span
                            class="reply"><?php echo '<i class="fa-solid ' . $support['taxonomies']['icon'] . '"></i> ' . $support['taxonomies']['term']; ?></span>
                        <button class="ms-3 btn btn-sm btn-secondary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse-<?php echo $support['id']; ?>" aria-expanded="true"
                            aria-controls="collapse-<?php echo $support['id']; ?>"><span data-bs-toggle="tooltip" data-bs-placement="right" title="Click duas vezes">Solução <i
                                class="fa-solid fa-caret-down"></i></span></button>
                    </div>
                    <?php if ($support['taxonomies']['valid']): ?>
                    <div id="collapse-<?php echo $support['id']; ?>" class="accordion-collapse collapse mt-3"
                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="chat m-0">
                                <p>
                                    <?php echo $support['comments']['content']; ?>
                                </p>
                                <div class="datetime-chat">
                                    <p class="m-0"><?php echo $support['comments']['date']; ?> | Suporte</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php endif;endforeach;endif;?>
    </div>
    <div class="carousel-nav" style="padding:0px 12px;">
        <button class="prev btn btn-sm btn-secondary me-2"><i class="fa fa-chevron-left"></i></button>
        <button class="next btn btn-sm btn-secondary"><i class="fa fa-chevron-right"></i></button>
    </div>
</div>

<script>
let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
document.querySelectorAll('.comment_user').forEach(function(element) {
    let isExpanded = false;
    const originalText = element.textContent;
    const truncatedText = originalText.substring(0, 130) + '...[click]';

    element.textContent = truncatedText;

    element.addEventListener('click', function() {
        if (isExpanded) {
            element.textContent = truncatedText;
        } else {
            element.textContent = originalText;
        }
        isExpanded = !isExpanded;
    });
});
</script>