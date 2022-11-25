$(document).ready(function() {
	$("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
		e.preventDefault();
		$(this).siblings('a.active').removeClass("active");
		$(this).addClass("active");
		var index = $(this).index();
		$("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
		$("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
	});
});

$(document).ready(function(){
	//  ADD buttons actions --> cashier,hubber,store --> START
    $('#add_button_cashier').click(function(){
        $('#cashier_form')[0].reset();
        $('#action').val("Επιβεβαιωση");
        $('#operation').val("Add");
	});

    $('#add_button_hubber').click(function(){
        $('#hubber_form')[0].reset();
        $('#action_hubber').val("Επιβεβαιωση");
        $('#operation_hubber').val("Add_hubber");
	});

	$('#add_button_store').click(function(){
        $('#store_form')[0].reset();
        $('#action_store').val("Επιβεβαιωση");
        $('#operation_store').val("Add_store");
	});
	//  ADD buttons actions --> cashier,hubber,store --> END

	//  Get Data from DB --> cashier,hubber,store --> START
	var cashiersTable = $('#cashiers_data').DataTable({
	    "processing":true,
	    "serverSide":true,
	    "order":[],
	    "ajax":{
	        url:"../php/cashiers_search.php",
	        type:"POST"
	    },
	    "columnDefs":[
	        {
	            "targets":[4,5,6,7,8,9,10],
	            "orderable":false,
	        },
	    ],
	});
	var hubbersTable = $('#hubbers_data').DataTable({
	    "processing":true,
	    "serverSide":true,
	    "order":[],
	    "ajax":{
	        url:"../php/hubbers_search.php",
	        type:"POST"
	    },
	    "columnDefs":[
	        {
	            "targets":[4,6,7,8,9,10],
	            "orderable":false,
	        },
	    ],
	});
	var storesTable = $('#stores_data').DataTable({
	    "processing":true,
	    "serverSide":true,
	    "order":[],
	    "ajax":{
	        url:"../php/stores_search.php",
	        type:"POST"
	    },
	    "columnDefs":[
	        {
	            "targets":[2, 3, 5, 6, 7, 9, 10],
	            "orderable":false,
	        },
	    ],

	});
	//  Get Data from DB --> cashier,hubber,store --> END


	// Submit button at ADD form action --> cashier,hubber,store START
	$(document).on('submit', '#cashier_form', function(event){
	    event.preventDefault();
	    var name = $('#name').val();
	    var surname = $('#surname').val();
	    var gender = $('#gender').val();
	    var age = $('#last_name').val();
	    var working_store = $('#working_store').val();
	    var username = $('#username').val();
	    var password = $('#password').val();
	       
	    if(name != '' && surname != '' && gender != '' && age != '' && working_store != '' && username != '' && password != '')
	    {
	        $.ajax({
	            url:"../php/insert_cashier.php",
	            method:'POST',
	            data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data)
	            {
	                $('#cashier_form')[0].reset();
	                $('#cashierModal').modal('hide');
	                cashiersTable.ajax.reload();
	                alert(data);
	            }
	        });
	    }
	    else
	    {
	        alert("Πρέπει να συμπληρώσεις όλα τα πεδία.");
	    }
	});

	$(document).on('submit', '#hubber_form', function(event){
	    event.preventDefault();
	    var name = $('#name_hubber').val();
	    var surname = $('#surname_hubber').val();
	    var gender = $('#gender_hubber').val();
	    var age = $('#last_name_hubber').val();
	    var working_hub = $('#working_hub_hubber').val();
	    var username = $('#username_hubber').val();
	    var password = $('#password_hubber').val();

	       
	    if(name != '' && surname != '' && gender != '' && age != '' && working_hub != '' && username != '' && password != '')
	    {
	        $.ajax({
	            url:"../php/insert_hubber.php",
	            method:'POST',
	            data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data)
	            {
	                $('#hubber_form')[0].reset();
	                $('#hubberModal').modal('hide');
	                hubbersTable.ajax.reload();
	                alert(data);
	            }
	        });
	    }
	    else
	    {
	        alert("Πρέπει να συμπληρώσεις όλα τα πεδία.");
	    }
	});

	$(document).on('submit', '#store_form', function(event){
	    event.preventDefault();
	    var city = $('#city').val();
	    var route = $('#route').val();
	    var route_number = $('#route_number').val();
	    var TK = $('#TK').val();
	    var phone_number = $('#phone_number').val();
	    var geo_x = $('#geo_x').val();
	    var geo_y = $('#geo_y').val();
	    var hub_id = $('#hub_id').val();

	       
	    if(city != '' && route != '' && route_number != '' && TK != '' && phone_number != '' && geo_x != '' && geo_y != '' && hub_id != '')
	    {
	        $.ajax({
	            url:"../php/insert_store.php",
	            method:'POST',
	            data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data)
	            {
	                $('#store_form')[0].reset();
	                $('#storeModal').modal('hide');
	                storesTable.ajax.reload();
	                alert(data);
	            }
	        });
	    }
	    else
	    {
	        alert("Πρέπει να συμπληρώσεις όλα τα πεδία.");
	    }
	});
	// Submit button at ADD form action --> cashier,hubber,store END


	// UPDATE buttons actions --> cashier,hubber,store START
	$(document).on('click', '.update_cashier', function(){
	    var emp_id = $(this).attr("id");
	    $.ajax({
	        url:"../php/fetch_single_cashier.php",
	        method:"POST",
	        data:{emp_id:emp_id},
	        dataType:"json",
	        success:function(data)
	        {
	            $('#cashierModal').modal('show');
	            $('#name').val(data.name);
	            $('#surname').val(data.surname);
	            $('#gender').val(data.gender);
	            $('#age').val(data.age);
	            $('#working_store').val(data.working_store);
	            $('#username').val(data.username);
	            $('#password').val(data.password);
	            $('.modal-title').text("Επεξεργασία Στοιχείων Υπαλλήλου Τοπικού Καταστήματος");
	            $('#emp_id').val(emp_id);
	            $('#action').val("Αποθηκευση");
	            $('#operation').val("Edit");
	            // alert(data);
	        }
	    })
	});

	$(document).on('click', '.update_hubber', function(){
	    var emp_id = $(this).attr("id");
	    $.ajax({
	        url:"../php/fetch_single_hubber.php",
	        method:"POST",
	        data:{emp_id:emp_id},
	        dataType:"json",
	        success:function(data)
	        {
	            $('#hubberModal').modal('show');
	            $('#name_hubber').val(data.name);
	            $('#surname_hubber').val(data.surname);
	            $('#gender_hubber').val(data.gender);
	            $('#age_hubber').val(data.age);
	            $('#working_hub_hubber').val(data.working_hub);
	            $('#username_hubber').val(data.username);
	            $('#password_hubber').val(data.password);
	            $('.modal-title').text("Επεξεργασία Στοιχείων Υπαλλήλου Κέντρου Διανομής");
	            $('#emp_id_hubber').val(emp_id);
	            $('#action_hubber').val("Αποθηκευση");
	            $('#operation_hubber').val("Edit_hubber");
	            // alert(data);
	        }
	    })
	});

	$(document).on('click', '.update_store', function(){
	    var store_id = $(this).attr("id");
	    $.ajax({
	        url:"../php/fetch_single_store.php",
	        method:"POST",
	        data:{store_id:store_id},
	        dataType:"json",
	        success:function(data)
	        {
	            $('#storeModal').modal('show');
	            $('#city').val(data.city);
	            $('#route').val(data.route);
	            $('#route_number').val(data.route_number);
	            $('#TK').val(data.TK);
	            $('#phone_number').val(data.phone_number);
	            $('#geo_x').val(data.geo_x);
	            $('#geo_y').val(data.geo_y);
	            $('#hub_id').val(data.hub_id);
	            $('.modal-title').text("Επεξεργασία Τοπικού Καταστήματος");
	            $('#store_id').val(store_id);
	            $('#action_store').val("Αποθηκευση");
	            $('#operation_store').val("Edit_store");
	            // alert(data);
	        }
	    });
	});
	// UPDATE buttons actions --> cashier,hubber,store END



	// DELETE buttons actions --> cashier,hubber,store START
	$(document).on('click', '.delete_cashier', function(){
	    var emp_id = $(this).attr("id");
	    if(confirm("Είσαι σίγουρος ότι θες να διαγράψεις αυτό τον υπάλληλο τοπικου καταστήματος;")){
	        $.ajax({
	            url:"../php/delete_cashier.php",
	            method:"POST",
	            data:{emp_id:emp_id},
	            success:function(data)
	            {
	                alert(data);
	                cashiersTable.ajax.reload();
	            }
	        });
	    }
	    else{
	        return false;   
	    }
	});


	$(document).on('click', '.delete_hubber', function(){
	    var emp_id = $(this).attr("id");
	    if(confirm("Είσαι σίγουρος ότι θες να διαγράψεις αυτό τον υπάλληλο κάντρου διανομής;")){
	        $.ajax({
	            url:"../php/delete_hubber.php",
	            method:"POST",
	            data:{emp_id:emp_id},
	            success:function(data)
	            {
	                alert(data);
	                hubbersTable.ajax.reload();
	            }
	        });
	    }
	    else{
	        return false;   
	    }
	});

	$(document).on('click', '.delete_store', function(){
	    var store_id = $(this).attr("id");
	    if(confirm("Είσαι σίγουρος ότι θες να διαγράψεις αυτό το κατάστημα;")){
	        $.ajax({
	            url:"../php/delete_store.php",
	            method:"POST",
	            data:{store_id:store_id},
	            success:function(data)
	            {
	                alert(data);
	                storesTable.ajax.reload();
	            }
	        });
	    }
	    else{
	        return false;   
	    }
	});
	// DELETE buttons actions --> cashier,hubber,store END


	//dropdown gia prosthiki topikou katastimatos
	$.ajax({
        url:"../php/get_city.php",
        success:function(data)
        {
            var items="";
			items += "<option>Διάλεξε Τοπικό Κατάστημα</option>";
			$.getJSON("../JSON/city_list.json",function(data){
				$.each(data,function(index,item) 
				{
					items+="<option value='"+item.store_id+"'>"+item.city+", "+item.route+" "+item.route_number+"</option>";
				});
				$("#working_store").html(items);
			});
        }
    });

	//dropdown gia prosthiki topikou katastimatos
	$.ajax({
        url:"../php/get_hub_city.php",
        success:function(data)
        {
            var items="";
			items += "<option>Διάλεξε Κέντρο Διανομής</option>";
			$.getJSON("../JSON/hub_list.json",function(data){
				$.each(data,function(index,item) 
				{
					items+="<option value='"+item.transit_id+"'>"+item.transit_city+", "+item.address+"</option>";
				});
				$("#working_hub_hubber").html(items);
			});

			var items2="";
			items2 += "<option>Διάλεξε Κέντρο Διανομής</option>";
			$.getJSON("../JSON/hub_list.json",function(data){
				$.each(data,function(index,item2) 
				{
					items2+="<option value='"+item2.transit_id+"'>"+item2.transit_city+", "+item2.address+"</option>";
				});
				$("#hub_id").html(items2);
			});
        }
    });

});