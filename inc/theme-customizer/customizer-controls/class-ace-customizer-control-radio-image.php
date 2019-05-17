<?php


if ( ! class_exists( 'Customize_Control_Radio_Image' ) ) {
    return;
}

if ( ! class_exists( 'AceCustomizerControlRadioImage' ) ) {
class AceCustomizerControlRadioImage extends Customize_Control_Radio_Image {


    	/**
	 * Loads the jQuery UI Button script and hooks our custom styles in.
	 *
	 * @since  1.1.24
	 * @access public
	 * @return void
	 */
	public function enqueue() {
        parent::enqueue();
	}
	/**
	 * Outputs custom styles to give the selected image a visible border.
	 *
	 * @since  1.1.24
	 * @access public
	 * @return void
	 */
	public function print_styles() {
        //parent::print_styles();
	?>

		<style type="text/css" id="ace-hybrid-customize-radio-image-css">
			.customize-control-radio-image .ui-buttonset {
				text-align: center;
			}

			.customize-control-radio-image label {
				display: inline-block;
				max-width: 33.3%;
				padding: 3px;
				font-size: inherit;
				line-height: inherit;
				height: auto;
				cursor: pointer;
				border-width: 0;
				-webkit-appearance: none;
				-webkit-border-radius: 0;
				border-radius: 0;
				white-space: nowrap;
				-webkit-box-sizing: border-box;
				-moz-box-sizing: border-box;
				box-sizing: border-box;
				color: inherit;
				background: none;
				-webkit-box-shadow: none;
				box-shadow: none;
				vertical-align: inherit;
			}

			.customize-control-radio-image label:first-of-type {
				float: left;
			}
			.customize-control-radio-image label:nth-of-type(n + 3){
				float: right;
			}

			.customize-control-radio-image label:hover {
				background: none;
				border-color: inherit;
				color: inherit;
			}

			.customize-control-radio-image label:active {
				background: none;
				border-color: inherit;
				-webkit-box-shadow: none;
				box-shadow: none;
				-webkit-transform: none;
				-ms-transform: none;
				transform: none;
			}

			.customize-control-radio-image img { border: 1px solid transparent; }
			.customize-control-radio-image .ui-state-active img {
				border-color: #5b9dd9;
				-webkit-box-shadow: 0 0 3px rgba(0,115,170,.8);
				box-shadow: 0 0 3px rgba(0,115,170,.8);
			}
		</style>
	<?php
	}

}
}