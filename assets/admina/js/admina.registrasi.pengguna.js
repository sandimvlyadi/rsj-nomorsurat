var table = '';

$('.li-master').addClass('menu-open');
$('.li-master .treeview-menu').css('display', 'block');
$('.li-registrasi-pengguna').addClass('active');

$(document).ready(function(){
	table = $('#dataTable').DataTable({
		'processing'	: true,
        'serverSide'	: true,

        'ajax' : {
        	'url'	: baseurl + 'registrasi-pengguna/datatable/',
            'type'	: 'GET',
            'dataSrc' : function(response){
            	var i = response.start;
            	var row = new Array();
            	if (response.result) {
            		for(var x in response.data){
	            		row.push({
	            			'no'        : i,
                            'nip'       : response.data[x].nip,
                            'email'     : response.data[x].email,
                            'password'  : response.data[x].password,
	            		});
	            		i = i + 1;
	            	}

	            	response.data = row;
            		return row;
            	} else{
            		response.draw = 0;
            		return [];
            	}
            }
        },

        'columns' : [
        	{ 'data' : 'no' },
            { 'data' : 'nip' },
            { 'data' : 'email' },
        	{ 'data' : 'password' }
        ],

        'order' 	: [[ 1, 'ASC' ]],

		'columnDefs': [
    		{
    			'orderable'	: false,
    			'targets'	: [ 0 ]
    		}
  		]
	});
});