<?php 
function wpFontPairingSettings()
{
	$errors = '';
	$ff_heading = '';
	$ff_body = '';
	$ff1_size = '';
	$ff2_size = '';
	$ff1_height = '';
	$ff2_height = '';
	global $wpdb;
	if (isset($_POST['submit_preview']))
	{
		if (!empty($_POST['fpp-font-1'])) {
			$ff_heading = $wpdb->escape($_POST['fpp-font-1']);
		} else {
			$errors .= 'Please enter a font family for the heading text.<br/>';
		}
		
		if (!empty($_POST['fpp-font-2'])) {
			$ff_body = $wpdb->escape($_POST['fpp-font-2']);
		} else {
			$errors .= 'Please enter a font family for the body text.<br/>';
		}

		if (!empty($_POST['fpp-font1-size'])) {
			if (is_numeric($_POST['fpp-font1-size']) && ($_POST['fpp-font1-size'] > 0)){
				$ff1_size = $wpdb->escape($_POST['fpp-font1-size']);
			} else {
				$errors .= 'Please enter either an integer or decimal number greater than zero for the heading font size.<br/>';
			}
		}
		
		if (!empty($_POST['fpp-font2-size'])) {
			if (is_numeric($_POST['fpp-font2-size']) && ($_POST['fpp-font2-size'] > 0)){
				$ff2_size = $wpdb->escape($_POST['fpp-font2-size']);
			} else {
				$errors .= 'Please enter either an integer or decimal number greater than zero for the body font size.<br/>';
			}
		}
		
		if (!empty($_POST['fpp-font1-height'])) {
			if (is_numeric($_POST['fpp-font1-height']) && ($_POST['fpp-font1-height'] > 0)){
				$ff1_height = $wpdb->escape($_POST['fpp-font1-height']);
			} else {
				$errors .= 'Please enter either an integer or decimal number greater than zero for the heading line height.<br/>';
			}
		}
		
		if (!empty($_POST['fpp-font2-height'])) {
			if (is_numeric($_POST['fpp-font2-height']) && ($_POST['fpp-font2-height'] > 0)){
				$ff2_height = $wpdb->escape($_POST['fpp-font2-height']);
			} else {
				$errors .= 'Please enter either an integer or decimal number greater than zero for the body line height.<br/>';
			}
		}
		
		if (strlen($errors)> 0){
			echo '<div id="message" class="error"><p>' . $errors . '</p></div>';
		}
		else{
			$options = array(
				'fpp_heading_font' => $ff_heading,
				'fpp_body_font' => $ff_body,
				'fpp_heading_size' => $ff1_size,
				'fpp_heading_height' => $ff1_height,
				'fpp_body_size' => $ff2_size,
				'fpp_body_height' => $ff2_height
			);
			update_option('wp_fpp_settings', $options); //store the results in WP options table
		}
	}

	$wp_fpp_options = get_option('wp_fpp_settings');
	
	if ($wp_fpp_options)
	{
		$ff_heading = $wp_fpp_options['fpp_heading_font'];
		$ff_body = $wp_fpp_options['fpp_body_font'];
		$ff1_size = $wp_fpp_options['fpp_heading_size'];
		$ff1_height = $wp_fpp_options['fpp_heading_height'];
		$ff2_size = $wp_fpp_options['fpp_body_size'];
		$ff2_height = $wp_fpp_options['fpp_body_height'];
	}
?>
<div class="wrap"><?php screen_icon(); ?>
<h2>Font Pairing Preview</h2>
<div id="poststuff"><div id="post-body">
<p>Enter a pair of font family names and click the submit button to see a preview.</p>
<br />
<div class="postbox">
<h3><label for="title">Enter Font Families</label></h3>
<div class="inside">
<form action="" method="POST">
	<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="FontFamily1"> Font Family For Heading Text</label>
		</th>
		<td><input size="30" name="fpp-font-1" id="fpp_font_1" value="<?php echo $ff_heading; ?>" /></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="FontFamily1Size"> Enter Font Size For Heading Text</label>
		<p class="description">(Defaults to 70px if left blank)</p>
		</th>
		<td><input size="10" name="fpp-font1-size" value="<?php echo $ff1_size; ?>" /> (px)</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="FontFamily1LH"> Enter Line Height For Heading Text</label>
		<p class="description">(Defaults to 90px if left blank)</p>
		</th>
		<td><input size="10" name="fpp-font1-height" value="<?php echo $ff1_height; ?>" /> (px)</td>
	</tr>
	<tr valign="top">
			<th scope="row"><label for="FontFamily2"> Font Family For Body Text</label>
			</th>
			<td><input size="30" name="fpp-font-2" id="fpp_font_2" value="<?php echo $ff_body; ?>" /></td>
		</tr>
	<tr valign="top">
		<th scope="row"><label for="FontFamily2Size"> Enter Font Size For Body Text</label>
		<p class="description">(Defaults to 15px if left blank)</p>
		</th>
		<td><input size="10" name="fpp-font2-size" value="<?php echo $ff2_size; ?>" /> (px)</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="FontFamily2LH"> Enter Line Height For Body Text</label>
		<p class="description">(Defaults to 25px if left blank)</p>
		</th>
		<td><input size="10" name="fpp-font2-height" value="<?php echo $ff2_height; ?>" /> (px)</td>
	</tr>
</table>
<div style="border-bottom: 1px solid #dedede; height: 10px"></div>
<br />
<input type="submit" name="submit_preview" value="Submit" class="button-primary" />
</form>

</div></div>
<div class="postbox" style="width: 730px;">
<h3><label for="title">Font Pairing Preview Window</label></h3>
<div class="inside" style="background-color:#FFFFFF !important;">
<?php 
$json_stuff = file_get_contents(WP_FPP_PATH."/google_webfonts.json");
$font_data=json_decode($json_stuff,true);
wp_fpp_render_html();
?>
</div></div>
</div></div>
<div class="custom_yellow_box">
	<p>Want to learn how to make great landing pages? This eBook will <a href="http://www.tipsandtricks-hq.com/learn-to-create-awesome-landing-pages-that-convert" target="_blank">teach you how to create landing pages which convert well</a>.</p>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var fpparrayFromPHP = [<?php 
		$font_families = array();
		foreach ($font_data['items'] as $font_type) {
			$fontname = $font_type['family'];
			$font_families[] = '"'.$fontname.'"';
		}
		echo join(',',$font_families);
		
		?>];
		//the following will use autocomplete and return matched results which "start-with" x
		$( "#fpp_font_1" ).autocomplete({
			  source: function( request, response ) {
			    var matches = $.map( fpparrayFromPHP, function(fname) {
			      if ( fname.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
			        return fname;
			      }
			    });
			    response(matches);
			  }
			});	
		$( "#fpp_font_2" ).autocomplete({
			  source: function( request, response ) {
			    var matches = $.map( fpparrayFromPHP, function(fname) {
			      if ( fname.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
			        return fname;
			      }
			    });
			    response(matches);
			  }
			});	
	});		
</script>

<?php 
}
function wp_fpp_render_html()
{
	$ff_heading = '';
	$ff_body = '';
	$ff1_size = '';
	$ff2_size = '';
	$ff1_height = '';
	$ff2_height = '';
	$wp_fpp_options = get_option('wp_fpp_settings');
	
	if ($wp_fpp_options)
	{
		$ff_heading = $wp_fpp_options['fpp_heading_font'];
		$ff_body = $wp_fpp_options['fpp_body_font'];
		$ff1_size = $wp_fpp_options['fpp_heading_size'];
		$ff2_size = $wp_fpp_options['fpp_body_size'];
		$ff1_height = $wp_fpp_options['fpp_heading_height'];
		$ff2_height = $wp_fpp_options['fpp_body_height'];
	}
	//set defaults if variables left blank
	if ($ff1_size == '') {
		$ff1_size = '70';
	}

	if ($ff2_size == '') {
		$ff2_size = '15';
	}
	
	if ($ff1_height == '') {
		$ff1_height = '90';
	}
	
	if ($ff2_height == '') {
		$ff2_height = '25';
	}
	
	$preview_hmtl_code = '
							<link href="http://fonts.googleapis.com/css?family='.$ff_heading.'" rel="stylesheet" type="text/css">
							<link href="http://fonts.googleapis.com/css?family='.$ff_body.'" rel="stylesheet" type="text/css">
							<style type="text/css">
							.fpp_pane {
								width: 630px;
							}
							.fpp_pane h1 {
									font-family: "'.$ff_heading.'", Georgia, Times, serif;
									font-size: '.$ff1_size.'px;
									line-height: '.$ff1_height.'px;
								}
 
							.fpp_pane p {
								font-family: "'.$ff_body.'", Helvetica, Arial, sans-serif;
								font-size: '.$ff2_size.'px;
								line-height: '.$ff2_height.'px;
								text-align: left;
							}
							</style>
							<div class="fpp_pane">
							<h1>'.$ff_heading.' and '.$ff_body.'</h1>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ipsum risus, semper non accumsan eleifend, vehicula ac erat. Integer pretium diam et lorem volutpat venenatis. Nunc tristique libero eu nisl dapibus auctor. Cras ante tortor, blandit sit amet facilisis at, pharetra a felis. Quisque suscipit nisi a enim lacinia at elementum tortor volutpat. Nulla eu nisl eu urna facilisis dapibus. Phasellus tempor auctor justo ac bibendum. Integer adipiscing placerat lectus, at egestas urna auctor sit amet. Mauris congue adipiscing consequat. Pellentesque quis mauris metus. Nam ultrices, sem in rutrum rhoncus, lectus urna vestibulum dui, eu lobortis enim elit vel nisi. Fusce porta tincidunt ante quis tristique. Sed in lorem ut nunc sagittis viverra. Etiam eu convallis metus. Proin pulvinar luctus justo, ut aliquam augue elementum ac. Vivamus sem lorem, accumsan semper dictum fermentum, blandit nec nulla.</p>
							</div>';
	echo $preview_hmtl_code;
	//==========================
//	include_once('wp-fpp-read-font-families.php');
//	wp_fpp_parse_font_json();
	//==========================
}
?>