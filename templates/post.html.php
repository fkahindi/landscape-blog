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
        <main class="grid-wrapper">
            <article>
                    <!-- Article will be fetched from database -->
                <div class="main-image">
                    <?php echo (!empty($posts['image'])? '<img src="'.$posts['image'].'" loading="lazy" width=70% alt="'.(!empty($posts['image_caption'])? $posts['image_caption']:'').'" class="main-image">':'')?>
                </div>
                <h1><?php echo ucwords(htmlspecialchars_decode($posts['post_title'])) ;?></h1>
                <div class="acreditation">  
                    <?php echo isset($posts['updated_at'])? 'Updated on '. date( 'F j, Y', strtotime($posts['updated_at'])): 'Published on '. date( 'F j, Y', strtotime($posts['created_at'])) ?>
                </div>
                <div>
                    <div class="main-article">
                    <!-- The page content will be fetched from database -->
                    <?php echo htmlspecialchars_decode($posts['post_body']) ;?>
                    </div>
                    <p>It’s important to understand that Git’s idea of a “working copy” is very different from the working copy you get by checking out source code from an SVN repository. Unlike SVN, Git makes no distinction between the working copies and the central repository—they're all full-fledged Git repositories.
This makes collaborating with Git fundamentally different than with SVN. Whereas SVN depends on the relationship between the central repository and the working copy, Git’s collaboration model is based on repository-to-repository interaction. Instead of checking a working copy into SVN’s central repository, you push or pull commits from one repository to another.
Of course, there’s nothing stopping you from giving certain Git repos special meaning. For example, by simply designating one Git repo as the “central” repository, it’s possible to replicate a centralized workflow using Git. This is accomplished through conventions rather than being hardwired into the VCS itself.
<h4>Bare vs. cloned repositories</h4>
If you used git clone in the previous "Initializing a new Repository" section to set up your local repository, your repository is already configured for remote collaboration. git clone will automatically configure your repo with a remote pointed to the Git URL you cloned it from. This means that once you make changes to a file and commit them, you can git push those changes to the remote repository.
If you used git init to make a fresh repo, you'll have no remote repo to push changes to. A common pattern when initializing a new repo is to go to a hosted Git service like Bitbucket and create a repo there. The service will provide a Git URL that you can then add to your local Git repository and git push to the hosted repo. Once you have created a remote repo with your service of choice you will need to update your local repo with a mapping. We discuss this process in the Configuration & Set Up guide below.
If you prefer to host your own remote repo, you'll need to set up a "Bare Repository." Both git init and git clone accept a --bare argument. The most common use case for bare repo is to create a remote central Git repository
</p>
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
</article>
            			
        </main>
        <aside>
            <div class="services">
                <?php include __DIR__ . '/../components/services-panel.php' ?>
            </div>
            <div class="profile">
                <?php include __DIR__ . '/../components/chilango-profile.php'?>
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