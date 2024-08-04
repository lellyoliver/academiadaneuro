<style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        #meuIframe {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
<div class="box">
    <iframe id="meuIframe" src="<?php echo esc_url($cognitive_stimulation); ?>"></iframe>
</div>