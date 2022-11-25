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
	//  ADD button action --> START
    $('#add_button_box').click(function(){
        $('#box_form')[0].reset();
        $('#action').val("ΟΛΟΚΛΗΡΩΣΗ");
        $('#operation').val("Add");
	});
	//  ADD button action --> END

	//  Get Data from DB --> START
	var boxesTable = $('#boxes_data').DataTable({
	    "processing":true,
	    "serverSide":true,
	    "order":[],
	    "ajax":{
	        url:"../php/boxes_search.php",
	        type:"POST"
	    },
	    "columnDefs":[
	        {
	            "targets":[0,2,3,4,5,6,7,8,9,10,11],
	            "orderable":false,
	        },
	    ],
	});
	//  Get Data from DB --> END

	// Submit button at ADD form action --> START
	$(document).on('submit', '#box_form', function(event){
	    event.preventDefault();
	    var name_sender = $('#name_sender').val();
	    var name_receiver = $('#name_receiver').val();
	    var route_receiver = $('#route_receiver').val();
	    var destination_store = $('#destination_store').val();
	       
	    if(name_sender != '' && name_receiver != '' && route_receiver != '' && destination_store != '')
	    {
	        $.ajax({
	            url:"../php/insert_box.php",
	            method:'POST',
	            data:new FormData(this),
	            contentType:false,
	            processData:false,
	            success:function(data)
	            {
	                $('#box_form')[0].reset();
	                $('#boxModal').modal('hide');
	                boxesTable.ajax.reload();
	                alert(data);	             
	            }
	        });
	    }
	    else
	    {
	        alert("Πρέπει να συμπληρώσεις όλα τα πεδία.");
	    }
	});
	// Submit button at ADD form action --> END


	// INFO button actions -->  START

	$(document).on('click', '.more_info', function(){
	    var box_id = $(this).attr("id");
	    $.ajax({
	        url:"../php/fetch_single_box.php",
	        method:"POST",
	        data:{box_id:box_id},
	        dataType:"json",
	        success:function(data)
	        {
	            $('#boxModal2').modal('show');
	            $('.modal-title').text("Περαιτέρω Πληροφορίες Παραγγελίας");
	            $('#box_id').val(box_id);
	            $('#operation').val("Edit");
	            var imgName = "../QR/qr_codes/"+box_id+".png";
				$("#QRImg").attr("src",imgName);
				$('#afetiria').val(data.start_city);
				$('#proorismos').val(data.final_city);
	        }
	    });
	    $(document).ready(function(){
			load_data();
			function load_data(query)
			{
				$.ajax({
					url:"../php/get_box_history.php",
					method:"POST",
					data:{box_id:box_id},
					success:function(data)
					{
						$('#hub_schedule_list').html(data);
					}
				});
			}
		});
	});
	// INFO buttons actions --> END


	// DELETE button action --> START
	$(document).on('click', '.delete_box', function(){
	    var box_id = $(this).attr("id");
	    if(confirm("Είσαι σίγουρος ότι θες να διαγράψεις τη συγκεκριμένη παραγγελία;")){
	        $.ajax({
	            url:"../php/delete_box.php",
	            method:"POST",
	            data:{box_id:box_id},
	            success:function(data)
	            {
	                alert(data);
	                boxesTable.ajax.reload();
	            }
	        });
	    }
	    else{
	        return false;   
	    }
	});
	// DELETE button action --> END

	//dropdown katastimatos afetirias
	$.ajax({
        url:"../php/get_city.php",
        success:function(data)
        {
            var items="";
			items += "<option>Διάλεξε Προορισμό</option>";
			$.getJSON("../JSON/city_list.json",function(data){
				$.each(data,function(index,item) 
				{
					items+="<option value='"+item.store_id+"'>"+item.city+", "+item.route+" "+item.route_number+"</option>";
				});
				$("#destination_store").html(items);
			});
        }
    });
        
});


