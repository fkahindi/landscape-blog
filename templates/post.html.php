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
    <?php include __DIR__ .'/../components/head.php';?>
    <title><?php echo htmlspecialchars_decode($posts['post_title']) ;?> </title>
	<meta name="description" content="<?php echo (isset($posts['meta_description'])? htmlspecialchars_decode($posts['meta_description']):''); ?>" />
    <?php include __DIR__ .'/../components/head-resources.php';?>
    <link rel="stylesheet" href="../styles/subscribe-section.css" media="print" onload="this.media='all'; this.onload=null;">
</head>
<body>
   <section class="grid-wrapper">
        <?php include __DIR__ .'/../components/header.php';?>
        <main>
            <!-- The title will be fetched from database -->
            <h1><?php echo ucwords(htmlspecialchars_decode($posts['post_title'])) ;?></h1>
            <div class="acreditation">  
                <?php echo isset($posts['updated_at'])? 'Updated on '. date( 'F j, Y', strtotime($posts['updated_at'])): 'Published on '. date( 'F j, Y', strtotime($posts['created_at'])) ?>
            </div>
            <div class="main-image">
                <?php echo (!empty($posts['image'])? '<img src="'.$posts['image'].'" loading="lazy" width=70% alt="'.(!empty($posts['image_caption'])? $posts['image_caption']:'').'" class="main-image">':'')?>
            </div>
            
            <div>
                <div class="main-article">
                <!-- The page content will be fetched from database -->
                <?php echo htmlspecialchars_decode($posts['post_body']) ;?>
                </div>
                <div class="subscribe-section">
                    <form  method="POST" action="" id="subscribe-form" >
                        <div id="subscribe-error"></div>                                        
                            <input name="email" id="email"  type="text" 
                            type="email" value="<?php echo(empty($email)? '': $email); ?>" maxlength="50" placeholder="Enter your email" autocomplete="off">
                            <input name="subscribe" type="submit" id="subscribe-btn" class="button" value="Subscribe">
                            <br><span class="form-error"> <?php echo(!empty($errors['email']) ? $errors['email'] : ''); ?> </span>
                            
                    </form>
                    <div id="subscribe_response"><p></p></div>
                </div>
            </div>			
        </main>
        <aside>
            <div class="services">
                <h3>Services</h3>
                <a href="#">&#129174; Grass planting</a>
                <a href="#">&#129174; Lawn mowing and maintenance</a>
                <a href="#">&#129174; Weeding and flower beds</a>
                <a href="#">&#129174; Fertilizing and pest control </a>
                <a href="#">&#129174; Trees and flowers supplies</a>
            </div>
            <div class="profile">
           <h3>Chilango Kiti</h3>
            <img src="<?php echo BASE_URL ?>images/chilango.png" loading="lazy" alt="profile pic" width="100px" height="120px" class="profile-pic"/>
            <p>Interests: researching, watching movies,photography, swimming.
            About me: Having worked at vipingo Ridge Golf Course for years and having been trained by professional Greenkeepers from Germany and Ireland, I acquired requisite skills on golf course establishment and maintenance.  My passion for landscaping has made me the work enhancing the beauty of the Universe. </p>
            </div>
            <h3>Contact Vipingo Hills Landscapers</h3>
            
        </aside>
        
        <footer>
            <?php include __DIR__ .'/../components/footer-bar.php';?>
        </footer>
    </section>
	<script src="<?php echo BASE_URL ?>resources/js/jquery-1.7.2.min.js"></script>
	<!-- <script src="<?php echo BASE_URL ?>resources/js/page-control.js"></script> -->
	<script src="<?php echo BASE_URL ?>resources/js/subscribe-comments-replies-scripts.js"></script>
	<script>
        $('document').ready(function() {
    window.onresize = function() {
        if (document.documentElement.clientWidth > 600 || window.innerWidth > 617) {
            $('#menu-btn').hide();
            $('#close-btn').hide();
            $('#menu-list').show();
        } else {
            $('#menu-btn').show();
            $('#menu-list').hide();
        }
    }
    $('#menu-btn').click(function() {
        $('#menu-list').show();
        $('#menu-btn').hide();
        $('#close-btn').show();
    });
    $('#close-btn').click(function() {
        $('#menu-list').hide();
        $('#close-btn').hide();
        $('#menu-btn').show();
    });
});
    </script>
</body>
</html>