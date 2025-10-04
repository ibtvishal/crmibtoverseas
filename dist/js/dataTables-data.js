/*DataTable Init*/

"use strict"; 

$(document).ready(function() {
	"use strict";	
	$('#datable_1').DataTable();
	$('#datable_3').DataTable({order: [[0, 'desc']]});
    $('#datable_2').DataTable({ "lengthChange": false});
} );