<!DOCTYPE HTML>
<html>
    <head>
        <title>MCPharm</title>
        <meta charset="UTF-8">
        <meta name="description" content="MCPharm is your trusted online pharmacy offering medications, wellness products, supplements, dental care, and cosmetics with fast delivery and personalized support.">
        <meta name="keywords" content="online pharmacy, medications, supplements, dental health, cosmetics, wellness products, MCPharm">
        <meta name="author" content="MCPharm">
        <meta name="viewport" content="width=device-width, initial-scale=0.75">
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="Images/Navigation bar/tab icon.png" type="image/png">
    </head>

    <body>

        <!--Navigation bar on top of page implemented using a table and unordered lists for submenus-->
<section class="navigation_bar">
    <div class="sidenav" id="sidenav">
        <div id="sidemenu_top"><a href="index.php"><img src="Images/Navigation bar/logo.png" id="side-logo"></a> 
            <button id="close_sidenav" onclick="closeNav()"><img src="Images/Navigation bar/exit.png"></button></div>
     <div class="categories">
        <label for="check1"><img src="Images/Navigation bar/down.png" id="arrow"></label>
        <input type="checkbox" id="check1" class="checkbox">
        <a class="categ" href="Search results page.php?category=Medications">Medications</a>
        <div id="submenu1" class="submenus">
        <a href="Search results page.php?sub_category=Pain relief">Pain relief</a></li>
        <br><a href="Search results page.php?sub_category=Digestive Health">Digestive Health</a></li>
        <br><a href="Search results page.php?sub_category=Allergy & Cold">Allergy & Cold</a></li>
        <br><a href="Search results page.php?sub_category=Chronic Condition Management">Chronic Condition Management</a></li>
    </div>
    </div>
    
    <div class="categories">
        <label for="check2"><img src="Images/Navigation bar/down.png" id="arrow"></label>
        <input type="checkbox" id="check2" class="checkbox">
        <a class="categ" href="Search results page.php?category=Supplements">Supplements</a>
        <div id="submenu2" class="submenus">
        <a href="Search results page.php?sub_category=Multi-Vitamins">Multi-Vitamins</a>
        <br><a href="Search results page.php?sub_category=Minerals">Minerals</a>
        <br><a href="Search results page.php?sub_category=Herbal Supplements">Herbal Supplements</a>
        <br><a href="Search results page.php?sub_category=Fitness & Sports Nutrition">Fitness & Sports Nutrition</a></> 
        </div>
    </div>
      
        <div class="categories">
            <label for="check3"><img src="Images/Navigation bar/down.png" id="arrow"></label>
            <input type="checkbox" id="check3" class="checkbox">
            <a class="categ" href="Search results page.php?category=Dental">Dental Health</a>
            <div id="submenu3" class="submenus">
                <a href="Search results page.php?sub_category=Toothpaste">Toothpaste</a>
                <br><a href="Search results page.php?sub_category=Mouth Wash">Mouth Wash</a>
                <br><a href="Search results page.php?sub_category=Dental floss">Dental floss</a>
                <br><a href="Search results page.php?sub_category=Toothbrushes">Toothbrushes</a>
            </div>    
        </div>
        <div class="categories">
            <label for="check4"><img src="Images/Navigation bar/down.png" id="arrow"></label>
            <input type="checkbox" id="check4" class="checkbox">
            <a class="categ" href="Search results page.php?category=cosmetics">Cosmetics</a>
            <div id="submenu4" class="submenus">
                <a href="Search results page.php?sub_category=Skin Care Products">Skin Care Products</a>
                <br><a href="Search results page.php?sub_category=Makeup">Makeup</a>
                <br><a href="Search results page.php?sub_category=Fragrances">Fragrances</a>
                <br><a href="Search results page.php?sub_category=Hair dyes">Hair dyes</a> 
            </ul>
        </div>
    </div>
    </div>
            <div class="strp">
                    <button id="sidemenu" onclick="openNav()"><img src="Images/Navigation bar/menu.png" id="sidemenu_image"></button>
                    <a href="index.php"><img src="Images/Navigation bar/logo.png" style="width: 3.938rem;height: 3rem; padding-left: 2rem; padding-top: 0;"></a>
                        <form action="Search results page.php" method="GET">
                       <div class="searchbar_wrapper"><input type="search" placeholder="Search" name="Searchbar"
                        class="searchbar">
                           </div>
                       </form> 
                        <a href="Shopping Cart.php"><img src="Images/Navigation bar/shopping cart icon.png"  id="cart_icon"></a>
            </div>
     </section>
        
        <!--Image Slideshow, with dots appearing on pictures to help navigate through-->
        <section class="container">
            <div class="slider-wrapper">
                <div class="slider">
                    <img src="Images/Slideshow/pills.jpeg" id="slide1">
                    <img src="Images/Slideshow/delivery.jpeg" id="slide2">
                    <img src="Images/Slideshow/store.jpg" id="slide3">
                </div>

                <div class="slider-nav">
                    <a href="#slide1"></a>
                    <a href="#slide2"></a>
                    <a href="#slide3"></a>
                </div>
            </div>
        </section>

        <!--Introductory Paragraph-->
        <section class="textcontainer" >
            <div class="intro">
            <div class="introtitle"><h2 style="color: #9c0707; font-size: 2rem;">Welcome to MCPharm!</h2></div>
                <p><h3>Your trusted online pharmacy dedicated to providing high-quality medications and health products right to your doorstep. 
                Our licensed pharmacists are always available to offer personalized advice and support. 
                Discover a wide range of prescription and over-the-counter medications,wellness products, and health services.
                 At MCPharm, your health and satisfaction are our top priorities.</h3></p></div>
        </section>

        <!--Special offer Images implemented using a table-->
        <h1>Special Offers:</h1>
            <div class="offers_table">
                <a class="offer_images_cell" href="Search results page.php?Searchbar=panadol"><img src="Images/offers/panadol offer.png"  class="offers"></a>
                <a class="offer_images_cell" href="Search results page.php?sub_category=Skin Care Products"><img src="Images/offers/anti-aging offer.png" class="offers"></a>
                <a class="offer_images_cell" href="Search results page.php?sub_category=Hair dyes"><img src="Images/offers/hair dye offer.png" class="offers"></a><br>
                <a class="offer_images_cell" href="Search results page.php?Searchbar=multivitamin"><img src="Images/offers/multivitamins offer.png" class="offers"></a>
                <a class="offer_images_cell" href="Search results page.php?Searchbar=weight loss"><img src="Images/offers/weight loss offer.png" class="offers"></a>
                <a class="offer_images_cell" href="Search results page.php?category=Dental"><img src="Images/offers/Dental offer.png" class="offers"></a>
            </div>

        <!--Advice section with images and text-->
        <section>
            <div class="introtitle"><h1>Useful advice:</h1></div>
            <div class="advice_section" style="margin-top: 0%;">
                <div class="advice_container"><img src="Images/Advice/dental floss advice.jpeg"  class="advice_images">
                    <p class="advice_title">Dental Floss</p>
                    <p class="advice_text">Dental floss helps prevent common issues like plaque buildup, gum disease, and cavities by removing food particles and plaque from between teeth.
                         It also improves overall oral hygiene and reduces bad breath. Regular flossing is essential for maintaining a healthy smile.</p>
            </div>

            <div class="advice_container"><img src="Images/Advice/omega3 advice.jpg" class="advice_images">
                <p class="advice_title">Omega-3</p>
                <p class="advice_text">Omega-3 fatty acids are essential for heart health, reducing inflammation, and supporting brain function.
                     They can help lower the risk of chronic diseases such as heart disease and arthritis. 
                    Including omega-3 in your diet promotes overall well-being and cognitive health.</p></div>
            <div class="advice_container"><img src="Images/Advice/skin care advice.jpg" class="advice_images"> 
                <p class="advice_title">Face Care</p>
                <p class="advice_text">Face care products help maintain healthy skin by cleansing, moisturizing, and protecting against environmental damage. 
                    Regular use can prevent issues like acne, dryness, and premature aging. Investing in a good skincare routine enhances your skin's appearance and overall health.</p></div> 
        </div>
        </section>

        <!--Page Footer containing payment options, links to relevant pages and contact tools-->
        <footer>
            <div class="footer-container">
              <div class="footer-section links">
                <p class="footer_headings">Quick Links</p>
                <ul>
                  <li><a href="#" class="footer_link">About Us</a></li>
                  <li><a href="#" class="footer_link">Services</a></li>
                  <li><a href="#" class="footer_link">Contact</a></li>
                  <li><a href="#" class="footer_link">FAQ</a></li>
                </ul>
              </div>

              <div class="footer-section payment-methods">
                <p class="footer_headings">Payment Methods</p>
                <img src="Images/Footer/Visa_Logo.png" alt="Visa"><br>
                <img src="Images/Footer/MasterCard_logo.png" alt="Mastercard"><br>
                <img src="Images/Footer/Paypal-logo.png" alt="PayPal">
              </div>

              <div class="footer-section contact-info">
                <p class="footer_headings">Contact Us</p>
                <p>123 Main Street, City, Country</p>
                <p>Email: info@example.com</p>
                <p>Phone: +1 234 567 8900</p>
              </div>

              <div class="footer-section social-media">
                <p class="footer_headings">Follow Us</p>
                <a href="#"><img src="Images/Footer/insta_logo_black.png" alt="Instagram"></a>
                <a href="#"><img src="Images/Footer/tiktok_icon_black.png" alt="TikTok"></a>
                <a href="#"><img src="Images/Footer/whatsapp_logo.png" alt="Whatsapp"></a>
              </div>
            </div> 

            <div class="copyright">
              <p>&copy; 2024 MCPharm. All rights reserved.</p>
            </div>
          </footer>
          <script>
            function openNav() {
                document.getElementById("sidenav").classList.add("active");
            }
            function closeNav() {
                document.getElementById("sidenav").classList.remove("active");
            }
        </script>
    </body>
</html>