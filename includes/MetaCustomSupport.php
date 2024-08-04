<?php
class MetaCustomSupport
{

    private $fields;

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_custom_fields_metabox'));
    }

    public function add_custom_fields_metabox()
    {
        add_meta_box(
            'custom_fields_metabox',
            __('Anexos'),
            array($this, 'render_custom_fields_metabox'),
            'customer-support',
            'normal',
            'high'
        );
    }

    public function render_custom_fields_metabox($post)
    {
        $anexo_id = get_post_meta($post->ID, '_attachment_support', true);
        $url = wp_get_attachment_image_url($anexo_id, '');
        ?>

<style>
    img.img-anexo{
        max-width:50%;
    }
</style>
<img src="<?php echo $url;?>" class="img-anexo">

<?php
}
}

new MetaCustomSupport();