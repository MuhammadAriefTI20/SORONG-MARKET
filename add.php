<?php
	session_start();

	//check if product is already in the cart
	if(!in_array($_GET['id'], $_SESSION['cart'])){
		array_push($_SESSION['cart'], $_GET['id']);
		$_SESSION['message'] = 'PRODUK DIMASUKAN KE KERANJANG';
	}
	else{
		$_SESSION['message'] = 'SUDAH ADA DIKERANJANG';
	}

	header('location:./');
?>