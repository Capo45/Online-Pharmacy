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

$item="SELECT p.Product_id, p.Product_Name,p.Brief_Description, p.Price,
p.Product_Description,p.Image_path, c.Quantity 
      FROM products p 
      LEFT JOIN cart c ON p.Product_id = c.Product_id
      WHERE c.Quantity>=1 AND c.user_id=$user;";
$result = mysqli_query($GLOBALS['conn'],$item);

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $action=$_POST['action'];
  $p_id=$_POST['product_id'];
  $total=$_POST['passedtotal'];
  $price="SELECT p.Price FROM products p WHERE p.Product_id=$p_id;";
  $res=mysqli_query($GLOBALS['conn'],$price);
  $fetch=mysqli_fetch_assoc($res);
  $prices=$fetch['Price'];
  
  switch($action){
    case'Confirm Order':{
      header("Location: Delivery Details.php");
      exit;
    }
    case'increment':{
      $OldPrice=$prices*$_SESSION['cart'][$p_id];
      $_SESSION['cart'][$p_id]++;
      $NewQuantity= $_SESSION['cart'][$p_id];  
      $NewPrice=$NewQuantity*$prices;

      $stmt = mysqli_prepare($GLOBALS['conn'], "UPDATE cart SET Quantity = ? WHERE Product_id = ? AND user_id = ?");
            mysqli_stmt_bind_param($stmt, 'iii', $NewQuantity, $p_id, $user);
            mysqli_stmt_execute($stmt);
            echo "<li class='cart_item_price' id='price-$p_id' hx-swap-oob='true'>$$NewPrice</li>";
            echo "<span name='quantity' id='quantity-$p_id' hx-swap-oob='true'>$NewQuantity</span>";
            mysqli_stmt_close($stmt);
      $stmt = mysqli_prepare($GLOBALS['conn'], "SELECT SUM(p.Price * c.Quantity) as cart_total 
        FROM cart c 
        JOIN products p ON c.Product_id = p.Product_id 
        WHERE c.user_id = ?");
            mysqli_stmt_bind_param($stmt,"i",$user);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $total_row = mysqli_fetch_assoc($result);
            $NewTotal = $total_row['cart_total'];
            echo "<span class='cart_item_title' id='total' hx-swap-oob='true'>Your Total is: $$NewTotal</span>";exit;
      break;
    }

    case'decrement':{
      $_SESSION['cart'][$p_id]--;
      $NewQuantity = max(1, $_SESSION['cart'][$p_id]);
      $NewPrice=$NewQuantity*$prices;
      $stmt = mysqli_prepare($GLOBALS['conn'], "UPDATE cart SET Quantity = ? WHERE Product_id = ? AND user_id = ?");
            mysqli_stmt_bind_param($stmt, 'iii', $NewQuantity, $p_id, $user);
            mysqli_stmt_execute($stmt);
            echo "<li class='cart_item_price' id='price-$p_id' hx-swap-oob='true'>$$NewPrice</li>";
            echo "<span name='quantity' id='quantity-$p_id' hx-swap-oob='true'>$NewQuantity</span>";
            echo "<p class='cart_item_title' id='total' hx-swap-oob='true'>Your Total is: $</p>";
            exit;
            mysqli_stmt_close($stmt);
            break;
      }

   case'trash':{
    $stmt = mysqli_prepare($GLOBALS['conn'], "DELETE FROM cart WHERE Product_id = ? AND user_id = ?;");
    mysqli_stmt_bind_param($stmt, 'ii', $p_id, $user);
    mysqli_stmt_execute($stmt);
    if(isset($NewQuantity)){echo $NewQuantity; exit;}
    else{exit;}
    mysqli_stmt_close($stmt);
    break;
  }
  }
   }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Cart</title>
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
     <div id="notification-area"></div>
     <p class="product_title" style="margin-left: 1.5rem; margin-top: 8rem;">Shopping Cart</p>
     
     <section id="cartLayout">
      <?php if(!isset($total)) {$total=0;}
                foreach($result as $cart_item){
                  $prod=$cart_item['Product_id'];
                  $quantity=$cart_item['Quantity'];
                  if($quantity>=1){
       ?>
        <div class="cart_items" name="cart_item" id="cart_item-<?php echo $prod; ?>" 
             hx-post="delete" hx-trigger="from:trash" hx-swap="outerHTML" hx-target="this">
            <img src="<?php echo $cart_item['Image_path']; ?>" class="cart_item_image">
            <ul>
                <a href="Product View page.php?product_id=<?php echo htmlspecialchars($prod); ?>">
                  <li class="cart_item_title"><?php $product_name = $cart_item['Product_Name']; 
                                          echo strlen($product_name) > 25 ? substr($product_name, 0, 25)
                                          . '...' : $product_name; ?></li></a>
                <li class="cart_item_description"><?php $product_desc = $cart_item['Brief_Description']; 
                                          echo strlen($product_desc) > 25 ? substr($product_desc, 0, 25)
                                          . '...' : $product_desc; ?></li>
                <li class="cart_item_price" id="price-<?php echo $prod; ?>">
                  $<?php $price=(float)$cart_item['Price'] * (float)$quantity;echo $price;
                   $total = $total + $price;?>
                </li>
                <li>
                  <button hx-post="" hx-target="#quantity-<?php echo $prod; ?>" hx-swap="innerHTML"
                  hx-vals='{
                  "action":"decrement", "product_id": <?php echo json_encode($prod); ?>}'
                   class="cart_buttons" id="decrement">-</button>
                  <span name="quantity" id="quantity-<?php echo $prod; ?>">
                   <?php echo $quantity;?>
                  </span>
                  <input type="hidden" id="passedtotal" value="<?php echo htmlspecialchars($total); ?>">
                  <button hx-post="" hx-target="#quantity-<?php echo $prod; ?>" hx-swap="innerHTML"
                  hx-vals='{
                  "action":"increment",
                  "product_id": <?php echo json_encode($prod); ?>,
                  "passedtotal":<?php echo json_encode($total);?>}' class="cart_buttons" id="increment">+
                  </button>
                  <button hx-post="" hx-vals='{"action": "trash","product_id":<?php echo json_encode($prod);?>}'
                    class="cart_buttons" id="trash">
                   <img src="Images/trash.png " style="width: 1rem;height:1rem;">
                  </button>
                </li>
           </ul>
        </div>
        <?php  }}$_SESSION['total']=$total;
         if($result->num_rows>=1){
        ?>
        <span class="cart_item_title" id="total" value="<?php echo $total;?>">Your Total is: $<?php echo $total; ?></span><br>
        <form method="POST"><input type="submit" class="order" name="action" value="Confirm Order"></form>
       <?php }?>
     </section>

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