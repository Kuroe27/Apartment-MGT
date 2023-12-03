<div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<center>
					<h4 class="modal-title" id="myModalLabel">
						<?php echo $modalTitle; ?>
					</h4>
				</center>
			</div>
			<div class="modal-body">
				<?php if(!empty($formFields)): ?>
					<div class="container-fluid">
						<form method="POST" action="<?php echo $formAction; ?>">
							<?php foreach($formFields as $field): ?>
								<div class="row">
									<div class="col-lg-2">
										<label class="control-label" style="position:relative; top:7px;">
											<?php echo $field['label']; ?>:
										</label>
									</div>
									<div class="col-lg-10">
										<?php
										$fieldValue = isset($field['value']) ? $field['value'] : '';
										if($field['type'] == 'textarea') {
											echo '<textarea class="form-control" name="'.$field['name'].'">'.$fieldValue.'</textarea>';
										} else {
											echo '<input type="'.$field['type'].'" class="form-control" name="'.$field['name'].'" value="'.$fieldValue.'">';
										}
										?>
									</div>
								</div>
								<div style="height:10px;"></div>
							<?php endforeach; ?>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								<button type="submit" name="<?php echo $submitBtnName; ?>" class="btn btn-primary">
									<?php echo $submitBtnText; ?>
								</button>
							</div>
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>