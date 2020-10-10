<?php
if(!isset($_SESSION)){
	session_start();
}
	include __DIR__ .'/../admin/includes/posts_functions.php';
	include __DIR__ .'/../admin/includes/admin_functions.php';
	if(isset($_GET['id'])){
		$posts = getPostById($_GET['id']);
	}
	/* Get page id for this post */ 
	$page_id = $posts['post_id'];
	/* SESSION variables for page reference */ 
	$post_slug = $posts['post_slug'];
	$_SESSION['page_id'] = $page_id;
	$_SESSION['post_slug'] = $post_slug;
	$published_post_ids = getAllPublishedPostIds();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- head section -->
<title><?php echo htmlspecialchars_decode($posts['post_title']) ;?> | DevelopersPot</title>
	<meta name="description" content="<?php echo (isset($posts['meta_description'])? htmlspecialchars_decode($posts['meta_description']):''); ?>" />
	<?php include_once __DIR__ .'/head.html.php';?>
<style>
html,body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
margin: 0;
padding: 0;
border: 0;
font-size: 100%;
font: inherit;
vertical-align: baseline;
}
article, aside, details, figcaption, figure,
footer, header, hgroup, menu, nav, section {
  display: block;
}
body {
	background:#fff;
	line-height: 1.3;
    font-family:'Calibri Light', Calibri, sans-serif;
}
.banner-bar{font-family: Aladin;}
h1,h2,h3,h4{
    font-family:sans-serif,arial;
	font-weight:bolder;
	text-align:left;
	padding-top:1em;
    line-height:.9;
}
code{
	font-family:'Courier New',Courier;
	font-size:1em;
	color:#000;
}
.special-p{
	font-family: calibri;
}
.published-topics p,.recent-posts p{
    font-family:calibri,Arial;
}
a{text-decoration:none;}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
figcaption{text-align:left;}
*,*::before,*::after {
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
}
.group:before,.group:after{
	content:"";
	display: table;
}
.group:after{clear:both;} 
.group{
	clear:both;
	*zoom:1;
} 
.nav, .copyright,.policies{
	display:block;
	text-align:center;
}
header, footer{
	width:100%;
	padding:0;
}
header{background:#293f50;}
footer{
	background:rgb(11, 10, 10);
	background:rgba(11, 10, 10, 0.82);;
}
footer ul span{color:silver;}
footer a{
	font-variant:small-caps;
	text-decoration:none;
	color:rgb(200,200,200);
}
footer li{display:inline-table;}
.copyright{color:rgb(150,150,150);}
footer a{font-size:.8em;}
.copyright{color:rgb(150,150,150);}
.banner-bar a{color:rgb(255, 255,255);}
.login-signup a{color:rgb( 200, 200, 233);}
main{margin:0 auto;}

main p{
	line-height:1.5em;
	text-align:justify;
	padding:10px 0;
}
pre, pre code, samp{
	display:block;
	margin:0;
}
pre{
	font-size:1.1em;
	tab-size:1;
	overflow-x:auto;
	padding:10px 0;
	margin: 0;
}
code{
	padding:0 2px;
}
p code{
	background:rgb(230,230,230);
}
li code{
    background:rgb(230,230,230);
}
.special-p{
    padding:10px;
    background:rgb(100,200,250);
	background:rgba(100,200,255,.4);
	border-left: 5px double red;
	border-right: 5px double red;
}
.special-p code{
	background:inherit;
}
.published-topics p,.recent-posts p{
	padding:0;
	text-align:left;
}
table, tr{
	width:100%;
	text-align:left;
}
th, td{
	padding:5px 10px;
	border:thin solid rgb(200,200,200);
}
section{
	padding:10px;
	text-align:justify;
}
aside{
	padding:10px;
	text-align:left;
}
.contact-me{
    margin:3em auto;
    padding:20px;
    background:#E5E4E2;
}
.contact-me img{
    float:right;
    margin:10px;
    border-radius:50%;
}
.contact-me p{
    font-family:arial;
    font-size:1.2em;
}
.contact-me button{
    cursor:pointer;
}
hr{border:thin solid rgb(240,240,240);}

.login-signup{
	display:inline-block;
	margin:0;
	width:100%;
}
.tooltip{
	position:relative;
	display:inline-block;
	top:10px;
}
h1{
	font-size:1.3em;
	color:#071418;
}
h2{
	font-size:1.1em;
	color:#071418;
}
h3{
	font-size:1.1em;
	color:rgb(5,10,50);
}
h4{
	font-size:1.2em;
}
h5{
	padding:10px;
	line-height:1.3;
	text-align:left;
}
.post-acreditation{
	padding:10px 0;
}
.post-main-image{
	width:80%;
	margin:1.25em auto;
}
.article-post-image{
	width:100%;
}
.published-topics ul{
	list-style:none;
	text-align:left;
}
#menu-checkbox-control, .dropdown-button{
	display:none;
}
em, i{font-style:italic;}
.main-article ul, .main-article ol{
  padding: .5em 2em;
}
.main-article ul li, .main-article ol li{
	text-indent:.0;
	padding:.3em .5em;
}
.published-topics ul li{
	font-size:.9em;
	color:rgb(5,10,50);
}
.published-topics ul ul li,.recent-posts p{
	font-size:.9em;
}
.recent-posts a,.published-topics a{
	color:#616D7E;
}
.post-acreditation{
	color:gray;
	font-size:0.725em;
}
#dropdown-menu-btn,.closebtn{
	display:none;
}
@media only screen and (max-width: 600px){
	.hide-in-mobile{
		display:none;
	}
    h1,h2,h3,h4{padding-left:10px}
    .published-topics ul,.recent-posts p,.post-acreditation{padding-left:10px}
	#dropdown-menu-btn{
		display:block;
		position:absolute;
		top:0;
		width:50px;
		text-align:right;
		padding: 10px 15px;
		color:white;
		cursor:pointer;
		border: none;
	}
	#dropdown-menu-btn:hover{
		background-color: rgb( 35, 35, 60);
	}
	.dropdown-content{
		display:none;
		position: absolute;
		top:3.75em;;
		left:0;
		display: none;
		height:100%;
		width:100%;
		background: rgb( 35, 35, 60);
		box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
		z-index:2;	
	}
	.closebtn{
		position: absolute;
		top: 0;
		right: 10px;
		color:white;
	}	
	header{
		position:sticky;
		top:0;
		width:100%;
		height:3.75em;
	}
	.banner-bar, .log-account-section{
	display:block;
	height:30px;
	padding:0;
	}
	.banner-bar{
		width:100%;
		margin:0;
		text-align:left;
		padding-top:0.5em;
		padding-left:30%;
	}
	.log-account-section{
		width:100%;
		text-align:right;
		padding-right:15%;
	}
	.account-photo-box{
		width:25%;
		height:1.875em;
		position:absolute;
		top:0;
		right:1.875em;
		text-align:right;
		padding:5px 5px;
	}
	.login-signup{
		right:1.875em;
	}
[class*="col-"]{
	width:100%
	}
section, aside{
    width:100%;
}
section, aside{
	padding:5px;
}
aside{
	text-align:left;
}
aside ul, aside ol{
	text-indent: 0;
	padding: 0;
}
.contact-me{margin:1.5em auto;}
main p{
	text-align:left;
	padding:10px;
}
.post-main-image{
	width:60%;
	margin:10px auto;
}
.article-index-image{
	height:9.375em;
}
footer{
	text-align:center;
}
footer span{
	float:none;
}
.banner-bar{
	font-size:1.4em;
}
.login-signup{
	font-size:.9em;
}
main p{
	font-size:1.1em;
}
}
@media only screen and (min-width:601px) and (max-width:768px) {
	header{
		height:4.375em;
	}
	.banner-bar,.nav-bar,.log-account-section{
		display:block;
		margin:0;
		padding:0;
	}
	.banner-bar{
		float:left;
		width:23%;
		padding-top:.6em; 
		padding-left:1em;
	}
	.nav-bar{
		float:left;
		width:59%;
		padding-top:1.25em;
	}
	.log-account-section{
		float:right;
		width:18%;
		text-align:right;
		padding-top:.5em;
	}
	[class*="col-"]{
		width:100%
	}
	main{
		width:90%
	}
	.hide-in-mobile{
		display:none;
	}
	.post-main-image{
		width:60%;
	}
	.article-index-image{
		height:12.5em;
	}
	.login-signup{
		position:absolute;
		right:1.5625em;
		z-index:1;
		padding:10px 5px;
	}
	.account-photo-box{
			float:right;
	}
	.account-photo-box{
		width:30%;
		height:2.1875em;
		position:absolute;
		top:5px;
		right:1.5625em;
		z-index:0;
	}
	.account-photo-box{
		display:inline-block;
		margin-right:0;
		padding:5px;
		text-align:right;
	}
	nav{
		text-align:center;
		margin: 0;
		padding: 5px 0;
	}
	nav ul{
		text-align:center;
	}
	nav li{
		display:inline-block;
		padding:0;
	}
	nav ul li a{
		padding:8px 2px;
		font-size:70%;
	}
	aside{
		text-align:left;
		padding-left:10px;
	}
	aside ul, aside ol{
		text-indent: 0;
		padding: 0;
	}
    .contact-me{
    margin:1.5em auto;
    }
	main p, li{
		font-size:1.1em;
	}
	.login-signup{
		font-size:.9em;
	}	
}
@media only screen and (min-width:769px) and (max-width:992px){
	.col-5-10{
		display: inline-block;
		vertical-align: top;
		float:left;
	}
    .col-2-10,.col-3-10{
        float:right;
        display:block;
    }
	.col-2-10{width:35%;}
	.col-3-10{width:35%;}
	.col-5-10{width:65%;}
	header{
		height:4.375em;
		margin:0;
	}
	.banner-bar, .nav-bar, .log-account-section{
		display:block;
		margin:0;
		padding:0;
	}
	.banner-bar{
		float:left;
		width:25%;
		padding-top:.2em; 
		padding-left:1em;
	}
	.nav-bar{
		float:left;
		width:55%;
		padding-top:1.65em;
	}
	.log-account-section{
		float:right;
		width:20%;
		text-align:right;
		padding-top:.4em;
	}
	main{
		width:100%;
	}
	section,aside{
		display:inline-block;
	}
	.hide-in-bigger-screens{
		display:none;
	}
	.article-index-image{
		height:12.5em;
	}
	footer{
		padding:5px;
	}
	.nav, .copyright, .policies{
		margin:0;
		padding:0;
	}
	.nav{
		width:35%;
		float:right;
	}
	.copyright{
		width:25%;
		float:left;
	}
	.policies{
		float:right;
		text-align:center;
		width:40%;
	}
	.login-signup{
		position:absolute;
		right:1.875em;
		z-index:1;
		padding:10px 5px;
	}
	.login-signup{
		padding-top:10px;
	}
	.account-photo-box{
		width:25%;
		height:2.1875em;
		position:absolute;
		top:5px;
		right:1.875em;
		z-index:0;
	}
	nav{
		margin:0 ;
		text-align:left;
		padding-top:0;
		padding-bottom:5px;
	}
	nav ul{
		text-align:center;
	}
	nav li{
		display:inline-block;
		padding:0;
	}
	nav ul li a{
		padding:8px 2px;
	}
	section{
		padding:0 3%;
	}
	aside{
		padding-left:1.25em;
		text-align:left;
	}
	aside ul, aside ol{
		text-indent: 0;
		padding:0;
	}
	nav{
		font-size:1.3em;
	}
	nav ul li a{
		font-size:80%;
	}
	.login-signup{
		font-size:1.1em;
	}
	main p, li{
		font-size:1em;
	}
}
@media only screen and (min-width:993px) and (max-width:1200px){
	.col-2-10,.col-3-10,.col-5-10{
	display: inline-block;
	vertical-align: top;
	float:left;
	}
	.col-2-10{width:20%;}
	.col-3-10{width:30%;}
	.col-5-10{width:50%;}
	.hide-in-bigger-screens{
		display:none;
	}
	main{
		width:95%;
		padding:5px;
		margin: 0 auto;
	}
	header{
		height:6.25em;
		margin:0;
	}
	.banner-bar, .nav-bar, .log-account-section{
		display:block;
		margin:0;
		padding:0;
	}
	.banner-bar{
		float:left;
		width:20%;
		padding-top:.2em; 
		padding-left:1em;
	}
	.nav-bar{
		float:left;
		width:50%;
		padding-top:2em;
	}
	.log-account-section{
		float:right;
		width:30%;
		text-align:right;
		padding-top:.4em;
	}
	section,aside{
		display:inline-block;
	}
	section{
		padding:0 10px;
	}
	aside{
		padding-left:10px;
		text-align:left;
	}
	aside ul, aside ol{
		text-indent: 0;
		padding: 0;
	}
	.article-index-image{
		height:12.5em;
	}
	.nav, .copyright, .policies{
		margin:0;
		padding:10px 0;
	}
	.nav{
		width:35%;
		float:right;
	}
	.copyright{
		width:25%;
		float:left;
	}
	.policies{
		float:right;
		text-align:center;
		width:40%;
	}
	.login-signup{
		position:absolute;
		right:2.1875em;
		z-index:1;
		padding:10px 5px;
	}
	.login-signup{
		padding-top:10px;
	}
	.account-photo-box{
		width:20%;
		height:2.1875em;
		position:absolute;
		top:5px;
		right:2.1875em;
		z-index:0;
	}
	.account-photo-box{
		display:inline-block;
		float:right;
		margin-right:0;
		padding:5px;
		text-align:right;
	}
	nav{
		margin:0 ;
		text-align:left;
		padding-top:10px;
		padding-bottom:5px;
		font-size:90%;
	}
	nav ul{
		text-align:center;
	}
	nav li{
		display:inline-block;
	}
	nav ul li a{
		padding:10px 2px;
	}
	.login-signup{
		font-size:1.2em;
	}
	main p, li{
		font-size:1.2em;
	}
}
@media only screen and (min-width:1201px){
	.col-2-10,.col-3-10,.col-5-10{
	display: inline-block;
	vertical-align: top;
	float:left;
}
.col-2-10{width:20%;}
.col-3-10{width:30%;}
.col-5-10{width:50%;}
.hide-in-bigger-screens{
	display:none;
}
header{
	height:7.5em;
	margin:0;
}
.banner-bar, .nav-bar, .log-account-section{
	display:block;
	margin:0;
	padding:0;
}
.banner-bar{
	float:left;
	width:25%;
	padding-top:.2em; 
	padding-left:1.5em;
}
.nav-bar{
	float:left;
	width:55%;
	padding-top:2.5em;
}
.log-account-section{
	float:right;
	width:20%;
	text-align:right;
	padding-top:.5em;
}
main{
	width:90%;
	margin: 0 auto;
}
section{
	padding:0 20px;
}
aside{
	padding-left:0;
	text-align:left;
}
.article-index-image{
	height:18.75em;
}
.nav, .copyright, .policies{
	display:block;
	margin:0;
	padding-top:10px;
}
.nav{
	width:35%;
	float:right;
}
.copyright{
	width:25%;
	float:left;
}
.policies{
	float:right;
	text-align:center;
	width:40%;
}
.login-signup{
	position:absolute;
	right:2.5em;
	z-index:1;
	padding:10px 5px;
}
.login-signup{
	padding-top:10px;
}
.account-photo-box{
	width:18%;
	height:2.1875em;
	position:absolute;
	top:5px;
	right:2.5em;
	z-index:0;
}
.account-photo-box{
	display:inline-block;
	float:right;
	margin-right:0;
	padding:5px;
	text-align:right;
}
nav{
	margin:0 auto;
	text-align:left;
	padding-top:10px;
	padding-bottom:10px;
}
nav ul{
	text-align:center;
}
nav li{
	display:inline-block;
}
.login-signup{
	font-size:1.2em;
}
main p, main li{
	font-size:1.3em;
}
}
</style>
    <?php include_once __DIR__ .'/head-resources.html.php'; ?>
	<!-- Links for google code prettify .js at bottom of page files -->
	<link rel="stylesheet" href="<?php echo BASE_URL ?>resources/css/google-code-prettify/prettify.css" media="print" onload="this.media='all'; this.onload=null;"/>	
</head>
<body>

	<header>
		<?php include __DIR__ .'/header.html.php';?>
	</header>
	<main class="group">
		<aside class="col-2-10 hide-in-mobile">
				<div>
				<h2>Topics</h2>
				<?php include __DIR__ . '/published_posts_by_topics.html.php';?>
				</div>
		</aside><!--
		--><section class='col-5-10'>
			<!-- The title will be fetched from database -->
			<h1><?php echo ucwords(htmlspecialchars_decode($posts['post_title'])) ;?></h1>
			<div class="post-acreditation">  
				<?php echo isset($posts['updated_at'])? 'Updated on '. date( 'F j, Y', strtotime($posts['updated_at'])): 'Published on '. date( 'F j, Y', strtotime($posts['created_at'])) ?>
			</div>
			<!-- Social icons -->
				<div class="social-media">
					<?php include __DIR__ .'/social-icons-links.php';?>
				</div>
			<div>
                <div class="main-article">
                <!-- The page content will be fetched from database -->
                <?php echo htmlspecialchars_decode($posts['post_body']) ;?>
                </div>
				<div class="social-media">
                <!-- Social icons -->
					<?php include __DIR__ .'/social-icons-links.php';?>
				</div>
				<div>
				<!-- Call to subscribe for notification -->
				<?php  include __DIR__.'/subscribe.html.php';?>
				</div>
				<div>
			<!--Comments sections  -->
			<?php include __DIR__ .'/../comments/comments-layout.php'; ?>
				</div>
			</div>
		</section><!--
		--><aside class='col-3-10'>
			<div class="recent-posts">
			<!-- Sidebar items go here -->
				<h2 class="left">Recent posts</h2>
				<?php $recent_posts = getMostRecentPosts(); ?>
				<?php foreach($recent_posts as $latest_post): ?>
				<p><a href="post.html.php?id=<?php echo $latest_post['post_id'] ?>&title=<?php echo $latest_post['post_slug']?>"> <?php echo $latest_post['post_title'] ?></a></p>
				<?php endforeach; ?>
                <div class="contact-me">
                    <?php include __DIR__ . '/contact-me.html.php'?>
                </div>
			</div>
			
			<div>   
            
			</div>
		</aside><!--			
		--><aside class="hide-in-bigger-screens">
				<div class="published-topics">
				<h2 class="left">Browse Topics</h2>
				<?php include __DIR__ . '/published_posts_by_topics.html.php';?>
				</div>
		</aside>
	</main>
	<script src="<?php echo BASE_URL ?>resources/js/jquery-3.4.0.min.js"></script>
	<script src="<?php echo BASE_URL ?>resources/css/google-code-prettify/prettify.js"></script>
	<script src="<?php echo BASE_URL ?>resources/js/page-control.js"></script>
	<script src="<?php echo BASE_URL ?>resources/js/subscribe-comments-replies-scripts.js"></script>	
	<script>window.onload=function(){prettyPrint()}</script>
	<footer>
		<?php include __DIR__ .'/footer.html.php'?>
	</footer>
</body>
</html>