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
  $stmt = $mysqli->prepare("INSERT INTO users (user_id) VALUES (?)");
  $stmt->bind_param("i", $_SESSION['user_id']);
}$user=$_SESSION['user_id'];
 try {

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $cart_id = $_POST['id'];
      $quantity=1;
      $stmt = $conn->prepare("INSERT INTO cart (Product_id,user_id, Quantity) VALUES (?,?,?) ON DUPLICATE KEY UPDATE Quantity=Quantity+1;");
      $stmt->bind_param("iii", $cart_id,$user,$quantity); 
      $_SESSION['cart'][$cart_id]=$quantity;
      if($stmt->execute()){echo "<div class='added_alert'>Product added to cart successfully</div>";}
      $stmt->close();
      exit;
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}
   if (isset($_GET['Searchbar'])) {
    $search = $conn->real_escape_string($_GET['Searchbar']);   
    $sql = "SELECT * FROM products WHERE Product_Name LIKE '%$search%' OR Brief_Description LIKE '%$search%' OR Category LIKE '%$search%'";
    $result = $conn->query($sql);
   }
   elseif (isset($_GET['category'])) {
    $search = $conn->real_escape_string($_GET['category']);
    $sql = "SELECT * FROM products WHERE category LIKE '%$search%';";
    $result = $conn->query($sql);
}
elseif (isset($_GET['sub_category'])) {
  $search = $conn->real_escape_string($_GET['sub_category']);
  $sql = "SELECT * FROM products WHERE Sub_category LIKE '%$search%';";
  $result = $conn->query($sql);
}

?> 
<!DOCTYPE HTML>

<html>
    <head>
        <title>Search Results</title>
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
                        <a href="Shopping Cart.php"><img src="Images/Navigation bar/shopping cart icon.png" id="cart_icon"></a>
            </div>
     </section>
     <div id="notification-area"></div>
     <section class="SRP_section">
     <?php
      while($item=mysqli_fetch_assoc($result))
      {
      ?>
        <div class="product-box"> 
        <img class="product-image" src="<?php echo htmlspecialchars($item['Image_path']); ?>" class="advice_images">
          <a href="Product View page.php?product_id=<?php echo htmlspecialchars($item['Product_id']);?>"
           style="text-decoration: none;
           font-size: 1.125rem;
           font-weight: bold;
           margin-bottom: 0.5rem;
           padding-left:1rem;
           padding-top:1.5rem;
           padding-right:0.3rem;
           color: #000000;"><?php $product_name = $item['Product_Name']; 
                                          echo strlen($product_name) > 25 ? substr($product_name, 0, 25)
                                          . '...' : $product_name;?></a>
         <p class="product-description"><?php $product_description = htmlspecialchars($item['Brief_Description']); 
                                          echo strlen($product_description) > 25 ? substr($product_description, 0, 25) 
                                          . '...' : $product_description; ?></p>
          <p class="product-description">$<?php echo htmlspecialchars($item['Price']); ?></p>
            <input type="button" hx-post="" hx-vals='{"id":<?php echo $item['Product_id'];?>}'
            hx-target="#notification-area" hx-swap="innerHTML" class="add-to-cart-btn" name="add_to_cart" 
            value="Add To Cart">
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