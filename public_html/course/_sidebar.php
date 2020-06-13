			<div id="sidebar" class="col-1-3">
				<div class="wrap-col">
					<div class="box">
						<div class="content">
							<?php echo $freearea_upper; ?>
						</div>
					</div>
					<div class="box">
						<div class="content">

						<div class="heading"><h2>コンテンツ</h2></div>
							<?php if(!empty($sidebars_data)): ?>
							<ul>
								<?php
								foreach($sidebars_data as $col):
									$public = $buildersObj->check_reg_date( $col['contents_public_date'] );
									if( ($col['contents_public'] || $col['side_titles_public']) && $public ):
										if(!empty($col['contents_title']))
											echo '<li><a href="./page.php?page='.$col['contents_id'].'">'.$col['contents_title'].'</a></li>';
										if(!empty($col['side_titles_title']))
											echo '<li style="list-style-type:none;margin-left:-20px;font-weight:bold;">'.$col['side_titles_title'].'</li>';
									endif;
								endforeach;
								?>
							</ul>
							<?php endif; ?>
						<div class="heading"><h2>Other</h2></div>
							<ul>
								<li><a href="<?php echo URL; ?>/contact.php">問い合わせフォーム</a></li>
								<li><a href="logout.php">ログアウト</a></li>
							</ul>
						</div>
					</div>
					<div class="box">
						<div class="content">
						<?php echo $freearea_lower; ?>
						</div>
					</div>
				</div>
			</div>
