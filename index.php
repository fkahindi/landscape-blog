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
                  <img src="images/landscape.jpg" style="width:100%;height:auto">
                  <div class="text">There are many advantages to run a home based care with a landscaping service.</div>
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">2 / 3</div>
                  <img src="images/stony.jpg" style="width:100%;height:auto">
                  <div class="text">Our garden beautification is simple and welcoming. We design, plant and maintain the lawn area. </div>
                </div>

                <div class="mySlides fade">
                  <div class="numbertext">3 / 3</div>
                  <img src="images/weeding.jpg" style="width:100%;height:auto">
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
              <?php include __DIR__ . '/components/services-panel.php' ?>
                
            </div>
            <div class="profile">
              <?php include __DIR__ . '/components/chilango-profile.php'?>
            </div>
            <h3>Contact Vipingo Hills Landscapers</h3>
            
        </aside>
        <footer>
            <?php include __DIR__ .'/components/footer-bar.php';?>
        </footer>
    </section>
    <script src="resources/js/jquery-1.7.2.min.js"></script>
    <script src="resources/js/control-page.js"></script>
    <script>
    /* JS for pic slideshow */
       var slideIndex = 1;
        var myTimer;
        var slideshowContainer;
        window.addEventListener("load",function() {
          showSlides(slideIndex);
          myTimer = setInterval(function(){plusSlides(1)}, 4000);
          
          slideshowContainer = document.getElementsByClassName('slideshow-inner')[0];
          
          slideshowContainer = document.getElementsByClassName('slideshow-container')[0];
          
          slideshowContainer.addEventListener('mouseenter', pause)
          slideshowContainer.addEventListener('mouseleave', resume)
        })

        function plusSlides(n){
          clearInterval(myTimer);
          if (n < 0){
            showSlides(slideIndex -= 1);
          } else {
           showSlides(slideIndex += 1); 
          }
            
          if (n === -1){
            myTimer = setInterval(function(){plusSlides(n + 2)}, 4000);
          } else {
            myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
          }
        }

        function currentSlide(n){
          clearInterval(myTimer);
          myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
          showSlides(slideIndex = n);
        }

        function showSlides(n){
          var i;
          var slides = document.getElementsByClassName("mySlides");
          var dots = document.getElementsByClassName("dot");
          if (n > slides.length) {slideIndex = 1}
          if (n < 1) {slideIndex = slides.length}
          for (i = 0; i < slides.length; i++) {
              slides[i].style.display = "none";
          }
          for (i = 0; i < dots.length; i++) {
              dots[i].className = dots[i].className.replace(" active", "");
          }
          slides[slideIndex-1].style.display = "block";
          dots[slideIndex-1].className += " active";
        }

        pause = () => {
          clearInterval(myTimer);
        }

        resume = () =>{
          clearInterval(myTimer);
          myTimer = setInterval(function(){plusSlides(slideIndex)}, 4000);
        } 
    </script>
    
    </body>
</html>