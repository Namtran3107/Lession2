<?php 
include "include/database.php";
include "include/categories.php";

$database = new database();
$db = $database->connect();
$category = new categories($db);


if($_SERVER['REQUEST_METHOD'] == 'POST'){
	IF($_REQUEST['frm'] == 'add'){
		$category->category_name = $_REQUEST['category_name'];
		if(empty($_REQUEST['parent_id'])){
			$category->parent_id = "parentfirst";
		}else {
			$category->parent_id = $_REQUEST['parent_id'];
		}
		if($category->add()){
		}
		header('Location: index.php');
	}
	IF($_REQUEST['frm'] == 'update'){
		$category->id = $_REQUEST['id'];
		$category->read();
		$category->category_name = $_REQUEST['category_name'];
		$category->parent_id =  $_REQUEST['parent_id'];
		if($category->update()){
		}
		header('Location: index.php');
	}
	IF($_REQUEST['frm'] == 'delete'){
		$category->id = $_REQUEST['id'];
		$category->read();
		if($category->delete()){
		}
		header('Location: index.php');
	}
	// Hàm kiểm tra IF
	IF ($_REQUEST['frm'] == 'btnsearch') {
		$category_name = $_REQUEST['search'];
		$search_results = $category->search($category_name);
	}

	
}

$stmt = $category->read_all();

$cate = $category->read_all();


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
	<link rel="stylesheet" href="./themify-icons-font/themify-icons/themify-icons.css">
	<link rel="stylesheet" href="./index.css">
	<title>Document</title>
</head>
<body>
	<div id="body-all">
		<div class="body">
			<div class="body-all-header">
				<div class="header-list-title">
					<button type="button" class="btn btn-light">Product</button>
					<button type="button" class="btn btn-primary">Categories</button>
				</div>
				<div class="header-item-image">
					<a href="index.php"><img src="img/logo-lampart.png" alt=""></a>
				</div>
			</div>
			<div class="body-all-list">
				<div class="body-all-listss">
					<div class="body-search">
						<form action="index.php" method="POST">
							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Serach here" aria-label="Recipient's username" aria-describedby="basic-addon2" name="search" value="">
								<div class="input-group-append">
									<input type="hidden" name="frm" value="btnsearch">
									<button type="submit" class="input-group-text" id="basic-addon2">Serach</span>
									</div>
								</div>
							</div>
						</form>
						<div class="body-add-new">
							<div class="add-new-title">Search found <span class = "return-search">0</span> results</div>
							<button class="icon-add-new-item btn" data-toggle="modal" data-target="#modal-add"><div class="ti-plus"></div></button>

							<!-- ADD thêm giá trị vào  -->
							<!-- Modal add -->
							<div class="modal fade" id="modal-add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Add new Category</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<form action="index.php" method="POST">
											<div class="modal-body">
												<div class="modal-body-list">
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon3">Category Name</span>
														</div>
														<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name">
													</div>
												</div>
												<div class="moda-body-item">
													<h1>Parent Category</h1>

													<select name="parent_id">
														<option value="parentfirst"></option>
														<?php 
														$nu = 1;
														while($row = $cate->fetch()){
															if($row['parent_id'] == "parentfirst"){
																?>
																<option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
																<?php 
															}
															$nu++;
														}
														?>
													</select>
												</div>
											</div>
											<div class="modal-footer">
												<input type="hidden" name="frm" value="add">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
												<button type="submit" class="btn btn-primary">Save changes</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- End modal -->


						</div>
						<div class="body-categories-all">
							<div class="category-list-header">
								<div class="category-item-header">
									<div class="category-null">#</div>
									<div class="category-name-header">Category name</div>
									<div class="category-operations-header">Operations</div>
								</div>
							</div>
							<!-- Sử dụng vòng lặp để gán vào mảng -->
							<?php 
							$categories = [];
							while ($row = $stmt->fetch()) {
								$categories[] = $row;
							}
							$num = 1;
							?>
							<!-- Sử dụng if để ra 2 trường hợp -->
							<!-- Nếu tìm kiếm sẽ in ra mảng tìm kiếm -->
							<!-- Trường hợp 2 là in ra tất cả các giá trị trong database -->
							<?php
							if (!empty($search_results)){
								
								foreach ($search_results as $row){
									?>
									<div class="category-list-body" style="display: none;">
										<div class="category-item-body">
											<div class="category-number"><?php echo $num; ?></div>
											<div class="category-name-body"><?php echo $row['category_name']; ?></div>
											<div class="category-operations-body">
												<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-fix".$row['id']; ?>"><div class="ti-eraser"></div></button>
												<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-ss".$row['id']; ?>"><div class="ti-files"></div></button>
												<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-del".$row['id']; ?>"><div class="ti-trash"></div></button>
												<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-ct".$row['id']; ?>"><div class="ti-fullscreen"></div></button>
											</div>
										</div>
									</div>
									<!-- Modal Fix -->
									<div class="modal fade" id="<?php echo "modal-fix".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Modal Fix</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="index.php" method="POST">
													<div class="modal-body">
														<div class="modal-body-list">
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<span class="input-group-text" id="basic-addon3">Category Name</span>
																</div>
																<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name" value="<?php echo $row['category_name'] ?>">
																<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
																<input type="hidden" name="parent_id" value="<?php echo $row['parent_id'] ?>">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="frm" value="update">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save changes</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- End modal -->

									<!-- Modal SS -->
									<div class="modal fade" id="<?php echo "modal-ss".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Modal Copy</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="index.php" method="POST">
													<div class="modal-body">
														<div class="modal-body-list">
															<div class="input-group mb-3">
																<h1>Bạn có chắc chắn muốn sao chép</h1>
																<input type="hidden" name="category_name" value="<?php echo $row['category_name'] ?>">
																<input type="hidden" name="parent_id" value="<?php echo $row['parent_id'] ?>">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="frm" value="add">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save changes</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- End modal -->

									<!-- Modal Delete -->
									<div class="modal fade" id="<?php echo "modal-del".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Modal Delete</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="index.php" method="POST">
													<div class="modal-body">
														<div class="modal-body-list">
															<div class="input-group mb-3">
																<h1>Bạn có chắc chắn muốn xoá</h1>
																<input type="hidden" name="id" value="<?php echo $idss; ?>">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="frm" value="delete">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary">Save changes</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- End modal -->

									<!-- Modal CHi tiet -->
									<div class="modal fade" id="<?php echo "modal-ct".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Modal Detail</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="index.php" method="POST">
													<div class="modal-body">
														<div class="modal-body-list">
															<div class="input-group mb-3">
																<div class="input-group-prepend">
																	<span class="input-group-text" id="basic-addon3">Category Name</span>
																</div>
																<input type="text" readonly class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name" value="<?php echo $row['category_name'] ?>">
															</div>
														</div>
													</div>
													<div class="modal-footer">
														<input type="hidden" name="frm" value="update">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
													</div>
												</form>
											</div>
										</div>
									</div>
									<!-- End modal -->
									<?php 
									$num++;
								}
								?>
								<?php
							} else{
								foreach ($categories as $row){
									if($row['parent_id'] == 'parentfirst'){
										$idss = $row['id'];
										?>
										<div class="category-list-body" style="display: none;">
											<div class="category-item-body">
												<div class="category-number"><?php echo $num; ?></div>
												<div class="category-name-body"><?php echo $row['category_name']; ?></div>
												<div class="category-operations-body">
													<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-fix".$row['id']; ?>"><div class="ti-eraser"></div></button>
													<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-ss".$row['id']; ?>"><div class="ti-files"></div></button>
													<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-del".$row['id']; ?>"><div class="ti-trash"></div></button>
													<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-ct".$row['id']; ?>"><div class="ti-fullscreen"></div></button>
												</div>
											</div>
										</div>
										<!-- Modal Fix -->
										<div class="modal fade" id="<?php echo "modal-fix".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Modal Fix</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action="index.php" method="POST">
														<div class="modal-body">
															<div class="modal-body-list">
																<div class="input-group mb-3">
																	<div class="input-group-prepend">
																		<span class="input-group-text" id="basic-addon3">Category Name</span>
																	</div>
																	<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name" value="<?php echo $row['category_name'] ?>">
																	<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
																	<input type="hidden" name="parent_id" value="<?php echo $row['parent_id'] ?>">
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="frm" value="update">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										<!-- End modal -->

										<!-- Modal SS -->
										<div class="modal fade" id="<?php echo "modal-ss".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Modal Copy</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action="index.php" method="POST">
														<div class="modal-body">
															<div class="modal-body-list">
																<div class="input-group mb-3">
																	<h1>Bạn có chắc chắn muốn sao chép</h1>
																	<input type="hidden" name="category_name" value="<?php echo $row['category_name'] ?>">
																	<input type="hidden" name="parent_id" value="<?php echo $row['parent_id'] ?>">
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="frm" value="add">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										<!-- End modal -->

										<!-- Modal Delete -->
										<div class="modal fade" id="<?php echo "modal-del".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Modal Delete</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action="index.php" method="POST">
														<div class="modal-body">
															<div class="modal-body-list">
																<div class="input-group mb-3">
																	<h1>Bạn có chắc chắn muốn xoá</h1>
																	<input type="hidden" name="id" value="<?php echo $idss; ?>">
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="frm" value="delete">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-primary">Save changes</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										<!-- End modal -->

										<!-- Modal CHi tiet -->
										<div class="modal fade" id="<?php echo "modal-ct".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Modal Detail</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action="index.php" method="POST">
														<div class="modal-body">
															<div class="modal-body-list">
																<div class="input-group mb-3">
																	<div class="input-group-prepend">
																		<span class="input-group-text" id="basic-addon3">Category Name</span>
																	</div>
																	<input type="text" readonly class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name" value="<?php echo $row['category_name'] ?>">
																</div>
															</div>
														</div>
														<div class="modal-footer">
															<input type="hidden" name="frm" value="update">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										<!-- End modal -->
										<!-- Sử dụng vòng lặp để tìm những item có quan hệ parent-child  -->
										<?php 
										$mrleft = 1;
										foreach ($categories as $row){
											if($row['parent_id'] == $idss){
												$num++;
												?>
												<div class="category-list-body" style="display: none;">
													<div class="category-item-body">
														<div class="category-number"><?php echo $num; ?></div>
														<div class="category-name-body"><span style="margin-left: <?php echo 20*$mrleft.'px' ?>;">|__</span><?php echo $row['category_name'] ?></div>
														<div class="category-operations-body">
															<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-fix".$row['id']; ?>"><div class="ti-eraser"></div></button>
															<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-ss".$row['id']; ?>"><div class="ti-files"></div></button>
															<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-del".$row['id']; ?>"><div class="ti-trash"></div></button>
															<button class="btn" data-toggle="modal" data-target="<?php echo "#modal-ct".$row['id']; ?>"><div class="ti-fullscreen"></div></button>
														</div>
													</div>
												</div>
												<!-- Modal Delete -->
												<div class="modal fade" id="<?php echo "modal-del".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Modal Delete</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<form action="index.php" method="POST">
																<div class="modal-body">
																	<div class="modal-body-list">
																		<div class="input-group mb-3">
																			<h1>Bạn có chắc chắn muốn xoá</h1>
																			<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="frm" value="delete">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																	<button type="submit" class="btn btn-primary">Save changes</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- End modal -->

												<!-- Modal SS -->
												<div class="modal fade" id="<?php echo "modal-ss".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Modal Copy</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<form action="index.php" method="POST">
																<div class="modal-body">
																	<div class="modal-body-list">
																		<div class="input-group mb-3">
																			<h1>Bạn có chắc chắn muốn sao chép</h1>
																			<input type="hidden" name="category_name" value="<?php echo $row['category_name'] ?>">
																			<input type="hidden" name="parent_id" value="<?php echo $row['parent_id'] ?>">
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="frm" value="add">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																	<button type="submit" class="btn btn-primary">Save changes</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- End modal -->

												<!-- Modal Fix -->
												<div class="modal fade" id="<?php echo "modal-fix".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Modal Fix</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<form action="index.php" method="POST">
																<div class="modal-body">
																	<div class="modal-body-list">
																		<div class="input-group mb-3">
																			<div class="input-group-prepend">
																				<span class="input-group-text" id="basic-addon3">Category Name</span>
																			</div>
																			<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name" value="<?php echo $row['category_name'] ?>">
																			<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
																			<input type="hidden" name="parent_id" value="<?php echo $row['parent_id'] ?>">
																		</div>
																	</div>
																	<div class="moda-body-item">
																		<h1>Parent Category</h1>

																		<select name="parent_id">
																			<?php 
																			foreach($categories as $row){
																				if($row['parent_id'] == "parentfirst"){
																					?>
																					<option value="<?php echo $row['id']; ?>" <?php if($idss == $row['id']){echo "selected";} ?>><?php echo $row['category_name']; ?></option>
																					<?php 
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="frm" value="update">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																	<button type="submit" class="btn btn-primary">Save changes</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- End modal -->
												<!-- Modal CHi tiet -->
												<div class="modal fade" id="<?php echo "modal-ct".$row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h5 class="modal-title" id="exampleModalLabel">Modal Detail</h5>
																<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</div>
															<form action="index.php" method="POST">
																<div class="modal-body">
																	<div class="modal-body-list">
																		<div class="input-group mb-3">
																			<div class="input-group-prepend">
																				<span class="input-group-text" id="basic-addon3">Category Name</span>
																			</div>
																			<input type="text" readonly class="form-control" id="basic-url" aria-describedby="basic-addon3" name="category_name" value="<?php echo $row['category_name'] ?>">
																		</div>
																	</div>
																	<div class="moda-body-item">
																		<h1>Parent Category</h1>

																		<select name="parent_id" disabled>
																			<?php 
																			foreach($categories as $row){
																				if($row['parent_id'] == "parentfirst"){
																					?>
																					<option value="<?php echo $row['id']; ?>" <?php if($idss == $row['id']){echo "selected";} ?>><?php echo $row['category_name']; ?></option>
																					<?php 
																				}
																			}
																			?>
																		</select>
																	</div>
																</div>
																<div class="modal-footer">
																	<input type="hidden" name="frm" value="update">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
																</div>
															</form>
														</div>
													</div>
												</div>
												<!-- End modal -->
												<?php 
												$mrleft++;
											}
										}
										?>
										<?php 
										$num++;
									}
								}
							}
							?>

						</div>
					</div>
				</div>
				<!-- Kiểm tra tên miền để xác được trang hiện tại và có thể sang trang hoặc lùi -->
				<div class="footer-all-list">
					<div class="footer-item-list">
						<a href="<?php if(isset($_GET['page'])){
							if($_GET['page']==1){
								$pre = 1;
							}else{
								$pre = $_GET['page'] - 1;
							}
						}else{
							$pre = 1;
						} echo "index.php?page=".$pre; ?>" class="footer-pre">Previous</a>
						<!-- sử dụng vòng lặp để in ra số mục tương ứng với số phần tử -->
						<?php 
						$number_page = count($categories);
						$total_page = round(($number_page / 10) + 0.3);
						for ($i = 1; $i <= $total_page; $i++) {
							?>
							<a href="<?php echo "index.php?page=".$i; ?>" class="footer-number"><?php echo $i; ?></a>
							<?php 
						}
						?>
						<a href="<?php if(isset($_GET['page'])){
							if($_GET['page']== $total_page){
								$next = $total_page;
							}else{
								$next = $_GET['page'] + 1;
							}
						}else{
							$next = 2;
						} echo "index.php?page=".$next; ?>" class="footer-next">Next</a>
					</div>
				</div>
			</div>

		</div>


		<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
		<script src="./index.js"></script>
	</body>
	</html>
