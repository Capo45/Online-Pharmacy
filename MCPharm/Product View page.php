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
function generateRandomUserId() {
  return random_int(100000, 999999); // Generates a random 6-digit number
}
if(!isset($_SESSION['user_id'])){
  $_SESSION['user_id']=generateRandomUserId();
  $stmt = $mysqli->prepare("INSERT INTO users (user_id) VALUES (?)");
  $stmt->bind_param("i", $_SESSION['user_id']);
} 
 $user=$_SESSION['user_id'];
 try {

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $cart_id = $_POST['id'];
      $quantity = $_POST['quantity'];
      $action=$_POST['Add_cart'];
      switch($action){
        case'add_to_cart':{
          $stmt = $conn->prepare("INSERT INTO cart (Product_id, Quantity,user_id) VALUES (?,?,?) ON DUPLICATE KEY UPDATE Quantity=Quantity+$quantity;");
      $stmt->bind_param("iii", $cart_id, $quantity,$user); 
      
      if ($stmt->execute()) {
         ?>  <h4>Product added to cart successfully.</h4>
      <?php } else {
          echo "Error adding product to cart: " . $stmt->error;
      }
          break;
        }
        case'add_related':{
          $stmt = $conn->prepare("INSERT INTO cart (Product_id,user_id,Quantity) VALUES (?,?,'1')ON DUPLICATE KEY UPDATE Quantity=Quantity+1;");
      $stmt->bind_param("ii", $cart_id,$user); 
      
      if ($stmt->execute()) {
          echo "<h4>Product added to cart successfully.</h4>";
      } else {
          echo "Error adding product to cart: " . $stmt->error;
      }
          break;
        }
      }
      

      // Close the statement
      $stmt->close();
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
   
   if (isset($_GET['product_id'])) {
    
    $product = $conn->real_escape_string($_GET['product_id']);

    $sql = "SELECT * FROM products WHERE Product_id LIKE '%$product%'";
    $related = "SELECT * FROM products WHERE Category_id =( SELECT Category_id 
                                                            FROM products WHERE product_id=$product) 
                                                            AND product_id != $product LIMIT 4";

    // Execute the query
    $result = $conn->query($sql);
    $related = $conn->query($related);
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
        <div id="sidemenu_top"><img src="Images/Navigation bar/sidelogo.png" id="side-logo"> 
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
     </section>       <br>

        <br>



        <?php

        while($row=mysqli_fetch_assoc($result)){

        ?>

        <section id="product_section">

        <form method="POST">

            <div class="product_layout"><img src="<?php echo $row["Image_path"];?>" class="product_image">

               <div>

                <ul class="product_description" style="width:40rem;">

                  <li class="product_title"><?php echo htmlspecialchars($row["Product_Name"]);?></li>

                  <li style="word-break: break-all;hyphens: auto; /* Enable automatic hyphenation */
    overflow-wrap: break-word;
    word-wrap: break-word;"><?php echo htmlspecialchars($row["Brief_Description"]);?></li>

                  <li style="color: #9c0707; font-size: 2rem;">$ <?php echo htmlspecialchars($row["Price"]);?></li>

                   <li><label style="font-size: 2.5rem;color:#9c0707;">Quantity: </label>

                    <select name="quantity" style="height:2.3rem; width:2.5rem; font-size:1.5rem;

                                                   font-family:serif;border-radius: 0.5rem; border:0.1rem #9c0707;

                                                   border-style:solid;">

                <option value="1">1</option>

                <option value="2">2</option>

                <option value="3">3</option>

                <option value="4">4</option>

                <option value="5">5</option>

                    </select>&nbsp;&nbsp;&nbsp;&nbsp;

                    <input type="hidden" class="addto_cart" name="id" value="<?php echo htmlspecialchars($row['Product_id']); ?>">

                    <button class="addto_cart" name="Add_cart" value="add_to_cart">Add To Cart</button></form></li>
                </ul>
             </div>
            </div>
        <div class="detailed_description">
              <p id="details">Description</p>
              <p ><?php echo htmlspecialchars($row["Product_Description"]);?></p>
            </div>
        </section>    
        


        <?php

        }

        ?>

        

        <p class="product_title" style="margin-left: 1.5rem; margin-top: 5rem;animation:fadeIn 2.5s;">Related Products</p>

        <section  id="related">

          <?php 

         while($recco=mysqli_fetch_assoc($related)){

        ?><form method="POST">

        <div class="product-box">

        <img class="product-image" src="<?php echo $recco["Image_path"]; ?>" class="advice_images">

          <a href="Product View page.php?product_id=<?php echo $recco['Product_id']; ?>"

           style="text-decoration: none;

           font-size: 1.125rem;

           font-weight: bold;

           margin-bottom: 0.5rem;

           padding-left:1rem;

           padding-top:1.5rem;

           padding-right:0.3rem;

          color: #000000;"><?php $product_name = $recco["Product_Name"]; 

                                          echo strlen($product_name) > 25 ? substr($product_name, 0, 25)

                                          . '...' : $product_name; ?></a>

         <p class="product-description"><?php $product_description = $recco["Brief_Description"]; 

                                          echo strlen($product_description) > 25 ? substr($product_description, 0, 25) 

                                          . '...' : $product_description; ?></p>

          <p class="product-description">$<?php echo $recco["Price"]; ?></p>

          
            <input type="hidden" name="id" value="<?php echo $recco['Product_id']; ?>">
            <input type="hidden" name="quantity" value="1">
            <button class="add-to-cart-btn" name="Add_cart" value="add_to_cart">Add to Cart</button>

   

          

      </div>       

      </form>

       <?php

         }

       ?>

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