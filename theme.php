<?php

/**
 * MyTheme is a custom Theme class for the Simplerer theme.
 *
 * @package Habari
 */

/**
 * @todo This stuff needs to move into the custom theme class:
 */

// Apply Format::autop() to post content...
Format::apply( 'autop', 'post_content_out' );
// Apply Format::autop() to comment content...
Format::apply( 'autop', 'comment_content_out' );
// Apply Format::tag_and_list() to post tags...
Format::apply( 'tag_and_list', 'post_tags_out' );
// Apply Format::nice_date() to post date...
Format::apply( 'nice_date', 'post_pubdate_out', 'F j, Y \a\t g:ia' );
Format::apply( 'nice_date', 'comment_date_out', 'F j, Y \a\t g:ia' );

//////////////////////Format::apply_with_hook_params( 'more', 'post_content_out', 'more', 100, 1 );

// We must tell Habari to use MyTheme as the custom theme class:
define( 'THEME_CLASS', 'MyTheme' );

/**
 * A custom theme for Simpler output
 */
class Simplerer extends Theme
{

	/**
	 * Add additional template variables to the template output.
	 *
	 *  You can assign additional output values in the template here, instead of
	 *  having the PHP execute directly in the template.  The advantage is that
	 *  you would easily be able to switch between template types (RawPHP/Smarty)
	 *  without having to port code from one to the other.
	 *
	 *  You could use this area to provide "recent comments" data to the template,
	 *  for instance.
	 *
	 *  Note that the variables added here should possibly *always* be added,
	 *  especially 'user'.
	 *
	 *  Also, this function gets executed *after* regular data is assigned to the
	 *  template.  So the values here, unless checked, will overwrite any existing
	 *  values.
	 */
	public function add_template_vars()
	{
		if( !$this->template_engine->assigned( 'pages' ) ) {
			$this->assign('pages', Posts::get( array( 'content_type' => 'page', 'status' => Post::status('published'), 'nolimit' => 1 ) ) );
		}
		if( !$this->template_engine->assigned( 'user' ) ) {
			$this->assign('user', User::identify() );
		}
		if( !$this->template_engine->assigned( 'page' ) ) {
			$page = Controller::get_var( 'page' );
			$this->assign('page', isset( $page ) ? $page : 1 );
		}

		$copyright = Options::get( 'simplerer__copyright_notice' );

		if ( $copyright == null ) {
			$copyright = '&copy; Copyright ' . date('Y') . '. All Rights Reserved.';
		}
		else {
			$copyright = str_replace( '%year', date('Y'), $copyright );
		}

		$this->assign( 'copyright', $copyright );

		parent::add_template_vars();
	}


	public function action_update_check() {
		Update::add( 'Simpler Theme', 'b903172d-caa2-487a-81ec-e7a41dd76c5e', $this->version );
	}

	/**
	* Respond to the user selecting 'configure' on the themes page
	*
	*/
	public function action_theme_ui()
	{
		$form = new FormUI( 'simplerer_theme' );

		$copyright_notice = $form->append('text', 'copyright_notice', 'simplerer__copyright_notice', _t( 'Copyright Notice' ) );
		$copyright_notice->template = 'optionscontrol_text';
		$copyright_notice->class = 'clear';
		$copyright_notice->raw = true;
		$copyright_notice->helptext = _t( 'Use %year to substitute in the current year.' );

		$form->append('submit', 'save', 'Save');
		$form->set_option( 'success_message', _t( 'Theme Settings Updated' ) );
		$form->out();
	}

	public function action_form_comment( $form ) {
		$form->append( 'fieldset', 'cf_fieldset', 'Leave a comment' );
		$form->cf_content->move_into( $form->cf_fieldset );
		$form->cf_content->rows = 5;
		$form->cf_content->tabindex = 1;
		$form->cf_commenter->move_into( $form->cf_fieldset );
		$form->cf_commenter->tabindex = 2;
		$form->cf_email->move_into( $form->cf_fieldset );
		$form->cf_email->tabindex = 3;
		$form->cf_url->move_into( $form->cf_fieldset );
		$form->cf_url->tabindex = 4;
		$form->cf_submit->move_into( $form->cf_fieldset );
		$form->cf_submit->tabindex = 5;

	}
}


?>
