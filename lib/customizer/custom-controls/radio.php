<?php

class SS_Customize_Radio_Control extends WP_Customize_Control {

	public $type = 'radio';

	public $description = '';

	public $mode = 'radio';

	public function enqueue() {

		if ( 'buttonset' == $this->mode ) {
			wp_enqueue_script( 'jquery-ui-button' );
		}

	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;

		?>
		<span class="customize-control-title">
			<?php echo esc_html( $this->label ); ?>
			<?php if ( isset( $this->description ) && '' != $this->description ) { ?>
				<a href="#" class="button tooltip" title="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
			<?php } ?>
		</span>
		<div id="input_<?php echo $this->id; ?>">
			<?php
			foreach ( $this->choices as $value => $label ) :
				?>
				<label class="customizer-radio">
					<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
					<?php echo esc_html( $label ); ?><br/>
				</label>
				<?php
			endforeach;
			?>
		</div>
		<?php if ( 'buttonset' == $this->mode ) { ?>
			<script>
			jQuery(document).ready(function($) {
				$( "#input_<?php echo $this->id; ?>" ).buttonset();
			});
			</script>
		<?php }
	}
}
