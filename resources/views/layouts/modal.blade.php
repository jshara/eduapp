<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"></h4>
				<button type="button" class="fa fa-close" style="color:red;" data-dismiss="modal"></button>					
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="control-label col-sm-2" for="id">ID:</label>
						<div class="col-sm-10">
							<input class="form-control" id="fid" disabled="" type="text">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-2" for="name">Name:</label>
						<div class="col-sm-10">
							<input class="form-control" id="n" type="name">
						</div>
					</div>
				</form>
				<div class="deleteContent">
					Are you Sure you want to delete <span class="dname"></span> ?  
					<span class="hidden did" style="visibility:hidden;"></span>
					<span class="hidden lid" style="visibility:hidden;"></span>
					<span class="hidden cid" style="visibility:hidden;"></span>
					<span class="hidden lnum" style="visibility:hidden;"></span>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn actionBtn" data-dismiss="modal">
						<span id="footer_action_button" class="glyphicon"> </span>
					</button>
					<button type="button" class="btn btn-warning" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove"></span> Close
					</button>
				</div>
			</div>
		</div>
	</div>
</div>