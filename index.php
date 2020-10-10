<?php 
session_start(); 
require_once __DIR__ .'/config.php';
include __DIR__ .'/admin/includes/posts_functions.php';
include __DIR__ .'/admin/includes/admin_functions.php';
	$published_post_ids = getThreeLatestPublishedPostIds();
?>
<!DOCTYPE html>
<html lan="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width initial-scale=1.0">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Francis Kahindi">
        <title>The Beauty of Landscaping</title>
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/slideshow.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="print" onload="this.media='all'; this.onload=null;"/>
    </head>
    <body>
    <section class="grid-wrapper">
        <header>
            <div class="flex-wrapper">
                <nav class="topnav" id="pgTopnav"><?php include __DIR__ .'/components/nav-bar.php';?></nav>
                
                <div class="social-icons group"><?php include __DIR__ .'/components/social-icons-bar.php';?></div>
            </div>
        </header>
        <div class="logobar">
        <img src="resources/icons/logo.png" loading="lazy" alt="logo" style="max-width:152px;"/>
        <a href="forms/services-form.php"><button><strong>Hire services</strong></button></a>
        </div>
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
            <!--
            <div id="main-image" >
                <h1>No garden is too hard to landscape </h1>
                <figure>
                <img src="images/4.jpeg" loading="lazy" alt="main image" width="90%"/>
                <figcaption></figcaption>
                </figure> 
                <p>The rocky garden brings the feeling of being by sea side. Alovera plants grow wild on the coral cliffs along seaside in coastal regions. They can withstand salty sprays of ocean mist, heat and pushing wind. </p>
            </div>
            -->
            <div class="flex-wrapper">
                <div class="column">
                    <img src="images/7.jpeg" loading="lazy" alt="" style="width:25%;"/> 
                    <p>The rocky garden brings the feeling of being by sea side. Alovera plants grow wild on the coral cliffs along seaside in coastal regions. They can withstand salty sprays of ocean mist, heat and pushing wind. </p>
                </div>
                 <div class="column">
                    <img src="images/1.jpeg" loading="lazy" alt="" style="width:25%;"/> 
                    <p>The rocky garden brings the feeling of being by sea side. Alovera plants grow wild on the coral cliffs along seaside in coastal regions. They can withstand salty sprays of ocean mist, heat and pushing wind. </p>
                </div>
                 <div class="column">
                    <img src="images/3.jpeg" loading="lazy" alt="" style="width:25%;"/> 
                    <p>The rocky garden brings the feeling of being by sea side. Alovera plants grow wild on the coral cliffs along seaside in coastal regions. They can withstand salty sprays of ocean mist, heat and pushing wind. </p>
                </div>
            </div>
            <div class="flex-wrapper">
                <div class="column">
                    <h3>Moowing</h3>
                </div>
                <div class="column">
                    <h3>Landscaping</h3>
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
            <img src="images/chilango.png" loading="lazy" alt="profile pic" width="100px" height="120px" class="profile-pic"/>
            <p>Interests: researching, watching movies,photography, swimming.
            About me: Having worked at vipingo Ridge Golf Course for years and having been trained by professional Greenkeepers from Germany and Ireland, I acquired requisite skills on golf course establishment and maintenance.  My passion for landscaping has made me the work enhancing the beauty of the Universe. </p>
            </div>
            <h3>Contact Vipingo Hills Landscapers</h3>
            
        </aside>
        <footer>
            <?php include __DIR__ .'/components/footer-bar.php';?>
        </footer>
    </section>
    <script>
         function myFunction() {
          var x = document.getElementById("pgTopnav");
          if (x.className === "topnav") {
            x.className += "responsive";
          } else {
            x.className = "topnav";
          }
        } 
    </script>
    <script src="resources/js/slideshow.js"></script>
    <script src="resources/js/jquery-3.4.0.min.js"></script>
    <script src="resources/js/control-page.js"></script>
    </body>
</html>