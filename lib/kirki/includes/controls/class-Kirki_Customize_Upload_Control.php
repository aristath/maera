<?php

/**
 * Customize Upload Control Class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
class Kirki_Customize_Upload_Control extends WP_Customize_Control {
	public $type    = 'upload';
	public $removed = '';
	public $context;
	public $extensions = array();

	public $description = '';

	public $subtitle = '';

	public $separator = false;

	public $required;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'wp-plupload' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['removed'] = $this->removed;

		if ( $this->context )
			$this->json['context'] = $this->context;

		if ( $this->extensions )
			$this->json['extensions'] = implode( ',', $this->extensions );
	}

	/**
	 * Render the control's content.
	 *
	 * @since 3.4.0
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
					<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
				<?php } ?>
			</span>

			<?php if ( '' != $this->subtitle ) : ?>
				<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
			<?php endif; ?>

			<div>
				<a href="#" class="button-secondary upload"><?php _e( 'Upload' ); ?></a>
				<a href="#" class="remove"><?php _e( 'Remove' ); ?></a>
			</div>
		</label>
		<?php if ( $this->separator ) echo '<hr class="customizer-separator">'; 

		foreach ( $this->required as $id => $value ) : ?>
			<script>
			jQuery(document).ready(function($) {
			<?php if ( isset($id) && isset($value) && intval(get_theme_mod($id))==$value ) { ?>
				$("#customize-control-<?php echo $this->id; ?>").removeClass('hide');
			<?php } elseif ( isset($id) && isset($value) && intval(get_theme_mod($id))!=$value ) { ?>
				$("#customize-control-<?php echo $this->id; ?>").addClass('hide');
			<?php }	?>
				$( "#input_<?php echo $id; ?> input" ).each(function(){
					$(this).click(function(){
						if ( $(this).val() == <?php echo $value; ?> ) {
							$("#customize-control-<?php echo $this->id; ?>").removeClass('hide');
						} else {
							$("#customize-control-<?php echo $this->id; ?>").addClass('hide');
						}
					});
				});
			});
			</script>
		<?php endforeach;
	}
}
