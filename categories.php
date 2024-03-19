<?php include("inc/connect.inc.php"); ?>
<?php
ob_start();
session_start();
if (!isset($_SESSION['user_login'])) {
    $user = "";
} else {
    $user = $_SESSION['user_login'];
    $result = mysqli_query($con, "SELECT * FROM user WHERE id='$user'");
    $get_user_email = mysqli_fetch_assoc($result);
    $uname_db = $get_user_email['firstName'];
}

if (!isset($_GET['cat'])) {
    header("Location: index.php");
} else {
    echo $cat = $_GET['cat'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $cat ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-CZFCXGTHXV"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-CZFCXGTHXV');
	</script>
</head>

<body>
    <?php include("inc/mainheader.inc.php"); ?>
    <div class="categolis">
        <table>
            <tr>
                <?php
                $getposts = mysqli_query($con, "SELECT * FROM category") or die(mysqlI_error($con));
                if (mysqli_num_rows($getposts)) {
                    while ($row = mysqli_fetch_assoc($getposts)) {
                        $cName = $row['cName'];
                        $display = $row['display'];
                        $color = ($cName == $cat) ? '#24bfae' : '#e6b7b8';
                        echo '
							<th>
								<a href="categories.php?cat=' . $cName . '" style="text-decoration: none;color: #040403;padding: 4px 12px;background-color: ' . $color . ';border-radius: 12px;">' . $display . '</a>
							</th>
						';
                    }
                }
                ?>
            </tr>
        </table>
    </div>
    <div style="padding: 15px 0px; font-size: 15px; margin: 0 auto; display: table; width: 98%;">
        <div>
            <?php
            echo $req = "SELECT * FROM products WHERE available >='1' AND item ='" . $cat . "'  ORDER BY id DESC LIMIT 10";
            $getposts = mysqli_query($con, $req) or die(mysqlI_error($con));
            if (mysqli_num_rows($getposts)) {
                echo '<ul id="recs">';
                while ($row = mysqli_fetch_assoc($getposts)) {
                    $id = $row['id'];
                    $pName = $row['pName'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $picture = $row['picture'];
                    $item = $row['item'];

                    echo '
							<ul style="float: left;">
								<li style="float: left; padding: 0px 25px 25px 25px;">
									<div class="home-prodlist-img"><a href="view_product.php?pid=' . $id . '">
										<img src="image/product/' . $item . '/' . $picture . '" class="home-prodlist-imgi" alt=' . $pName . '>
										</a>
										<div style="text-align: center; padding: 0 0 6px 0;"> <span style="font-size: 15px;">' . $pName . '</span><br> Price: ' . $price . ' Php</div>
									</div>
									
								</li>
							</ul>
						';
                }
            }
            ?>

        </div>
    </div>
</body>

</html>