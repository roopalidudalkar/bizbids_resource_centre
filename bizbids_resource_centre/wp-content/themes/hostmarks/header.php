<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">  

<head>
	<?php if (have_posts()):while(have_posts()):the_post(); endwhile; endif;?> 
	<?php if (is_category()) { ?>  
<meta http-equiv="content-type" content="<?php bloginfo('html_type');?>character=<?php bloginfo('charset');?>">
<meta name="Description" content="<?php the_permalink() ?>"/>
<meta name="Keywords" content="<?php single_post_title(''); ?>"/>
<meta name="robots" content="<?php category_description(); ?>" />
<!-- if page is others -->  
<?php } else { ?>  
<meta property="og:site_name" content="<?php bloginfo('name'); ?>" />  
<meta property="og:description" content="<?php bloginfo('description'); ?>" />  
<meta property="og:type" content="website" />  
<meta property="og:image" content="logo.jpg" /> <?php } ?>  



<title><?php wp_title('|', true, 'left'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link type="text/css" rel="stylesheet" href="wp-content/themes/hostmarks/css/bootstrap.css">
<link type="text/css" rel="stylesheet" href="wp-content/themes/hostmarks/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="wp-content/themes/hostmarks/css/style.css">
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:600,400,700">

<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>

<script type="text/javascript">stLight.options({publisher: "916c9cfb-edd5-46f1-b024-c9d477cef57a", doNotHash: false, doNotCopy: false, hashAddressBar: false});

</script>
<script type='text/javascript' >

	function jsfunction(){
		
			
			
				var xmlhttp;
				if (window.XMLHttpRequest)
				  {// code for IE7+, Firefox, Chrome, Opera, Safari
				  xmlhttp=new XMLHttpRequest();
				  }
				else
				  {// code for IE6, IE5
				  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				  }
				xmlhttp.onreadystatechange=function()
				  {
				  if (xmlhttp.readyState==4 && xmlhttp.status==200)
					{
							//alert(xmlhttp.responseText);
						document.getElementById("searchval").innerHTML=xmlhttp.responseText;
					}
				  }
				xmlhttp.open("GET","http://192.168.1.10/~anup/bizbids/ajax-info.php",true);
				xmlhttp.send();

				
			
		}
</script>



<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<div class="header container">
    	<div class="row">
			<div class="col-md-4 left_nav">
            	<nav class="top_menu">
                	<ul class="nav navbar-nav">
                    	<li>
							<?php if(!is_category())
							{
								echo do_shortcode('[do_widget id=dc_jqmegamenu_widget-3]');
							}
							else
							{
								if(!getMainMenu('primary')){
								  $backup = $wp_query;
								  $wp_query = NULL;
								  $wp_query = new WP_Query(array('post_type' => 'post'));
								  getMainMenu('primary');
								  $wp_query = $backup;
								}
							}?>
						</li>        
                    </ul>
                </nav>
            </div>
            <div class="col-md-3 logo"><img src="wp-content/themes/hostmarks/images/logo.jpg"></div>
            <div class="col-md-4 right_nav">
            	<nav class="top_menu">
                	<ul class="nav navbar-nav">
                    	<li><a href="#">How it Works?</a></li>
                       
                        <li><a href="/~anup/bizbids/web/app_dev.php/login">Login</a></li>  
                        <li class="fb">
						<a href="#">
						<img src="/~anup/bizbids/web/img/fb.png">
						</a>
						</li> 
						
                        
                         
                  </ul>
                </nav>
            </div>
        </div>
    </div>
    <div class="search_block">
	    	<div class="container">
        	<div class="row">
				<form name="search" method="request" action="/~anup/bizbids/web/app_dev.php/search">
            	 <div class="col-md-7"><input class="form-control" type="text" list="browsers" placeholder="Category" id="category" name="category"><datalist id="searchval"><datalist id="browsers"></datalist></datalist></div>
                <!-- <div class="col-md-4"><input class="form-control" type="text" placeholder="City" id='city' name='city'></div>-->
                 <div class="col-md-2 form-btn"><input type="submit" class="btn btn-success btn-block" value="SEARCH"></div>
                 <div class="col-md-3"><button class="btn btn-success btn-block" type="button">SEARCH  BY CATEGORY</button></div>
                 </form>
            </div>
	    </div>
	    	    
    </div>

    <div class="head-band"></div>


<script type="text/javascript">
window.onload = jsfunction();

</script>
