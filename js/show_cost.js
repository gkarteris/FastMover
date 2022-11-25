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
	$(document).on('submit', '#box_cost_form', function(event){
	    event.preventDefault();

	    //dimiourgia pinaka kostous
        $.ajax({
            url:"../php/get_box_cost.php",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {
                $('#box_cost_form')[0].reset();
                console.log(data);
		        load_data();
		        function load_data(query)
		        {
		            $.ajax({
		                url:"../php/table.php",
		                success:function(data)
		                {
		                    $('#returned_cost').html(data);
		                }
		            });
		        }
            }
        });
	});

	//dropdown katastimatos afetirias
	$.ajax({
        url:"../php/get_city.php",
        success:function(data)
        {
            var items="";
			items += "<option> Διάλεξε Αφετηρία </option>";
			$.getJSON("../JSON/city_list.json",function(data){
				$.each(data,function(index,item) 
				{
					items+="<option value='"+item.store_id+"'>"+item.city+", "+item.route+" "+item.route_number+"</option>";
				});
				$("#starting_store_id").html(items);
			});
        }
    });

	//dropdown katastimatos proorismou
	$.ajax({
        url:"../php/get_city.php",
        success:function(data)
        {
            var items="";
			items += "<option> Διάλεξε Προορισμό </option>";
			$.getJSON("../JSON/city_list.json",function(data){
				$.each(data,function(index,item) 
				{
					items+="<option value='"+item.store_id+"'>"+item.city+", "+item.route+" "+item.route_number+"</option>";
				});
				$("#final_store_id").html(items);
			});
        }
    });
    
});