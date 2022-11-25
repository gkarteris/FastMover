$(document).ready(function(){
    $.ajaxSetup({ cache: false });
    $('#live_search').keyup(function(){
        $('#result').html('');
        $('#state').val('');
        var searchField = $('#live_search').val();
        var expression = new RegExp(searchField, "i");

        $.getJSON('../JSON/hubs_records.json', function(data) {
            $.each(data, function(key, value){
                if (value.transit_city.search(expression) != -1){
                    $('#result').append('<li class="list-group-item link-class">'+value.transit_id+'. '+value.transit_city+' | <span class="text-muted">'+value.address+'</span></li>');
                }
            });   
        });
    });

    $('#result').on('click', 'li', function() {
        var click_text = $(this).text();
 
        $('#live_search').val(click_text[0]);
        var search_hub_id = $('#live_search').val();        

        $('#live_search').val(click_text);
        $("#result").html('');

        $.ajax({
            url:"../php/get_geo_hub.php",
            method:"POST",
            data:{search_hub_id:search_hub_id},
            success:function(data)
            {
                set_custom_center();
            }
        })

        //setTimeout(set_custom_center, 1000);
        
        function set_custom_center(){
            $.getJSON('../JSON/geo_hub.json', function(data) {
                var kentro = [];
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

        function loadHubs(map){
            $.getJSON('../JSON/hubs_records.json', function(data) {
                var hubs = [];
                for(var i = data.length; i--; ){
                    for(var j = 0; j< Object.size(data[0]); j++){
                        hubs[i] = $.map(data[i],function(value,index){
                            return [value];
                       }); 
                    }
                }
                setMarkers(map, hubs);  
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
            loadHubs(map);
        }

        function setMarkers(map, all_the_hubs){
            var size = Object.size(all_the_hubs);
            var info = new google.maps.InfoWindow();
            
            for (var i = 0; i < size; i++) {
                var hub = all_the_hubs[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng( parseFloat(hub[3]), parseFloat(hub[4]) ),
                    map: map,
                    title: hub[1] + "  "  + hub[2] + "  "  + hub[3],
                    animation: google.maps.Animation.DROP 
                });
                google.maps.event.addListener(marker, 'click', (function(marker,hub){
                    return function(){
                        var content =
                            '<div><h4 style="text-align: center;">' + hub[1] + '</h4></div>' +
                            '<div><h5>Πληροφορίες</h5></div>' +
                            '<div>' +
                                '<p><b>Διεύθυνση:</b>&emsp;'+ hub[2] +'<br>' +
                                '<b>e-mail:</b>&emsp;&emsp;&emsp;  info@fastmover<br> <b>www:</b>&emsp;&emsp;&emsp;&emsp;www.fastmover.gr </p>' +
                            '</div>';
                        info.setContent(content);
                        info.open(map, marker);
                    }
                })(marker, hub));
            }
        }  
    });
});
