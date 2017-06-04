<?php
require "action.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP OOP Bootstrap & Inventory</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.css">


 <style type="text/css">
 	.table-borderless > tbody > tr > td,
 	.table-borderless > tbody > tr > th,
 	.table-borderless > tfoot > tr > td,
 	.table-borderless > tfoot > tr > th,
 	.table-borderless > thead > tr > td,
 	.table-borderless > thead > tr > th {
 	    border: none;
 	}
 </style>
</head>
<body>
	<div class="container">
		<div class="jumbotron">
			<h1 align="center">Inventory System</h1>
		</div

	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				
						<?php
							if(isset($_GET['update']))
							{
								/* PHP 5.6
								if(isset($_GET['id'])) {
									$id = $_GET['id'];
								}
								*/

								//PHP 7
								$id = $_GET['id'] ?? null;
								$where = array("id"=>$id);
								$row = $obj->select_products("products", $where);
						?>
				<div class="panel panel-warning">
					<div class="panel-heading">Update Product Details</div>
					<div class="panel-body">
						<form method="post" action="action.php">
							<table class="table table-hover table-borderless">
								<tr>
									<td>Product Name</td>
									<td>
										<input type="hidden" name="id" value=" <?php echo $id; ?>">
										<input type="text" class="form-control" name="product_name" placeholder="Enter Medicine Name" value="<?php echo $row['p_name'] ?>">
									</td>
								</tr>
								<tr>
									<td>Quantity</td>
									<td><input type="text" class="form-control" name="product_qty" placeholder="Enter Quantity" value="<?php echo $row['p_qty'] ?>"></td>
								</tr>
							</table>
							<input type="submit" class="btn btn-success" name="product_edit" value="Update">
						</form>
					</div>
					</div>
				</div>
						<?php
							}
							else
							{
							?>
				<div class="panel panel-warning">
					<div class="panel-heading">Product Details</div>
					<div class="panel-body">
								<form method="post" action="action.php">
									<table class="table table-hover table-borderless">
										<tr>
											<td>Product Name</td>
											<td>
												<input type="text" class="form-control" name="product_name" placeholder="Enter Medicine Name">
											</td>
										</tr>
										<tr>
											<td>Quantity</td>
											<td><input type="text" class="form-control" name="product_qty" placeholder="Enter Quantity"></td>
										</tr>
									</table>
									<input type="submit" class="btn btn-primary" name="product_submit" value="Add">
								</form>
					</div>
					</div>
				</div>
							<?php
							}
						?>
						
					
			<div class="col-md-8">
				<div class="panel panel-warning">
					<div class="panel-heading">Generated Product
					<?php
					$count = $obj->count_products("products");
					echo "<span style='float: right;'>Total: <span style='font-weight: 700; font-size: 18px;'>".$count[0]."</span></span>";
					?>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tr style="font-weight: 700;">
								<td align="center">#</td>
								<td align="center">Product Name</td>
								<td align="center">Quantity</td>
								<td align="center">&nbsp;</td>
								<td align="center">&nbsp;</td>
							</tr>
								<?php
								$products = $obj->fetch_products("products");
								foreach ($products as $row) 
								{
								?>
									<tr>
										<td align="center"><?php echo $row['id'];?></td>
										<td align="center"><?php echo $row['p_name'];?></td>
										<td align="center"><?php echo $row['p_qty'];?></td>
										<td colspan="1" align="center"><a href="index.php?update=1&id=
										<?php
										echo $row['id'];
										?>
										" class="btn btn-block btn-warning">Edit</a></td>
										<td colspan="1" align="center"><a href="action.php?delete=1&id=
										<?php
										echo $row['id'];
										?>
										" class="btn btn-block btn-danger">Delete</a></td>
									</tr>
								<?php
								}
								?>
							
						</table>
					</div>
				</div>
			</div> 
		</div>
	</div>
</body>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>