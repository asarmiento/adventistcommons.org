<div class="row justify-content-center">
	<div class="col-xl-10 col-lg-11">
		<div class="page-header clearfix">
			<img src="/uploads/<?php echo $product["cover_image"]; ?>" width="140" class="float-left mr-3 rounded">
			<h2><?php echo $product["name"]; ?></h2>
			<p><?php echo $product["description"]; ?></p>
			<?php if( $product["type"] ) { ?>
				<span class="text-small pr-2"><strong>Type</strong>: <?php echo ucfirst( $product["type"] ); ?></span>
			<?php } ?>
			<?php if( $product["author"] ) { ?>
				<span class="text-small pr-2"><strong>Author</strong>: <?php echo $product["author"]; ?></span>
			<?php } ?>
			<?php if( $product["page_count"] ) { ?>
				<span class="text-small pr-2"><strong>Pages</strong>: <?php echo $product["page_count"]; ?></span>
			<?php } ?>
		</div>
		<hr>
		<ul class="nav nav-tabs nav-fill mb-3">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" href="#product-languages" role="tab">Languages</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="tab" href="#product-specs" role="tab">Specifications</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="product-languages" role="tabpanel">
				<div class="row content-list-head">
					<div class="col-auto">
						<h3>Languages</h3>
					</div>
				</div>
				<div class="content-list-body">
					<div class="card-list">
						<div class="card-list-body">
							<?php foreach( $languages as $language ) { ?>
								<div class="card card-task">
									<?php if( array_key_exists( "project", $language ) ) { ?>
										<div class="progress">
											<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $language["project"]["percent_complete"]; ?>%"></div>
										</div>
									<?php } ?>
									<div class="card-body">
										<div class="card-title">
											<h6 data-filter-by="text"><?php echo $language["language_name"]; ?></h6>
											<div class="d-flex align-items-center">
												<span><?php echo $language["project"]["status"] ?? ""; ?></span>
											</div>
										</div>
										<div class="card-meta">
											<?php if( array_key_exists( "attachments", $language ) ) { ?>
												<div class="dropdown">
													<button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
														Download
													</button>
													<div class="dropdown-menu">
														<?php foreach( $language["attachments"] as $attachment ) { ?>
															<a class="dropdown-item" href="/uploads/<?php echo $attachment["file"]; ?>"><?php echo $attachment["file_type"]; ?></a>
														<?php } ?>
													</div>
												</div>
											<?php } else { ?>
												<a href="/translate/section/<?php echo $language["project"]["status"]; ?>" class="btn btn-secondary">Start Translating</a>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
							<?php if( count( $languages ) < 1 ) { ?>
								<p>This product is not yet available in any languages.</p>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane fade" id="product-specs" role="tabpanel">
				<?php if( $product["type"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Product type</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["type"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["author"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Author(s)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["author"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["publisher"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Publisher</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["publisher"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["page_count"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Page count</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["page_count"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["audience"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Audience</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["audience"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["format_open"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Format (open)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["format_open"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["format_closed"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Format (closed)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["format_closed"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["cover_colors"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Colors (cover)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["cover_colors"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["interior_colors"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Colors (interior)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["interior_colors"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["cover_paper"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Paper (cover)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["cover_paper"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["interior_paper"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Paper (interior)</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["interior_paper"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["binding"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Binding</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["binding"] ); ?></dd>
					</dl>
				<?php } ?>
				<?php if( $product["finishing"] ) { ?>
					<dl class="row">
						<dt class="col-sm-4">Finishing</dt>
						<dd class="col-sm-8"><?php echo ucfirst( $product["finishing"] ); ?></dd>
					</dl>
				<?php } ?>
			</div>
		</div>
	</div>
</div>