<!--Data table-->
<script type="text/javascript" language="javascript" src="datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="datatable/js/dataTables.bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="datatable/js/dataTables.buttons.js"></script>
<script type="text/javascript" language="javascript" src="datatable/js/buttons.bootstrap.js"></script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="datatable/js/buttons.html5.js"></script>
<script type="text/javascript" language="javascript" src="datatable/js/buttons.print.js"></script>
<script type="text/javascript" language="javascript" src="datatable/js/buttons.colVis.js"></script>

<script type="text/javascript" language="javascript" class="init">
	
$(document).ready(function() {
    var table = $('#datatable').DataTable({
        "scrollX": true,
        
    });
 
    new $.fn.dataTable.Buttons( table, {
		buttons: [
			'colvis', 'copy', 'excel', 'pdf', 'print'
		]
    } );
 
    table.buttons( 0, null ).container().prependTo(
        table.table().container()
    );
} );

</script>
