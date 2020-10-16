<?php 
session_start(); 
require_once __DIR__ .'/config.php';
include __DIR__ .'/admin/includes/posts_functions.php';
include __DIR__ .'/admin/includes/admin_functions.php';
	$published_post_ids = getFiveLatestPublishedPostIds();
?>
<!DOCTYPE html>
<html lan="en">
    <head>
        <?php include __DIR__ .'/components/head.php';?>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <title>The Beauty of Landscaping</title>
        <?php include __DIR__ .'/components/head-resources.php';?>
        <link rel="stylesheet" href="styles/slideshow.css">
    </head>
    <body>
    <section class="grid-wrapper">
        <?php include __DIR__ .'/components/header.php';?>
        <main>  
            <div class="slideshow-container">
                <div class="mySlides fade">
                  <div class="numbertext">1 / 3</div>
                  <img src="images/landscape.jpg" style="width:100%">
                  <div class="text">There are many advantages to run a home based care with a landscaping service.</div>
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">2 / 3</div>
                  <img src="images/stony.jpg" style="width:100%">
                  <div class="text">Our garden beautification is simple and welcoming. We design, plant and maintain the lawn area. </div>
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">3 / 3</div>
                  <img src="images/weeding.jpg" style="width:100%">
                  <div class="text">Uprooting the unwanted grass gives the garden a welcoming and healthy look.</div>
                </div>

                <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                <a class="next" onclick="plusSlides(1)">&#10095;</a>

            </div>
                <br>

                <div style="text-align:center">
                  <span class="dot" onclick="currentSlide(1)"></span> 
                  <span class="dot" onclick="currentSlide(2)"></span> 
                  <span class="dot" onclick="currentSlide(3)"></span> 
                </div>
           
            <div class="flex-wrapper">
                <?php foreach($published_post_ids as $post_id): ?>
				<?php $post = getPostById($post_id['post_id']) ?>
				<?php $post['author'] = getPostAuthorById($post['user_id'])?>
				
				<div class="column">				
				<a href="templates/post.html.php?id=<?php echo $post_id['post_id'] ?>&title=<?php echo $post['post_slug'] ?>">
				<?php echo (!empty($post['image'])? '<img src="'.$post['image'].'" loading="lazy" width=100 height=100 alt="'.(!empty($post['image_caption'])? $post['image_caption']:'').'" class="article-index-image">':'')?></a>
                <?php echo getFirstParagraphPostById($post_id['post_id']) ?><a href="templates/post.html.php?id=<?php echo $post_id['post_id'] ?>&title=<?php echo $post['post_slug'] ?>">Read more...</a>
				</div>
				<?php endforeach; ?>
                  
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
            <?php include __DIR__ .'/components/footer-bar.php';?>
        </footer>
    </section>
    <script src="resources/js/jquery-1.7.2.min.js"></script>
    
    <script src="resources/js/slideshow.js"></script>
    <script>
        $('document').ready(function() {
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
        window.onresize = function() {
            if (document.documentElement.clientWidth > 598 || window.innerWidth > 615) {
                $('#menu-btn').hide();
                $('#close-btn').hide();
                $('#menu-list').show();
            } else {
                $('#menu-btn').show();
                $('#menu-list').hide();
            }
            }
        });
    </script>
    <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        slideIndex++;
        if (slideIndex > slides.length) {slideIndex = 1}    
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
        setTimeout(showSlides, 10000); // Change image every 10 seconds
        }

    </script>
    </body>
</html>