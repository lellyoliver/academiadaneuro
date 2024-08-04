<p class="text-white"><i class="fa-solid fa-clock me-2"></i> Última atualização:
    <?php echo esc_html($updated); ?> | <a data-bs-toggle="modal" data-bs-target="#modalSaibaMais"
        style="cursor:pointer;"><i class="fa-solid fa-circle-info me-2"></i> <span style="font-size:16px;"><b>Instruções</b></span></a></p>


<div class="modal fade" id="modalSaibaMais" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="true"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Saiba Mais
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <p><?php echo $infos['textTraining']; ?></p>
                <br>
                <p><?php echo $infos['usageTips']; ?></p>
                <br>
                <p><?php echo $infos['recommendations']; ?></p>
            </div>
        </div>
    </div>
</div>

<script>
const myModal = new bootstrap.Modal(
    document.getElementById("modalSaibaMais"),
    options,
);
</script>