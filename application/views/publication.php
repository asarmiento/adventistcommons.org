<div class="row justify-content-center">
	<div class="col-xl-10 col-lg-11">
		<div class="page-header clearfix">
			<img src="/uploads/<?php echo $publication["cover_image"]; ?>" width="140" class="float-left mr-3 rounded">
			<h1><?php echo $publication["name"]; ?></h1>
			<p class="lead">
				<?php echo $publication["description"]; ?>
				<br><span class="text-small"><strong>Author</strong>: <?php echo $publication["author"]; ?></span>
			</p>
		</div>
		<hr>
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
				</div>
			</div>
		</div>
	</div>
</div>