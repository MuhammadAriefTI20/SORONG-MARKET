  
  <?php
session_start();
include 'dbconnect.php';
error_reporting(0);
if(!isset($_SESSION['cart'])){
  $_SESSION['cart'] = array();
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="description" content="SORONG MARKET LAPAK DAGANG SORONG">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>SORONG MARKET</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap">
    <!-- Favicon-->
    <link rel="icon" href="logo.png">
    <!-- Apple Touch Icon-->
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/default/lineicons.min.css">
    <!-- Stylesheet-->
    <link rel="stylesheet" href="style.css">
    
  </head>
  <body style="border: 10px double black; background-color:#feffd7; border-bottom:none;">
    <!-- Preloader-->
    <div class="preloader" id="preloader">
      
     
    </div>
    <!-- Header Area-->
    <div class="header-area" style="background-color: #1A1423;"id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="home.html"><img  style="height:40px;" src="logo.png" alt=""></a></div>
        <!-- Search Form-->
        <div class="top-search-form">
          <form action="cari.php" method="post">
            <input class="form-control" type="search" name="Search" placeholder="CARI PRODUK !!">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>
        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler" style="visibility: none;" ></div>
      </div>
    </div>
    <!-- Sidenav Black Overlay-->
    
    <!-- Side Nav Wrapper-->
 
     
    <!-- PWA Install Alert-->
   
    <div class="page-content-wrapper">
      <?php
if (isset($_POST['hapus'])){
unset($_SESSION['cart']);
  $_SESSION['message'] = 'KEANJANG TELAH DIKOSONGKAN';

  header('location: keranjang.php');
} 

elseif (isset($_POST['save'])) {
    foreach($_POST['indexes'] as $key){
      $_SESSION['qty_array'][$key] = $_POST['qty_'.$key];
    }

    $_SESSION['message'] = 'Cart updated successfully';
    header('location: keranjang.php');
  }
  $s=$_GET['id'];
if (!empty($s)) {
$key = array_search($s, $_SESSION['cart']);  
  unset($_SESSION['cart'][$key]);

  unset($_SESSION['qty_array'][$_GET['index']]);
  //rearrange array after unset
  $_SESSION['qty_array'] = array_values($_SESSION['qty_array']);

  $_SESSION['message'] = "Product deleted from cart";
  header('location: keranjang.php');

}
  
?>
<div class="container">
        <!-- Cart Wrapper-->
        <div class="cart-wrapper-area py-3">
          <div class="cart-table card mb-3">
            <div class="table-responsive card-body">
               <form method="POST" action="">
              <table class="table mb-0">
                <tbody><?php
            //initialize total
            $total = 0;
            if(!empty($_SESSION['cart'])){
            //connection
            $conn = new mysqli('localhost', 'root', '', 'tokopekita');
            //create array of initail qty which is 1
            $index = 0;
            if(!isset($_SESSION['qty_array'])){
              $_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
            }
            $sql = "SELECT * FROM produk WHERE idproduk IN (".implode(',',$_SESSION['cart']).")";
            $query = $conn->query($sql);
              while($row = $query->fetch_assoc()){
                ?>
                  <tr>
                    <th scope="row"><a href="keranjang.php?id=<?php echo $row['idproduk']; ?>&index=<?php echo $index; ?>" class="remove-product"><i class="lni lni-close"></i></a></th>
                    <td><img src="<?php echo $row['gambar']; ?>" alt=""></td>
                    <td><a href="single-product.html"><?php echo $row['namaproduk']; ?></a></td>
                    <td><?php echo number_format($row['hargaafter'], 2); ?></td>
                    <td> <input type="hidden" name="indexes[]" value="<?php echo $index; ?>">
                      <div class="quantity"><input type="number" class="qty-text" value="<?php echo $_SESSION['qty_array'][$index]; ?>" name="qty_<?php echo $index; ?>">
                   
                      </div>
                    </td>
                    <td><?php echo number_format($_SESSION['qty_array'][$index]*$row['hargaafter'], 2); ?></td>
                  <?php $total += $_SESSION['qty_array'][$index]*$row['hargaafter']; ?>
                  </tr>
                     <?php
                $index ++;
              }
            }
            else{
              ?>
              <tr>
                <td colspan="4" class="text-center">No Item in Cart</td>
              </tr>
              <?php
            }

          ?>
          <tr>
            <td colspan="4" align="right"><b>Total</b></td>
            <td><b><?php echo number_format($total, 2); ?></b></td>
            
          </tr>
                </tbody>
              </table>
              <button type="submit" class="btn btn-success" name="save">Simpan Perubahan</button>
      <button type="submit" class="btn btn-danger" name="hapus">Hapus Produk</button>
      </form> </div>
          </div>
 <?php if (isset($_POST['gass']))
{
?>
<?php
$a = $_POST['nama'];
$b = $_POST['nomer'];
$c = $_POST['alamat'];
            //initialize total
            $total = 0;
            if(!empty($_SESSION['cart'])){
            //connection
            $conn = new mysqli('localhost', 'root', '', 'tokopekita');
            //create array of initail qty which is 1
            $index = 0;
            if(!isset($_SESSION['qty_array'])){
              $_SESSION['qty_array'] = array_fill(0, count($_SESSION['cart']), 1);
            }
            $sql = "SELECT * FROM produk WHERE idproduk IN (".implode(',',$_SESSION['cart']).")";
            $query = $conn->query($sql);?><div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
              <a class="btn btn-warning" href="https://api.whatsapp.com/send?phone=+6282198092618&text=ASSALLAMMUALAIKUM%0A%0A%0A%0A<?php echo"NAMA SAYA : $a %0ANOMER HP SAYA : $b %0AALAMAT SAYA : $c %0A  %0A*::SAYA INGIN MEMESAN PRODUK DENGAN DETAIL SEBAGAI BERIKUT ::*%0A%0A";
              while($row = $query->fetch_assoc()){echo "%0A%0ANAMA PRODUK : ";echo $row['namaproduk'];echo "%0AHARGA PRODUK : ";echo number_format($row['hargaafter'], 2); echo "%0AJUMLAH PRODUK : "; echo $_SESSION['qty_array'][$index];echo "%0ATOTAL : ";
                     echo number_format($_SESSION['qty_array'][$index]*$row['hargaafter'], 2);  $total += $_SESSION['qty_array'][$index]*$row['hargaafter']; 
                $index ++;}?>
<?php echo "%0A%0A%0A%0ATOTAL KESELURUHAN : ";echo number_format($total); ?>">PESAN SEKARANG</a>
<?php
            }
            else{
              ?>
              <tr>
                <td colspan="4" class="text-center">No Item in Cart</td>
              </tr>
              <?php
            }

          ?>


            </div>
          </div>
<?php
} else {

 ?>   
           



<div class="card cart-amount-area">

    <div class="card-body">
              <form action="" method="post">
                
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-user"></i><span>NAMA LENGKAP</span></div>
                  <input class="form-control" type="text" name="nama"  required=>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-phone"></i><span>Nomor HP</span></div>
                  <input class="form-control" type="text" name="nomer"  required>
                </div>
                <div class="mb-3">
                  <div class="title mb-2"><i class="lni lni-map-marker"></i><span>Alamat Pengiriman</span></div>
                  <input class="form-control" type="text" name="alamat" required>
                </div>
                <button class="btn btn-success w-100" type="submit" name="gass">KONFIRMASI PESANAN</button>
              </form>
            </div>
<?php }?>
                 
              
    




     
      <!-- Weekly Best Sellers-->
  
      <!-- Discount Coupon Card-->
   
      <!-- Featured Products Wrapper-->
      
    </div>
    <!-- Internet Connection Status-->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Footer Nav-->
  <div class="footer-nav-area" style="background-color: #1A1423;" id="footerNav">
      <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
          <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
            <li><a href="./"><i class="lni lni-home"></i>PRODUK</a></li>
            <li><a href="keranjang.php"><i class="lni lni-shopping-basket"><span class="badge"><?php echo count($_SESSION['cart']); ?></span></i>KERANJANG</a></li>
            <li><a href="cara.php"><i class="fa fa-info"></i>TUTORIAL</a></li>
            <li><a href="tentang.php"><i class="lni lni-cog"></i>TENTANG KAMI</a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- All JavaScript Files-->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/default/jquery.passwordstrength.js"></script>
    <script src="js/default/dark-mode-switch.js"></script>
    <script src="js/default/no-internet.js"></script>
    <script src="js/default/active.js"></script>
    <script src="js/pwa.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>