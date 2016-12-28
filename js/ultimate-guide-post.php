<?php
/*
Plugin Name: Ultimate Guide Post
Description: 
Plugin URI: http://#
Author: Author
Author URI: http://#
Version: 1.0
License: GPL2
Text Domain: tkugp
Domain Path: /lang
*/

if( !defined('TKUGP_POST'))
	define('TKUGP_POST', 'guide');

add_action('wp_enqueue_scripts', 'tkugp_front_scripts');
function tkugp_front_scripts(){
	
	$settings = tkugp_guidepost_settings();

	if( $settings['fa'] == 1 ){
		wp_enqueue_style( 'font-awesome', plugins_url( 'css/css/font-awesome.min.css', __FILE__));
	}

	if( $settings['css'] == 1 ){
		wp_enqueue_style( 'tkugp-style', plugins_url( 'css/guide-post.css', __FILE__));
	}
		
	wp_enqueue_script( 'tkugp-script', plugins_url( 'js/guide-post.js', __FILE__), array('jquery') );
	wp_enqueue_script('jquery');
}

add_action('admin_enqueue_scripts', 'tkugp_scripts');
function tkugp_scripts(){

	if ((isset($_GET['post_type']) && $_GET['post_type'] == TKUGP_POST ) || ( isset($_GET['post']) && get_post_type($_GET['post']) == TKUGP_POST ) ) {

		wp_enqueue_style( 'tkugp-guide-post', plugins_url( 'css/admin-guide-post.css', __FILE__));
		wp_enqueue_media();
		wp_enqueue_script( 'tkugp-suggest', plugins_url( 'js/jquery.suggest.js', __FILE__), array('jquery') );
		wp_enqueue_script( 'tkugp-guide-post', plugins_url( 'js/admin-guide-post.js', __FILE__), array('jquery') );
	}

}

add_action('admin_menu' , 'brdesign_enable_pages');
function brdesign_enable_pages() {
    add_submenu_page('edit.php?post_type=guide', 'Settings', 'Settings', 'edit_posts', basename(__FILE__), 'tkugp_guide_post_settings');
}

function tkugp_guidepost_settings(){

		$default = array(
					'css' => 1,
					'fa' => 1,
				);

	$settings = get_option( 'tkugp_guide_post_settings', $default );

	return $settings;
}
function tkugp_guide_post_settings(){

	if( isset($_POST['save_tkugp_guide_post_settings'])){

		$settings = $_POST['tkugp_guide_post_settings'];
		update_option( 'tkugp_guide_post_settings', $settings );
	}

$settings = tkugp_guidepost_settings();

?>
	<div class="wrap">
		<h3>Guide Post Settings</h3>
		<form action="" method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<td scope="row"><label>Plugin CSS</label></td>
						<td><input type="checkbox" name="tkugp_guide_post_settings[css]" value="1" <?php checked( 1, $settings['css'], true ); ?> />Include Plugin CSS</td>
					</tr>	
					<tr>
						<td scope="row"><label>Font Awesome CSS</label></td>
						<td><input type="checkbox" name="tkugp_guide_post_settings[fa]" value="1" <?php checked( 1, $settings['fa'], true ); ?> />Include <a href="https://fortawesome.github.io/Font-Awesome/" target="_blank">Font Awesome</a> CSS</td>
					</tr>		
				</tbody>
			</table>
			<p><input type="submit" class="button button-primary" name="save_tkugp_guide_post_settings" value="Save Settings" /></p>
		</form>

	</div>
<?php
}


/* register custom taxonomy for guide post type */
if ( ! function_exists( 'tkugp_taxonomy' ) ) {

// Register Custom Taxonomy
function tkugp_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'tkugp' ),
		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'tkugp' ),
		'menu_name'                  => __( 'Category', 'tkugp' ),
		'all_items'                  => __( 'All Categories', 'tkugp' ),
		'parent_item'                => __( 'Parent Category', 'tkugp' ),
		'parent_item_colon'          => __( 'Parent Category:', 'tkugp' ),
		'new_item_name'              => __( 'New Category Name', 'tkugp' ),
		'add_new_item'               => __( 'Add New Category', 'tkugp' ),
		'edit_item'                  => __( 'Edit Category', 'tkugp' ),
		'update_item'                => __( 'Update Category', 'tkugp' ),
		'view_item'                  => __( 'View Category', 'tkugp' ),
		'separate_items_with_commas' => __( 'Separate categories with commas', 'tkugp' ),
		'add_or_remove_items'        => __( 'Add or remove categories', 'tkugp' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'tkugp' ),
		'popular_items'              => __( 'Popular Categories', 'tkugp' ),
		'search_items'               => __( 'Search Categories', 'tkugp' ),
		'not_found'                  => __( 'Not Found', 'tkugp' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( TKUGP_POST . '_cat', array( TKUGP_POST ), $args );

}
add_action( 'init', 'tkugp_taxonomy', 0 );

}

/* register custom tag */

if ( ! function_exists( 'tkugp_tag' ) ) {

// Register Custom Taxonomy
function tkugp_tag() {

	$labels = array(
		'name'                       => _x( 'Tags', 'Taxonomy General Name', 'tkugp' ),
		'singular_name'              => _x( 'Tag', 'Taxonomy Singular Name', 'tkugp' ),
		'menu_name'                  => __( 'Tag', 'tkugp' ),
		'all_items'                  => __( 'All Tags', 'tkugp' ),
		'parent_item'                => __( 'Parent Tag', 'tkugp' ),
		'parent_item_colon'          => __( 'Parent Tag:', 'tkugp' ),
		'new_item_name'              => __( 'New TagName', 'tkugp' ),
		'add_new_item'               => __( 'Add New Tag', 'tkugp' ),
		'edit_item'                  => __( 'Edit Tag', 'tkugp' ),
		'update_item'                => __( 'Update Tag', 'tkugp' ),
		'view_item'                  => __( 'View Tag', 'tkugp' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'tkugp' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'tkugp' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'tkugp' ),
		'popular_items'              => __( 'Popular Tags', 'tkugp' ),
		'search_items'               => __( 'Search Tags', 'tkugp' ),
		'not_found'                  => __( 'Not Found', 'tkugp' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( TKUGP_POST . '_tag', array( TKUGP_POST ), $args );

}
add_action( 'init', 'tkugp_tag', 0 );

}


/* register custom post type */

if ( ! function_exists('tkugp_post_type') ) {

// Register Custom Post Type
function tkugp_post_type() {

	$labels = array(
		'name'                => _x( 'Guide Posts', 'Post Type General Name', 'tkugp' ),
		'singular_name'       => _x( 'Guide Post', 'Post Type Singular Name', 'tkugp' ),
		'menu_name'           => __( 'Guide Post', 'tkugp' ),
		'name_admin_bar'      => __( 'Guide Post', 'tkugp' ),
		'parent_item_colon'   => __( 'Parent Guide Post:', 'tkugp' ),
		'all_items'           => __( 'All Guide Posts', 'tkugp' ),
		'add_new_item'        => __( 'Add New Guide Post', 'tkugp' ),
		'add_new'             => __( 'Add New', 'tkugp' ),
		'new_item'            => __( 'New Guide Post', 'tkugp' ),
		'edit_item'           => __( 'Edit Guide Post', 'tkugp' ),
		'update_item'         => __( 'Update Guide Post', 'tkugp' ),
		'view_item'           => __( 'View Guide Post', 'tkugp' ),
		'search_items'        => __( 'Search Guide Post', 'tkugp' ),
		'not_found'           => __( 'Not found', 'tkugp' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tkugp' ),
	);
	$args = array(
		'label'               => __( 'Guide Post', 'tkugp' ),
		'description'         => __( 'Ultimate Guide Post', 'tkugp' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'editor'),
		'taxonomies'          => array( TKUGP_POST . '_cat', TKUGP_POST . '_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,		
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( TKUGP_POST, $args );

}
add_action( 'init', 'tkugp_post_type', 0 );

}

/* metabox */
add_action( 'add_meta_boxes', 'tkugp_list_item_add_meta_box' );
add_action( 'save_post', 'tkugp_list_item_save' );


function tkugp_list_item_add_meta_box() {
	

		add_meta_box(
			'tkugp_addnew_button_metabox',
			__( 'Button', 'tkuugp' ),
			'tkugp_addnew_button_html',
			TKUGP_POST,
			'normal',
			'default'
		);
	


	
}

function tkugp_addnew_button_html( $post) {


?>
	<div id="tkugp_items_list_html">
			<?php $items = get_post_meta( $post->ID, 'tkugp_list_item', true); ?>
			<?php 

			

			if( !empty($items)){

				foreach ($items as $key => $item) { 

					echo  tkugp_items_content_html($key, $item); 
				
				}

			} 
			?>			
	</div>
	<div style="display:none !important;" id="tkugp_categories_options"><?php echo  tkugp_categories_option(); ?></div>
	<ul  style="display:none !important;" id="tkugp_tags_all"><?php echo tkugp_tags_all(); ?></ul>
	
	<input type="hidden" id="tkgup_list_item_count" name="tkgup_list_item_count" value="<?php echo count($items); ?>" />
	
	<input type="button" class="button button-secondary" id="tkugp-addnew-button" value="Add Item">
	<input name="tkugp_save" type="submit" class="button button-primary button-large" id="tkugp_publish" value="Save Settings">
<?php
}

function tkugp_list_item_save( $post_id ) {

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if( get_post_type($post_id) != TKUGP_POST ){
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	

	

		$post_settings = $_POST['tkugp_post_settings'];
		$post_items = $_POST['tkugp_list_item'];

		if( !empty($post_items)){
			foreach ( $post_items as $key => $item ) {
				
				$items[] = array(

							'title' 	=> $item['title'],
							'content' 	=> $item['content'],
							'category' 	=> $item['category'],
							'tags' 		=> $item['tag'],
							'favrt' 	=> $item['favrt'],
							'image' 	=> $item['image'],
							'link' 		=> $item['link'],

							);

			}
		}




		update_post_meta($post_id, 'tkugp_post_settings', $post_settings);
		update_post_meta($post_id, 'tkugp_list_item', $items);


}

function tkugp_items_content_html($ID, $item){
		
		$item_html = '';
		$tagslist = tkugp_tags_selected_item($ID, $item);
		$category_option = tkugp_categories_option($item['category']);

		$item_html .= '<div id="tkugp_list_item_'.$ID.'" class="postbox tkugp_list_item">';
		$item_html .= '<div class="handlediv" title="Click to toggle"><br></div><h3 class="hndle ui-sortable-handle"><span>List Item</span></h3>';
		$item_html .= '<div class="inside">';
		/*$item_html .= '<p>Add List item content</p>';*/
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_title_'.$ID.'">Title</label>';
		$item_html .= '<input type="text" name="tkugp_list_item['.$ID.'][title]" class="tkugp_list_item_title" id="tkugp_list_item_title_'.$ID.'" value="'.$item['title'].'">';
		$item_html .= '</p>';	
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_content_'.$ID.'">Content</label>';
		$item_html .= '<textarea name="tkugp_list_item['.$ID.'][content]" class="tkugp_list_item_content" id="tkugp_list_item_content_'.$ID.'">'.$item['content'].'</textarea>';
		$item_html .= '</p>';	
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_image_'.$ID.'">Image</label>';
		$item_html .= '<img id="tkugp_list_item_preview_'.$ID.'" class="tkugp_list_item_preview" src="'.$item['image'].'" alt="Image Preview" /><span id="tkugp_list_item_imgdel_'.$ID.'" title="Delete this Image" class="tkugp_list_item_imgdel">Delete Image</span>';
		$item_html .= '<input type="text" name="tkugp_list_item['.$ID.'][image]" class="tkugp_list_item_image" id="tkugp_list_item_image_'.$ID.'" value="'.$item['image'].'">';
		$item_html .= '<input type="button" name="tkugp_list_item_uploadimage_'.$ID.'" class="button button-secondary tkugp_list_item_uploadimage" id="tkugp_list_item_uploadimage_'.$ID.'" value="Upload Image">';
		$item_html .= '</p>';
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_category_'.$ID.'">Category</label>';
		$item_html .= '<select name="tkugp_list_item['.$ID.'][category]" class="tkugp_list_item_category" id="tkugp_list_item_category_'.$ID.'">'.$category_option.'</select>';
		$item_html .= '<a class="tkugp_list_item_newcategory" id="tkugp_list_item_newcategory_'.$ID.'" href="javascript:void(0)">+Add New Catgory</a>';	
		$item_html .= '</p>';	
		$item_html .= '<p>';
		$item_html .= '<label for="tkugp_list_item_tags_'.$ID.'">Tags</label>';
		$item_html .= '<span id="tkgup_list_item_taglist_'.$ID.'" class="tkgup_list_item_taglist">'.$tagslist.'</span>';
		$item_html .= '<input type="text" name="tkugp_list_item['.$ID.'][tags]" class="tkugp_list_item_tags" id="tkugp_list_item_tags_'.$ID.'" value=""><a href="javascript:void(0);" class="tkugp_list_item_newtag" id="tkugp_list_item_newtag_'.$ID.'">+Add</a>';
		$item_html .= '</p>';
		$item_html .= '<label for="tkugp_list_item_favrt_'.$ID.'">Author Favourite</label>';
		$item_html .= '<p><select name="tkugp_list_item['.$ID.'][favrt]" class="tkugp_list_item_favrt" id="tkugp_list_item_favrt_'.$ID.'"><option '.selected( 1, $item['favrt'], false).' value="1">Yes</option><option '.selected( 2, $item['favrt'], false).' value="2">No</option></select></p>';
		$item_html .= '<label for="tkugp_list_item_link_'.$ID.'">Link</label>';
		$item_html .= '<p><input type="text"  class="tkugp_list_item_link" id="tkugp_list_item_link_'.$ID.'" name="tkugp_list_item['.$ID.'][link]" value="'.$item['link'].'" /></p>';
		$item_html .= '<p><input type="button" class="button button-secondary tkugp_remove_item" id="tkugp_remove_item_'.$ID.'" value="Remove Item" /></p>';
		$item_html .= '</div>';
		$item_html .= '</div>';

		return $item_html;

}


function tkugp_categories_option( $selected=''){

	//no default values. using these as examples
	$taxonomies = array(TKUGP_POST . '_cat');

	$args = array(
	    'orderby'           => 'name', 
	    'order'             => 'ASC',
	    'hide_empty'        => false, 
	    'exclude'           => array(), 
	    'exclude_tree'      => array(), 
	    'include'           => array(),
	    'number'            => '', 
	    'fields'            => 'all', 
	    'slug'              => '',
	    'parent'            => '',
	    'hierarchical'      => true, 
	    'child_of'          => 0,
	    'childless'         => false,
	    'get'               => '', 
	    'name__like'        => '',
	    'description__like' => '',
	    'pad_counts'        => false, 
	    'offset'            => '', 
	    'search'            => '', 
	    'cache_domain'      => 'core'
	); 

	$terms = get_terms($taxonomies, $args);

	$options = '<option value="">- Select Category-</option>';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
          foreach ( $terms as $term ) {
      		$options .= '<option '.selected( $selected, $term->term_id, false).' value="'.$term->term_id.'">' . $term->name . '</option>';
    	 }
     
 	}


 	return $options;

}

function tkugp_tags_all(){

	//no default values. using these as examples
	$taxonomies = array(TKUGP_POST . '_tag');

	$args = array(
	    'orderby'           => 'name', 
	    'order'             => 'ASC',
	    'hide_empty'        => false, 
	    'exclude'           => array(), 
	    'exclude_tree'      => array(), 
	    'include'           => array(),
	    'number'            => '', 
	    'fields'            => 'all', 
	    'slug'              => '',
	    'parent'            => '',
	    'hierarchical'      => true, 
	    'child_of'          => 0,
	    'childless'         => false,
	    'get'               => '', 
	    'name__like'        => '',
	    'description__like' => '',
	    'pad_counts'        => false, 
	    'offset'            => '', 
	    'search'            => '', 
	    'cache_domain'      => 'core'
	); 

	$terms = get_terms($taxonomies, $args);

	$tags = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
          foreach ( $terms as $term ) {
      		$tags .= '<li id="tkgup_posttag_'.$term->term_id.'">'.$term->name.'</li>';
    	 }
     
 	}


 	return $tags;

}

function tkugp_tags_selected($post_id, $ID){

	$terms = wp_get_post_terms($post_id, TKUGP_POST . '_tag', array("fields" => "all"));
	
	$tags = '';
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
          foreach ( $terms as $term ) {
      		$tags .= '<span id="tkgup_list_item_tagitem_'.$ID.'_'.$term->term_id.'">';
      		$tags .= '<a href="javascript:void(0);" class="ntdelbutton tkgup_list_item_deltag" id="tkgup_list_item_deltag_'.$ID.'_'.$term->term_id.'">X</a>';
      		$tags .= '&nbsp;'.$term->name.'<input type="hidden" name="tkugp_list_item['.$ID.'][tag][]" value="'.$term->term_id.'" /></span>';
    	 }
     
 	}


 	return $tags;

}


function tkugp_tags_selected_item($ID, $tags){


	$tags_html = '';

	if ( ! empty( $tags['tags'] ) ){

          foreach ( $tags['tags'] as $key => $term_id ) {
          	
          	$term = get_term( $term_id, TKUGP_POST . '_tag' );
          	$tagid = $term->term_id;
          	$tagname = $term->name;

      		$tags_html .= '<span id="tkgup_list_item_tagitem_'.$ID.'_'.$tagid.'">';
      		$tags_html .= '<a href="javascript:void(0);" class="ntdelbutton tkgup_list_item_deltag" id="tkgup_list_item_deltag_'.$ID.'_'.$tagid.'">X</a>';
      		$tags_html .= '&nbsp;'.$tagname.'<input type="hidden" name="tkugp_list_item['.$ID.'][tag][]" value="'.$tagid.'" /></span>';
    	 }
     
 	}

 	
 	return $tags_html;
}

add_action('wp_ajax_tkugp_admin_addcat' , 'ajax_tkugp_addnew_cat');
function ajax_tkugp_addnew_cat(){

	$catname = $_POST['catname'];
	$post_id = $_POST['postid'];


	$status  = array('msg' =>'', 'status' =>'');

	if( $post_id && '' != $post_id ){

			$term = term_exists($catname, TKUGP_POST . '_cat' );

		if ($term !== 0 && $term !== null) {
				
			$status = array('msg' => 'Error: Category already exist.', 'status' => 2, 'tagid' => $term['term_id'] );

		} else {

			$terms = wp_insert_term($catname, TKUGP_POST . '_cat');

			if ( is_wp_error( $terms ) ) {
				
				$status = array('msg' => 'Error: Adding new category.', 'status' => 0 );	

			} else {


				if( !tkugp_set_termcat($post_id, $terms['term_id']) ){

					$status = array('msg' => 'Error: Could not assign category to post.', 'status' => 0);	
				
				} else {

					$status = array('msg' => 'Success: New category added and assigned to post.', 'status' => 1, 'catid' => $terms['term_id']);	
				
				}

			}

		}

	} else {

		$status = array('msg' => 'Error: Not a valid post id.', 'status' => 0 );
	}


	die(json_encode($status));
}


add_action('wp_ajax_tkugp_admin_addtag' , 'tkugp_admin_addtag');

function tkugp_admin_addtag(){

	$tagname = $_POST['tagname'];
	$post_id = $_POST['postid'];


	$status  = array('msg' =>'', 'status' =>'');

	if( $post_id && '' != $post_id ){

			$term = term_exists($tagname, TKUGP_POST . '_tag' );

		if ($term !== 0 && $term !== null) {
				
			$status = array('msg' => 'Error: Tag already exist.', 'status' => 2, 'tagid' => $term['term_id'] );

		} else {

			$terms = wp_insert_term($tagname, TKUGP_POST . '_tag');

			if ( is_wp_error( $terms ) ) {
				
				$status = array('msg' => 'Error: Adding new tag.', 'status' => 0 );	

			} else {


				if( !tkugp_set_termtag($post_id, $terms['term_id']) ){

					$status = array('msg' => 'Error: Could not assign tag to post.', 'status' => 0);	
				
				} else {

					$status = array('msg' => 'Success: New tag added and assigned to post.', 'status' => 1, 'tagid' => $terms['term_id']);	
				
				}

			}

		}

	} else {

		$status = array('msg' => 'Error: Not a valid post id.', 'status' => 0 );
	}


	die(json_encode($status));
}

function tkugp_set_termcat($post_id, $cat_id){

	// ID of category we want this post to have.
	$cat_id = $cat_id;

	$term_taxonomy_ids = wp_set_object_terms( $post_id, $cat_id, TKUGP_POST . '_cat' );

	if ( is_wp_error( $term_taxonomy_ids ) ) {
		return false;
	} else {

		return true;
	}

}

function tkugp_set_termtag($post_id, $tag_id){

	// ID of tag we want this post to have.
	$tag_id = $tag_id;

	$term_taxonomy_ids = wp_set_object_terms( $post_id, $tag_id, TKUGP_POST . '_tag' );

	if ( is_wp_error( $term_taxonomy_ids ) ) {
		return false;
	} else {

		return true;
	}

}


add_action('the_content', 'tkugp_the_content', 99, 1);
function tkugp_the_content($content){

	$post_id = get_the_ID();

	$html = '';

	$items = get_post_meta( $post_id, 'tkugp_list_item', true);

	
		
		$categories 	= tkugp_the_content_categories($items);
		$tags 		= tkugp_the_content_tags($items);
		$favrt 		= tkugp_the_content_favrt($items);
		$item 		= tkugp_the_content_item($items);

		$html .='<div class="tkugp-items-wrap">';
				$html .= $categories;
				$html .= $tags;
				$html .= $favrt;

				$html .='<div class="tkugp-items">';
					$html .= $item;
				$html .='</div>';

		$html .='</div>';

	return $content . $html;
	
}

function tkugp_the_content_categories($items){

	global $post;
	$post_settings = get_post_meta($post->ID, 'tkugp_post_settings', true);

	if( empty($post_settings['cat_title']) )
		$post_settings['cat_title'] = 'I want SEO tools that help with:';

	$content  = '';
	$content  .= '<p class="tkugp-category-heading">'.$post_settings['cat_title'].'</p>';
	$content  .='<hr class="tkugp-hr" />';
	$content  .= '<ol class="tkugp-category-list tkugp-ol">';

	$exists = array();

	foreach ($items as $key => $item) {

		$term 	  = get_term( $item['category'], TKUGP_POST . '_cat' );
        $catid 	  = $term->term_id;
        $catname  = $term->name;

        if( !in_array($catid, $exists) ){
        	$exists[] = $catid;
			$content .= '<li class="tkugp-category" data-tkugpcat="'.$catid.'">'.$catname.'</li>';
        }

	}

	$content .= '</ol>';

	return $content;
}

function tkugp_the_content_tags($items){

	global $post;
	$post_settings = get_post_meta($post->ID, 'tkugp_post_settings', true);

	if( empty($post_settings['tag_title']) )
		$post_settings['tag_title'] = 'I want tools that are:';

	$content  = '';
	$content  .= '<p class="tkugp-tag-heading">'.$post_settings['tag_title'].'</p>';
	$content .='<hr class="tkugp-hr" />';
	$content  .= '<ol class="tkugp-tag-list tkugp-ol">';

	$exists = array();

	foreach ($items as $key => $item) {

		foreach ($item['tags'] as $key => $tag) {
			
			$term 	 = get_term( $tag, TKUGP_POST . '_tag' );
        	$tagid 	 = $term->term_id;
        	$tagname = $term->name;

        	if( !in_array($tagid, $exists ) ){
        		$exists[] = $tagid;
				$content .= '<li class="tkugp-tag" data-tkugptag="'.$tagid.'">'.$tagname.'</li>';
        	}
		}	

	}

	$content .= '</ol>';

	return $content;
}

function tkugp_the_content_favrt($items){
	global $post;
	$post_settings = get_post_meta($post->ID, 'tkugp_post_settings', true);

	if( empty($post_settings['favrt_title']) )
		$post_settings['favrt_title'] = 'Show only [author] favorite tools:';

	$post_settings['favrt_title'] = str_replace('[author]', ucwords(get_the_author()."'s"), $post_settings['favrt_title']);

	$content  = '';
	$content  = '<p class="tkugp-favrt-heading">'.$post_settings['favrt_title'].'</p>';
	$content .='<hr class="tkugp-hr" />';
	$content .= '<ol class="tkugp-favrt-list tkugp-ol">';
	$content .= '<li class="tkugp-favrt" data-tkugpfavrt="1">Yes</li>';
	$content .= '<li class="tkugp-favrt" data-tkugpfavrt="2">No</li>';
	$content .= '</ol>';

	return $content;
}

function tkugp_the_content_item($items){

	global $post;
	$content = '';

	
	$categories = array();

	foreach ($items as $key => $item) {
		
		$categories[] = array('item'=>$key, 'cat'=>$item['category'] );	
	
	}
	$exists[] = array();
	foreach ($categories as $key => $category ) {
		
		
        $item 	 = $items[$category['item']];
        $term 	 = get_term( $item['category'], TKUGP_POST . '_cat' );
        $catid 	 = $term->term_id;
        $catname = $term->name;
        

        if( $item['favrt'] == 1)
        	$favrttext = ucwords(get_the_author()."'s").' Favorite';
        else 
        	$favrttext = '';


        $content .= '<div class="tkugp-listitem-single">';
         if( !in_array($catid, $exists) ){
         	$exists[] = $catid;
    		$content .= '<h2 class="tkugp-item-heading">'.$catname.'</h2>';
    	}	
    	$content .= '<h2 class="tkugp-item-title">'.$item['title'].'</h2>';
    	$content .='<div class="tkugp-item-terms">';
    		$content .= '<span class="tkugp-item-term tkugp-term-category" data-itemterm="'.$catid.'"><i class="fa fa-wrench"></i> '.$catname.'</span>';
    		foreach ($item['tags'] as $key => $tag) {
    			$term 	 = get_term( $tag, TKUGP_POST . '_tag' );
        		$tagid 	 = $term->term_id;
        		$tagname = $term->name;
    			$content .= '<span class="tkugp-item-term tkugp-term-tag" data-itemterm="'.$tagid.'"><i class="fa fa-tag"></i> '.$tagname.'</span>';
    		}
    		if( $item['favrt'] == 1) {
    			$content .= '<span class="tkugp-item-term tkugp-term-favrt" data-itemterm="'.$item['favrt'].'"><i class="fa fa-thumbs-up"></i> '.$favrttext.'</span>';
    		}


    	$content .='</div>';
    		
    	$content .='<div class="tkugp-item-inner">';
    		$content .='<p class="tkugp-item-content">'.$item['content'].'</p>';
    		$content .='<img class="tkugp-item-image" src="'.$item['image'].'" />';
    		$content .='<hr class="tkugp-hr" />';
    		$content .='<p class="tkugp-item-link">';
    			$content .='<span class="tkugp-item-link-label">Official Website:</span>';
    			$content .='<br><a href="'.$item['link'].'">'.$item['link'].'</a></br>';
    		$content .='</p>';

    	$content .='</div>';
    	
    	$content .='</div><!-- tkugp-listitem-single  -->';



	}

	return $content;
}
