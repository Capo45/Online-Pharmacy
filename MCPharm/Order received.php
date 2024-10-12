<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 session_start();
 $config = require 'config.php';  
$db_host = $config['DB_HOST'];
$db_user = $config['DB_USER'];
$db_password = $config['DB_PASSWORD'];
$db_name = $config['DB_NAME'];
$db_port = $config['DB_PORT']; 
 $conn="";

$conn=new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);

$user=$_SESSION['user_id'];

 $details="SELECT * FROM receipts";
 $run = mysqli_query($conn,$details);
 $item="SELECT p.Product_id, p.Product_Name,p.Brief_Description, p.Price,p.Product_Description,p.Image_path, c.Quantity
 FROM products p 
 LEFT JOIN cart c ON p.Product_id = c.Product_id
 WHERE c.Quantity>=1 AND c.user_id=$user;";
 $result = mysqli_query($conn,$item);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $clear = "DELETE FROM receipts WHERE user_id=$user";
    $reset = mysqli_query($conn,$clear);
    header("Location:index2.html");
      exit();
  }
 ?>


<!DOCTYPE HTML>

<html>

    <head>

        <title>Online Pharmacy website</title>

        <meta charset="UTF-8">

        <meta name="description" content="MCPharm is your trusted online pharmacy offering medications, wellness products, supplements, dental care, and cosmetics with fast delivery and personalized support.">

        <meta name="keywords" content="online pharmacy, medications, supplements, dental health, cosmetics, wellness products, MCPharm">

        <meta name="author" content="MCPharm">

        <meta name="viewport" content="width=device-width, initial-scale=0.75">

        <link rel="stylesheet" href="style.css">

    </head>

    

    <body>

        <!--Navigation bar on top of page implemented using a table and unordered lists for submenus-->
        <section class="navigation_bar">
   
    <div class="sidenav" id="sidenav">
    <div id="sidemenu_top"><a href="index2.html"><img src="Images/Navigation bar/sidelogo.png" id="side-logo"></a>  
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
                    <a href="index2.html"><img src="Images/Navigation bar/logo.png" style="width: 3.938rem;height: 3rem; padding-left: 2rem; padding-top: 0;"></a>
                    
                    
                        <form action="Search results page.php" method="GET">
                       <div class="searchbar_wrapper"><input type="search" placeholder="Search Item......." name="Searchbar"
                        class="searchbar">
                           </div>
                       </form> 
                        <a href="Shopping Cart.php"><img src="Images/Navigation bar/shopping cart icon.png"  id="cart_icon"></a>
            </div>
     </section>

       <section style="margin-top: 10rem; margin-left: 25rem; margin-right: 25rem;">

        <h1>YOUR ORDER HAS BEEN RECEIVED!</h1><br><br>

       </section><form method="POST"><?php if($run->num_rows>=1){$info=mysqli_fetch_assoc($run); ?>

       <section class="details_section" id="receipt_layout">

   <div class="details_container" style="animation: bills 2s;">

   <img src="logo.png" style="width: 6rem;height:4rem">    

   <p class="product_title" style="margin-left: 1rem; margin-bottom:0.12rem;">Your Receipt</p>

   <div style="margin-left:1.5rem;line-height:0.3;">

    <address>

    <ul>

    <li>

    

    <p>Receipt Number: <?php echo htmlspecialchars($info['Receipt_id']); ?></p>

    <p>Name: <?php echo htmlspecialchars($info['Firstname']); ?></p>

    <p>Surame: <?php echo htmlspecialchars($info['Surname']); ?></p>

    </li>

    <li><p>Address1: <?php echo htmlspecialchars($info['Address_1']); ?></p></li>

    <li><p>Address2: <?php echo htmlspecialchars($info['Address_2']); ?></p></li>

    <li>

    <p>Postal Code: <?php echo htmlspecialchars($info['Postal_code']); ?></p>

    <p>Floor: <?php echo htmlspecialchars($info['Floor']); ?></p>

    <p>Apartment: <?php echo htmlspecialchars($info['Apartment']); ?></p></li>

    <li>

    <p>Phone: <?php echo htmlspecialchars($info['Phone']); ?></p>

    <p>Email: <?php echo htmlspecialchars($info['Email']); ?></p></li>

    <li><p>Additional comments: <?php echo htmlspecialchars($info['Additional_comments']); ?></p></li>

    </ul></address>

   </div>

    <div style="background-color: #ec4747a2; border-radius:0.5rem;border-style:none;padding:0.5rem"><?php $total=0;

     while($items=mysqli_fetch_assoc($result)){

        $product_name=$items['Product_Name'];

        $quantity=$items['Quantity'];

        $price=(int)$items['Price'] * (int)$items['Quantity'];

        $total=$total+$price;

   ?>

   <p class="bill"><?php echo $quantity; echo"X "; echo $product_name; echo ":   $"; echo $price;?></p>  

   <?php } ?></div>

   <p class="bill" id="total">Your total is: $<?php echo $total ?></p>

   <input class="place_order" type="submit" value="Confirm">

</div>

   </section></form><?php } ?>

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