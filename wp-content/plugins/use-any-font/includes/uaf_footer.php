<?php 
if (isset($_POST['submit-uaf-settings'])){
    uaf_save_settings();
    $settings_message = 'Settings Saved';
}

$server_status 	= $GLOBALS['uaf_server_status'];
if (isset($_POST['test_server']) || empty($server_status)){
		if  (in_array  ('curl', get_loaded_extensions())) {
			$test_code	= date('ymdhis');
			$ch_test 	= curl_init();
			curl_setopt($ch_test, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch_test, CURLOPT_URL, uaf_get_server_url().'/uaf_convertor/php_server_check.php');
			curl_setopt($ch_test, CURLOPT_POST, true);
			$post = array(
				'test_code' => $test_code
			);
			curl_setopt($ch_test, CURLOPT_POSTFIELDS, $post);
			$response = curl_exec($ch_test);
			if(curl_errno($ch_test)) {
				$server_err_stat	= 'test_error';
				$server_err_msg 	=  '<strong>Error</strong>: ' . curl_error($ch_test);
			}
			else {
				$http_code = curl_getinfo($ch_test, CURLINFO_HTTP_CODE);
				if ($http_code == 200) {
					if ($test_code == $response){
						$server_err_stat	= 'test_successfull';
						$server_err_msg		= '';
					} else {
						$server_err_stat	= 'test_error';
						$server_err_msg 	= '<strong>Error</strong>: Sorry couldnot get response back from the server.';
					}
				} else {
					$server_err_stat	= 'test_error';
					$server_err_msg = '<strong>Error</strong>: ' .$response;
				}
			}
		} else {
			$server_err_stat	= 'test_error';
			$server_err_msg 	= '<strong>Error</strong>: Curl not enabled in your server.';
		}
		update_option('uaf_server_status', $server_err_stat);
		update_option('uaf_server_msg', $server_err_msg);
        $GLOBALS['uaf_server_status']               = $server_err_stat;
        $GLOBALS['uaf_server_msg']                  = $server_err_msg;
}
?>

<?php if (!empty($settings_message)):?>
	<div class="updated" id="message"><p><?php echo $settings_message ?></p></div>
<?php endif; ?>

        
        <br/>
        <table class="wp-list-table widefat fixed bookmarks uaf_form">
            	<thead>
                <tr>
                	<th><strong>Additional Settings (Usually not required)</strong></th>
                </tr>
                </thead>
                <tbody>
                <form method="post" action="">
                <tr>
                	<td>
                    	<input type="checkbox" name="uaf_use_alternative_server" value="1" <?php echo $GLOBALS['uaf_use_alternative_server'] == 1?'checked=checked':''; ?> /> Use alternative server. <strong><em>( When you are unable to upload the font using both Default Js and PHP Uploader or verify API key. )</em></strong>
                    </td>
                </tr>
                
                <tr>
                	<td>
                    	<input type="checkbox" name="uaf_use_curl_uploader" value="1" <?php echo $GLOBALS['uaf_use_curl_uploader'] == 1?'checked=checked':''; ?> /> Use PHP uploader. <em>Need PHP Curl.</em>
                    </td>
                </tr>
                
                <tr>
                	<td>
                    	<input type="checkbox" name="uaf_use_absolute_font_path" value="1" <?php echo $GLOBALS['uaf_use_absolute_font_path'] == 1?'checked=checked':''; ?> /> Use absolute path for font.
                    </td>
                </tr>
                
                <tr>
                	<td>
                    	<input type="checkbox" name="uaf_disbale_editor_font_list" value="1" <?php echo $GLOBALS['uaf_disbale_editor_font_list'] == 1?'checked=checked':''; ?> /> Disable Font list in wordpress editor. <strong><em>( When you have conflict with wordpress editor. )</em></strong>       
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="checkbox" name="uaf_enable_multi_lang_support" value="1" <?php echo $GLOBALS['uaf_enable_multi_lang_support'] == 1?'checked=checked':''; ?> />Enable Multi Language Font Support <strong><em>( When you are using multi language and need to set different font based on language. Currently Supported : WPML & Polylang )</em></strong>
                    </td>
                </tr>

                <tr>
                    
                    <td>    
                        <select name="uaf_font_display_property">
                            <option value="auto" <?php echo $GLOBALS['uaf_font_display_property'] == "auto"?'selected=selected':''; ?>>auto</option>
                            <option value="block" <?php echo $GLOBALS['uaf_font_display_property'] == "block"?'selected=selected':''; ?>>block</option>
                            <option value="swap" <?php echo $GLOBALS['uaf_font_display_property'] == "swap"?'selected=selected':''; ?>>swap</option>
                            <option value="fallback" <?php echo $GLOBALS['uaf_font_display_property'] == "fallback"?'selected=selected':''; ?>>fallback</option>
                            <option value="optional" <?php echo $GLOBALS['uaf_font_display_property'] == "optional"?'selected=selected':''; ?>>optional</option>
                        </select>
                        Font Display Property                        
                    </td>
                </tr>


                <tr>        
                	<td><input type="submit" name="submit-uaf-settings" class="button-primary" value="Save Settings" /></td>
            	</tr>
                </form>
                
                </tbody>
            </table>
        
        <br/>
        <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th><strong>Instructions</strong></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    	<ol>
                        	<li>Get the premium key from <a href="https://dineshkarki.com.np/use-any-font/api-key" target="_blank">here</a>. You can also generate Lite / Test API key from button above. <strong>Note : </strong> Lite / Test API only allow single font conversion.<br/>
                            <em><strong>Note:</strong> API key is needed to connect to our server for font conversion.</em> 
                            </li>
                            
                            <li>Upload your font in supported format from <strong>Upload Fonts</strong> section. The required font format will be converted automatically by the plugin and stores in your server.
                            <em><strong>Note:</strong> We don't store any font in our server. We delete the temporary files after conversion has been done.</em> 
                            </li>
                            
                            <li>Assign your font to you html elements from <strong>Assign Font</strong> section.</li>
                            
                            <li>You can also assign uploaded font directly from Post/Page Wordpress Editor.</li>
                            
                            <li>Have any issue related to our plugin ? Please visit <a href="http://dnesscarkey.com/virtual-support/use-any-font.php">Virtual Support</a>. Our virtual support covers around 80% of repeated issue and setup instructions.</li>
                            
                            <li>If you still have any problem visit our <a href="http://dineshkarki.com.np/forums/forum/use-any-fonts" target="_blank">support forum</a> or you can write to us directly using our contact form.</li>
                            
                        </ol>
                    </td>
                </tr>
                </tbody>
            </table>
        
        </td>
        <td width="15">&nbsp;</td>
        <td width="250" valign="top">
        	<?php if ($GLOBALS['uaf_use_curl_uploader'] == 1): ?>
            <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th>Server Connectivity Test</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    	<div id="server_status" class="<?php echo $GLOBALS['uaf_server_status']; ?>">
                        	<?php echo str_replace('_',' ',$GLOBALS['uaf_server_status']); ?>
                        </div>						
                        
                        <?php if ($GLOBALS['uaf_server_status'] == 'test_error'): ?>
						<div class="uaf_test_msg"><?php echo $GLOBALS['uaf_server_msg']; ?></div>
                        <?php endif; ?>
                        
                        
                        <form action="admin.php?page=uaf_settings_page" method="post">
                        	<p align="center">
                            <input type="submit" value="Test Again" class="button-primary" name="test_server" />
                            </p>
                        </form>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            <?php endif; ?>
            <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th>Have Problem ?</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    <ul class="uaf_list">
                    	<li><a href="http://goo.gl/NYtZsX" target="_blank">Setup Instructions</a></li>
                        <li><a href="http://goo.gl/FcC7EL" target="_blank">Quick Virtual Support</a></li>
                        <li><a href="http://goo.gl/XgEqzn" target="_blank">Support Forum</a></li>
                        <li><a href="http://goo.gl/MKg7VS" target="_blank">Rectify My Problem / Contact Us</a></li>
                        <li><a href="https://bit.ly/2wYjOyj" target="_blank">Download Free Fonts</a></li>
                    </ul>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th>Some Other Plugins</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td style="padding:4px;">
                    	<a href="http://goo.gl/3XDDzi" target="_blank"><img width="240" alt="Create Masonry Brick Shortcode" src="<?php echo plugins_url("use-any-font/images/wp_masonry_layout.gif"); ?>" class="aligncenter size-full wp-image-426"></a>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            
            <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th>Plugins You May Like</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td>
                    	<ul class="uaf_list">
                        	<li><a href="http://goo.gl/3XDDzi" target="_blank">WP Masonry Layout</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/any-mobile-theme-switcher/" target="_blank">Any Mobile Theme Switcher</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/jquery-validation-for-contact-form-7/" target="_blank">Jquery Validation For Contact Form 7</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/add-tags-and-category-to-page/" target="_blank">Add Tags And Category To Page</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/block-specific-plugin-updates/" target="_blank">Block Specific Plugin Updates</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/featured-image-in-rss-feed/" target="_blank">Featured Image In RSS Feed</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/remove-admin-bar-for-client/" target="_blank">Remove Admin Bar</a></li>
                            <li><a href="http://wordpress.org/extend/plugins/html-in-category-and-pages/" target="_blank">.html in category and page url</a></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            <table class="wp-list-table widefat fixed bookmarks">
            	<thead>
                <tr>
                	<th>Facebook</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                	<td><iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FDnessCarKey%2F77553779916&amp;width=185&amp;height=180&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color=%23f9f9f9&amp;header=false&amp;appId=215419415167468" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:240px; height:180px;" allowTransparency="true"></iframe>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
            
        </td>
    </tr>
</table>
</div>