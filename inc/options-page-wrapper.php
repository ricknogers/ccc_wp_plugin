<?php  ?>

<div class="wrap">
	
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php echo self::name; ?></h2>
	
	<div id="poststuff">
	
		<div id="post-body" class="metabox-holder">
		
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">
					
						<h3><span>YMCA's <?php echo self::name; ?> Information</span></h3>
						<div class="inside">
							
							<form name="<?php echo self::slug ;;?>_form" method="post" action="">							
	
								
								<div id="tabs">
									  <ul>
									    <li><a href="#info">CCC API Info</a></li>
									    <li><a href="#branches">Branches</a></li>
									  </ul>
								
									  <div id="info">
									  	<table class="form-table">
											<tr>
												<td>
													<label for="<?php echo self::slug ;?>_access_token"><?php echo self::name; ?> Access Token</label>
												</td>
												<td>
													<input name="<?php echo self::slug ;?>_access_token" id="<?php echo self::slug ;?>_access_token" type="text" value="<?php echo $this->options['access_token']; ?>" class="regular-text" />
												</td>
											</tr>
										</table>
									  </div>
									  <div id="branches">
											<?php if( empty($this->options['branches']) ): ?>
                                                There are currently no branches saved please input your CCC API token and then hit "Save Settings".

											<?php else: ?>
												<?php 
													$count = ceil(count($this->options['branches'])/3);
													$branches = array_chunk($this->options['branches'], $count , true); 
													
												?>
												<input type="hidden" name="<?php echo self::slug ;?>_no_branches" value="N">
												<table class="form-table">
													<tr>
												
													</tr>
												</table>
											<?php endif; ?>
									  
									  </div>
								</div>
	
								<p id="<?php echo self::slug ;?>-submit-wrapper">
									<button class="button-primary" type="submit" id="<?php echo self::slug ;?>-form-save" name="<?php echo self::slug ;?>_form_save"> Save Settings</button>
									<button class="button-primary" type="submit" id="<?php echo self::slug ;?>-form-update" name="<?php echo self::slug ;?>_form_update"> Import Programs</button>
									<button class="button-primary" type="submit" id="<?php echo self::slug ;?>-form-update" name="<?php echo self::slug ;?>_form_delete">Clean Database</button>

								</p>

							</form>

						</div> <!-- .inside -->
					
					</div> <!-- .postbox -->
				</div> <!-- .meta-box-sortables .ui-sortable -->
				
			</div> <!-- post-body-content -->
			
		</div> <!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
	</div> <!-- #poststuff -->
	  <style>
			#tabs:before,
			#tabs:after {
			    content: " "; /* 1 */
			    display: table; /* 2 */
			}
			
			#tabs:after {
			    clear: both;
			}
			
			/**
			 * For IE 6/7 only
			 * Include this rule to trigger hasLayout and contain floats.
			 */
			#tabs {
			    *zoom: 1;
			}
		  .ui-tabs-vertical .ui-tabs-nav {
				float: left;
				width: 20%;
		  }
		  .ui-tabs-vertical .ui-tabs-nav li {
			  	clear: left;
				width: 100%;
				background-color: #222;
				border: 1px solid #000;
				margin: 5px 0;
				border-radius: 3px;
			  
		  }
		  .ui-tabs-vertical .ui-tabs-nav li a {
				display: block;
				color: #fff;
				text-decoration: none;
				padding: 8px 10px;
				font-size: 16px;
		  }
		  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { 
			  	background-color: #ed1c24;
		  		border-color: #a92b31; 
		  		box-shadow: 0 1px 0 #a92b31;
		  		text-shadow: 0 -1px 1px #a92b31, 0 1px #a92b31, 1px 1px #a92b31,-1px 0 1px #a92b31;	
			  }
		  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active:hover, .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active:focus, .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active:visited {
			  	background-color: #a92b31;
		  		border-color: #a92b31; 
		  		box-shadow: 0 1px 0 #a92b31;
		  		text-shadow: 0 -1px 1px #a92b31, 0 1px #a92b31, 1px 1px #a92b31,-1px 0 1px #a92b31;	
			   
			}
		  .ui-tabs-vertical .ui-tabs-panel {
				float: left;
				width: 75%;
				margin-left: 5%;
		  }
		  #ccc_api-submit-wrapper{
			  text-align: right;
			  margin-right: 35px;
		  }
		  .wp-core-ui .button-primary {
			  border-color: #a92b31;
			  background-color: #ed1c24;
			  text-shadow: 0 -1px 1px #a92b31, 0 1px #a92b31, 1px 1px #a92b31,-1px 0 1px #a92b31;	 
			  box-shadow: 0 1px 0 #a92b31;
		  }
		  .wp-core-ui .button-primary:hover, .wp-core-ui .button-promary:focus, .wp-core-ui .button-promary:visited {
			  border-color: #a92b31;
			  background-color: #a92b31;
			  text-shadow: 0 -1px 1px #a92b31, 0 1px #a92b31, 1px 1px #a92b31,-1px 0 1px #a92b31;	 
			  box-shadow: 0 1px 0 #a92b31;
		  }
	  </style>
	
</div> <!-- .wrap -->