$(document).ready(function(){
    $.ajaxSetup({ cache: false });
        
    $('#live_search').keyup(function(){

        $('#result').html('');
        $('#state').val('');
        var searchField = $('#live_search').val();
        if(isNaN(searchField) == false){ // αν εχει βαλει zipcode
            if(searchField.length == 5){ // περιπττωση σωστου πληθους ψηφιων zipcode
                $.ajax({
                    url : "http://maps.googleapis.com/maps/api/geocode/json?address=%27Greece%27&components=postal_code:"+searchField+"&sensor=false",
                    success:function(data)
                    {
                        if(data.status != "ZERO_RESULTS"){ // αν υπαρχει το 5ψηφιο zipcode
                            latitude  = data.results[0].geometry.location.lat;
                            longitude = data.results[0].geometry.location.lng;
                            $.ajax({
                                type: "POST",
                                url: "../php/filter_search.php",
                                data: {latitude: latitude ,longitude: longitude},
                                success: function(data)
                                {
                                    $.getJSON('../JSON/filter_zip_code.json', function(data){
                                        $('#result').append('<li class="list-group-item link-class">'+data['store_id']+'. '+data['city']+ ' | <span class="text-muted">'+data['route']+' '+data['route_number']+'</span></li>');  
                                    });

                                }
                            });    
                        }
                        
                    }
                });               
            }          
        }
        else{ // αν εχει βαλει ονομα πολης
            var expression = new RegExp(searchField, "i");
            $.getJSON('../JSON/stores_records.json', function(data)
            {
                $.each(data, function(key, value){
                    if (value.city.search(expression) != -1){
                        $('#result').append('<li class="list-group-item link-class">'+value.store_id+'. '+value.city+' | <span class="text-muted">'+value.route+' '+value.route_number+'</span></li>');
                    }
                });   
            });
        }
    });

    

    $('#result').on('click', 'li', function() {
        var click_text = $(this).text();
        
        $('#live_search').val(click_text[0].concat(click_text[1]));
        // alert(click_text[0]);
        // $('#live_search').val(click_text[1]);
        // alert(click_text[1]);
        var search_store_id = $('#live_search').val();        

        $('#live_search').val(click_text);
        $("#result").html('');

        $.ajax({
            url:"../php/get_geo_store.php",
            method:"POST",
            data:{search_store_id:search_store_id},
            success:function(data)
            {
                set_custom_center();
            }
        })

        //setTimeout(set_custom_center, 1000);
        
        function set_custom_center(){
            var kentro = [];
            $.getJSON('../JSON/geo_store.json', function(data) {  
                for(var i = data.length; i--; ){
                    for(var j = 0; j< Object.size(data[0]); j++){
                        kentro[i] = $.map(data[i],function(value,index){
                            return [value];
                       }); 
                    }
                }
                initMap(kentro);
            });
        }
        
        Object.size = function(obj) {
            var size = 0, key;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) size++;
            }
            return size;
        };

        function loadStores(map){
            $.getJSON('../JSON/stores_records.json', function(data) {
                var stores = [];
                for(var i = data.length; i--; ){
                    for(var j = 0; j< Object.size(data[0]); j++){
                        stores[i] = $.map(data[i],function(value,index){
                            return [value];
                       }); 
                    }
                }
                setMarkers(map, stores);  
            });
        }
        function initMap(kentro) {
            var map = new google.maps.Map(document.getElementById('map'), {
              // center: {lat: 38.002235, lng: 23.729095},
              center: {lat: parseFloat(kentro[0][0]), lng: parseFloat(kentro[0][1])},
              mapTypeId: google.maps.MapTypeId.ROADMAP,
              zoom: 17
            });
            // map.setCenter(new google.maps.LatLng( 38.002235 , 23.729095 );
            loadStores(map);
        }
  
        function setMarkers(map, all_the_stores){
            // console.log(all_the_stores);
            var size = Object.size(all_the_stores);
            var info = new google.maps.InfoWindow();
            
            for (var i = 0; i < size; i++) {
                var store = all_the_stores[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng( parseFloat(store[6]), parseFloat(store[7]) ),
                    map: map,
                    title: store[1] + "  "  + store[2] + "  "  + store[3],
                    animation: google.maps.Animation.DROP 
                });
                google.maps.event.addListener(marker, 'click', (function(marker,store){
                    return function(){
                        var content =
                            '<div><h4 style="text-align: center;">'+ store[1] + '</h4></div>' +
                            '<div><h5>Πληροφορίες</h5></div>' +
                            '<div>' +
                                '<p><b>Οδός:</b>&emsp;&emsp;&emsp;&emsp;'+ store[2] + "  " + store[3] +'<br>' +
                                '<b>ΤΚ:</b>&emsp;&emsp;&emsp;&emsp;&emsp;' + store[4] + '<br>' +
                                '<b>Tηλέφωνο:</b>&emsp; ' + store[5] + '<br>' +
                                '<b>e-mail:</b>&emsp;&emsp;&emsp;  info@fastmover<br>' + 
                                '<b>www:</b>&emsp;&emsp;&emsp;&emsp;www.fastmover.gr </p>' +
                            '</div>';
                        info.setContent(content);
                        info.open(map, marker);
                    }
                })(marker, store));
            }   
        }       
    });
});
