<?php
$config = require 'config.php';  
$db_host = $config['DB_HOST'];
$db_user = $config['DB_USER'];
$db_password = $config['DB_PASSWORD'];
$db_name = $config['DB_NAME'];
$db_port = $config['DB_PORT']; 
$conn="";
 $conn = new mysqli($db_host, $db_user, $db_password, $db_name, $db_port);
 
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);
 session_start();
 
function generateRandomUserId() {
  return random_int(100000, 999999); 
}
if(!isset($_SESSION['user_id'])){
  $_SESSION['user_id']=generateRandomUserId();
}$user=$_SESSION['user_id'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $cart_id = $_POST['product_id'];
    $quantity= $_POST['passquantity']??1;
      switch($action){
        case'add_to_cart':{ 
          $stmt =  mysqli_prepare($conn,"INSERT INTO cart (Product_id, Quantity,user_id) VALUES (?,?,?) ON DUPLICATE KEY UPDATE Quantity=Quantity+?;");
          mysqli_stmt_bind_param($stmt,"iiii", $cart_id, $quantity,$user,$quantity); 
          mysqli_stmt_execute($stmt);
           echo "<div class='added_alert'>Product added to cart successfully</div>";
          mysqli_stmt_close($stmt);
          break;
        }
        case'add_related':{
          $stmt = mysqli_prepare($conn,"INSERT INTO cart (Product_id,user_id,Quantity) VALUES (?,?,'1')ON DUPLICATE KEY UPDATE Quantity=Quantity+1;");
                  mysqli_stmt_bind_param($stmt,"ii", $cart_id,$user); 
                  mysqli_stmt_execute($stmt);
                  echo "<div class='added_alert'>Product added to cart successfully</div>";
                  mysqli_stmt_close($stmt);
          break;
        }
      }
      $_SESSION['cart'][$cart_id]=$quantity;
      exit;
  }

   if (isset($_GET['product_id'])) {  
    $product = $conn->real_escape_string($_GET['product_id']);
    $sql = "SELECT * FROM products WHERE Product_id LIKE '%$product%'";
    $related = "SELECT * FROM products WHERE Category_id =( SELECT Category_id 
                                                            FROM products WHERE product_id=$product) 
                                                            AND product_id != $product LIMIT 4";
    $result = $conn->query($sql);
    $related = $conn->query($related);
   }

?> 
<!DOCTYPE HTML>
<html>
    <head>
        <title>Product View</title>
        <meta charset="UTF-8">
        <meta name="description" content="MCPharm is your trusted online pharmacy offering medications, wellness products, supplements, dental care, and cosmetics with fast delivery and personalized support.">
        <meta name="keywords" content="online pharmacy, medications, supplements, dental health, cosmetics, wellness products, MCPharm">
        <meta name="author" content="MCPharm">
        <meta name="viewport" content="width=device-width, initial-scale=0.75"> 
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="Images/Navigation bar/tab icon.png" type="image/png">
        <script src="https://unpkg.com/htmx.org@1.9.2"></script>
    </head>

    <body>

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
         <div class="searchbar_wrapper">
          <input type="search" placeholder="Search" name="Searchbar" class="searchbar">
         </div>
       </form> 
       <a href="Shopping Cart.php"><img src="Images/Navigation bar/shopping cart icon.png"  id="cart_icon"></a>
    </div>
     </section>
        <br>
        <br>
        <?php 
        while($row=mysqli_fetch_assoc($result)){    
        ?><div id="notification-area"></div>
        <section id="product_section">
            <div class="product_layout">
              <img src="<?php echo $row["Image_path"];?>" class="product_image">
               <div>
                <ul class="product_description">
                  <li class="product_title"><?php echo htmlspecialchars($row["Product_Name"]);?></li>
                  <li id="breif_description">
                    <?php echo htmlspecialchars($row["Brief_Description"]);?></li>
                  <li style="color: #9c0707; font-size: 2rem; padding-left:1rem;">$ <?php echo htmlspecialchars($row["Price"]);?></li>
                   <li><label style="font-size: 2.5rem;color:#9c0707;padding:1rem;">Quantity: </label>
                  <button class="cart_buttons" id="decrement" onclick="decrement()">-</button>
                  <span name="quantity" id="quantity">1</span>
                  <input type="hidden" id="passquantity" name="passquantity" value="1">
                  <button class="cart_buttons" id="increment" onclick="increment()">+</button>
                    <button 
                    hx-post="" 
                    hx-include="#passquantity"
                    hx-vals='{
                    "product_id":<?php echo json_encode($row["Product_id"]) ; ?> , 
                    "action":"add_to_cart"}'
                    hx-target="#notification-area"
                    hx-swap="outerHTML"
                    class="addto_cart">Add To Cart</button>
                    </li>
                </ul>
             </div>
            </div>
        <div class="detailed_description">
              <p id="details">Description</p>
              <p class=""><?php echo htmlspecialchars($row["Product_Description"]);?></p>
            </div>
        </section>    
        <?php
        }
        ?>
        <p class="product_title" style="margin-left: 1.5rem; margin-top: 5rem;animation:fadeIn 2.5s;">Related Products</p>
        <section  id="related">
          <?php 
         while($recco=mysqli_fetch_assoc($related)){
        ?>
        <div class="product-box">
        <img class="product-image" src="<?php echo $recco["Image_path"]; ?>" class="advice_images">
          <a href="Product View page.php?product_id=<?php echo $recco['Product_id']; ?>">
            <?php $product_name = $recco["Product_Name"]; 
                                          echo strlen($product_name) > 25 ? substr($product_name, 0, 25)
                                          . '...' : $product_name; ?></a>
         <p class="product-description">
          <?php $product_description = $recco["Brief_Description"]; 
                                       echo strlen($product_description) > 25 ? substr($product_description, 0, 25) 
                                        . '...' : $product_description; ?></p>
          <p class="product-description">$<?php echo $recco["Price"]; ?></p>
            <button 
            hx-post="" hx-vals='{"product_id":<?php echo $recco['Product_id'] ; ?> , "action":"add_related"}'
            hx-target="#notification-area" hx-swap="innerHTML" class="add-to-cart-btn">Add to Cart</button>
      </div>       
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
            function increment(){
              let quantityElement=document.getElementById("quantity");
              let quantity=parseInt(quantityElement.textContent);
              quantity++;
              quantityElement.textContent=quantity;
              let passquantity=document.getElementById("passquantity");
              passquantity.value=quantity;
            }
            function decrement(){
              let quantityElement=document.getElementById("quantity");
              let quantity=parseInt(quantityElement.textContent);
              if(quantity>1){
              quantity--;}
              quantityElement.textContent=quantity; 
              let passquantity=document.getElementById("passquantity");
              passquantity.value=quantity;
            }
            document.addEventListener('htmx:afterSwap', (event) => {
        if (event.detail.target.id === 'notification-area') {
            const notification = event.detail.target.querySelector('.added_alert');
            if (notification) {
                setTimeout(() => {
                    notification.remove();
                }, 3000);}
            }
              });
        </script>
    </body>
</html>