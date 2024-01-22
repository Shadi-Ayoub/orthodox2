<div id="modal-error" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header justify-content-center">
				<div class="icon-box">
				<i class="fa-solid fa-x"></i>
					<!-- <i class="material-icons">&#xE5CD;</i> -->
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body text-center">
				<h4>Ooops!</h4>	
				<p id="modal-error-message"><?= $message; ?></p>
				<button class="btn btn-success" data-dismiss="modal">Try Again</button>
			</div>
		</div>
	</div>
</div>     