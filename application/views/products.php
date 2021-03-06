<div class="container">
	<div class="row justify-content-center">
		<div class="col-xl-10 col-lg-11">
			<div class="page-header d-flex justify-content-between align-items-center">
				<h1>Products</h1>
				<?php if( $this->ion_auth->is_admin() ) { ?>
					<button class="btn btn-primary d-flex" data-toggle="modal" data-target="#add-product-form">Add Product</button>
				<?php } ?>
			</div>
			<hr>
			<div class="content-list">
				<div class="content-list-body row">
					<?php foreach( $products as $product ) { ?>
						<div class="col-md-6">
							<div class="card card-project">
								<div class="row no-gutters">
									<div class="col" style="flex: 0 0 120px">
										<img src="/uploads/<?php echo $product["cover_image"]; ?>" height="180" class="rounded-left">
									</div>
									<div class="col">
										<div class="card-body">
											<div class="card-title">
												<a href="/products/<?php echo $product["id"]; ?>">
													<h5 data-filter-by="text"><?php echo $product["name"]; ?></h5>
												</a>
											</div>
											<div class="card-meta d-flex justify-content-between">
												<div class="">
													<span class="text-small">Author: <?php echo $product["author"]; ?></span><br>
													<span class="text-small">Pages: <?php echo $product["page_count"]; ?></span><br>
													<span class="text-small">Languages: <?php echo $product["languages"]; ?></span><br>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php if( $this->ion_auth->is_admin() ) { ?>
<form class="modal fade auto-submit" action="/products/save" id="add-product-form" tabindex="-1" role="dialog" enctype="multipart/form-data">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Product</h5>
				<button type="button" class="close btn btn-round" data-dismiss="modal">
					<i class="material-icons">close</i>
				</button>
			</div>
			<ul class="nav nav-tabs nav-fill">
				<li class="nav-item">
					<a class="nav-link active" id="product-add-details-tab" data-toggle="tab" href="#product-add-details" role="tab">General</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="product-add-specs-tab" data-toggle="tab" href="#product-add-specs" role="tab">Specifications</a>
				</li>
			</ul>
			<div class="modal-body">
				<div class="tab-content">
					<div class="tab-pane fade show active" id="product-add-details" role="tabpanel">
						<div class="form-group row align-items-center">
							<label class="col-3">Title</label>
							<input class="form-control col" type="text" name="name" />
						</div>
						<div class="form-group row align-items-https://goo.gl/maps/Dx2ztuHkeXQ2center">
							<label class="col-3">Author(s)</label>
							<input class="form-control col" type="text" name="author" />
						</div>
						<div class="form-group row align-items-center">
							<label class="col-3">Publisher</label>
							<input class="form-control col" type="text" name="publisher" />
						</div>
						<div class="form-group row align-items-center">
							<label class="col-3">Publisher website</label>
							<input class="form-control col" type="text" name="publisher_website" />
						</div>
						<div class="form-group row">
							<label class="col-3">Description</label>
							<textarea class="form-control col" rows="3" name="description"></textarea>
						</div>
						<div class="form-group row align-items-center">
							<label class="col-3">Audience</label>
							<select class="form-control col" name="audience">
								<?php foreach( $audience_options as $item ) {
									echo "<option>$item</option>";
								} ?>
							</select>
						</div>
						<div class="form-group row align-items-center">
							<label class="col-3">Page count</label>
							<input class="form-control col" type="number" name="page_count" />
						</div>
						<div class="form-group row align-items-center">
							<label class="col-3">Series</label>
							<select class="series-select col" name="series_id" data-placeholder="Search for a series...">
								<option value="">None</option>
								<?php foreach( $series as $item ) { ?>
									<option value="<?php echo $item["id"]; ?>"><?php echo $item["name"]; ?></option>
								<?php } ?>
							</select>
						</div>
						<hr>
						<h6>Product type</h6>
						<div class="row">
							<?php foreach( $product_types as $type ) { ?>
								<div class="col">
									<div class="custom-control custom-radio">
										<input type="radio" id="type-<?php echo $type; ?>" name="type" class="custom-control-input" value="<?php echo $type; ?>">
										<label class="custom-control-label" for="type-<?php echo $type; ?>"><?php echo ucfirst( $type ); ?></label>
									</div>
								</div>
							<?php } ?>
						</div>
						<hr>
						<h6>Cover Image</h6>
						<div class="input-group mb-3">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="cover_image" name="cover_image">
								<label class="custom-file-label" for="cover_image">Choose file</label>
							</div>
						</div>
						<hr>
						<h6>InDesign Translation File (.xliff)</h6>
						<div class="input-group mb-3">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="xliff_file" name="xliff_file">
								<label class="custom-file-label" for="xliff_file">Choose file</label>
							</div>
						</div>
						<hr>
					</div>
					<div class="tab-pane fade" id="product-add-specs" role="tabpanel">
						<h6>Format</h6>
						<div class="row">
							<div class="col">
								<div class="form-group row align-items-center">
									<label class="col-4">Open</label>
									<input class="form-control col" type="text" name="format_open" placeholder="e.g. 10.4 x 20.5 cm" />
								</div>
							</div>
							<div class="col">
								<div class="form-group row align-items-center">
									<label class="col-4">Closed</label>
									<input class="form-control col" type="text" name="format_closed" placeholder="e.g. 10.4 x 41 cm" />
								</div>
							</div>
						</div>
						<hr>
						<h6>Cover</h6>
						<div class="row">
							<div class="col">
								<div class="form-group row align-items-center">
									<label class="col-4">Colors</label>
									<input class="form-control col" type="text" name="cover_colors" />
								</div>
							</div>
							<div class="col">
								<div class="form-group row align-items-center">
									<label class="col-4">Paper</label>
									<input class="form-control col" type="text" name="cover_paper" />
								</div>
							</div>
						</div>
						<hr>
						<h6>Interior</h6>
						<div class="row">
							<div class="col">
								<div class="form-group row align-items-center">
									<label class="col-4">Colors</label>
									<input class="form-control col" type="text" name="interior_colors" />
								</div>
							</div>
							<div class="col">
								<div class="form-group row align-items-center">
									<label class="col-4">Paper</label>
									<input class="form-control col" type="text" name="interior_paper" />
								</div>
							</div>
						</div>
						<hr>
						<div class="form-group row align-items-center">
							<label class="col-3">Binding</label>
							<select class="form-control col" name="binding">
								<?php foreach( $product_binding as $item ) {
									echo "<option>$item</option>";
								} ?>
							</select>
						</div>
						<div class="form-group row align-items-center">
							<label class="col-3">Finishing</label>
							<input class="form-control col" type="text" name="finishing" />
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button role="button" class="btn btn-primary" type="submit">
					Create Product
				</button>
			</div>
		</div>
	</div>
</form>
<?php } ?>