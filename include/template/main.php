<div class="panel-group">

	<!-- search_panel -->
	<div class="panel panel-default" style="overflow:visible">
		<div id="search_panel" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="row">
  				<div class="col-xs-5">
						<div class="input-group">
      				<div class="input-group-btn">
        				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
									<span id="searchtype">Equipment</span> <span class="caret"></span>
								</button>
        				<ul id="searchmenu" class="dropdown-menu">
          				<li><a href="#">Equipment</a></li>
						<li><a href="#">Users</a></li>
          				<li><a href="#">Purchases</a></li>
									<?php if ( $_SESSION['role'] > 1 ) : ?>
          					<li><a href="#">Software</a></li>
									<?php endif; ?>
        				</ul>
							</div><!-- btn-group -->
      				<input id="searchinput" type="text" class="form-control" placeholder="Search">
							<span class="input-group-btn">
        				<button id="executesearch" class="btn btn-primary" type="button">
									<i class="fa fa-search"></i>
								</button>
      				</span>
						</div><!-- input-group -->
						<span class="help-block">Select type of search and enter keywords</span>
						<p> For purchase dates, please use the following format: YYYY-MM-DD</p>
					</div><!-- col-xs-5 -->
				</div><!-- row -->
				<script>
					$("#searchmenu>li>a").on( 'click', function(){
	  					$( '#searchtype').html( $( this ).text() );
					});

					$( '#executesearch' ).on( 'click', function(){
						var choice = $( '#searchtype' ).text();
						if ( choice == 'Equipment' )
							list_equipment( $( '#searchinput' ).val() );
						if ( choice == 'Users' )
							list_users( $( '#searchinput' ).val() );
						if ( choice == 'Purchases' )
							list_purchases( $( '#searchinput' ).val() );
						if ( choice == 'Software' )
							list_software( $( '#searchinput' ).val() );
					});

				</script>
			</div><!-- panel-body -->
		</div><!-- #search_panel -->
	</div><!-- panel -->

	<!-- report_panel -->
	<div class="panel panel-default">
		<div id="report_panel" class="panel-collapse collapse">
			<div class="panel-body">
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</div>
		</div>
	</div>

	<!-- table_panel -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<div id="table_panel_head" class="row"></div>
		</div>
		<div id="table_panel" class="panel-collapse collapse">
			<div class="panel-body">
				<table id="results_table" class="tablesorter">
					<thead><tr></tr></thead>
					<tbody></tbody>
				</table>
			</div>
			<div id="pager" class="panel-footer pager" style="margin: 0px">
				<div class="row">
					<div class="col-xs-3"></div>
					<div class="col-xs-6">
						<div class="center-block">
							<div class="btn-group">
								<button class="btn btn-info first">
									<i class="fa fa-angle-double-left fa-lg"></i>
								</button>
								<button class="btn btn-info prev">
									<i class="fa fa-angle-left fa-lg"></i>
								</button>
								<button class="btn btn-info active pagedisplay">
								</button>
								<button class="btn btn-info next">
									<i class="fa fa-angle-right fa-lg"></i>
								</button>
								<button class="btn btn-info last">
									<i class="fa fa-angle-double-right fa-lg"></i>
								</button>
							</div>
						</div>
					</div><!-- col-xs-6 -->
					<div class="col-xs-3"><div class="pull-right" style="margin-top: 10px">
						Records per page
   					<select class="pagesize">
      				<option selected="selected" value="10">10</option>
      				<option value="15">15</option>
      				<option value="20">20</option>
      				<option value="9999">All</option>
    				</select>
					</div>
				</div>
			</div>
		</div>
	</div><!-- table_panel -->

</div><!-- panel-group -->

