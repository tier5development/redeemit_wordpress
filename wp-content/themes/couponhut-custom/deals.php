<?php 
/* Template Name: Deal Page
*/
$main_catagory = "select * from reedemer_category where status = 1 && visibility = 1 && parent_id = 0";
$main_catagory_data = $wpdb->get_results($main_catagory ,ARRAY_A);
if(count($main_catagory_data) > 0)
{
    for( $i = 0;$i < count($main_catagory_data) ; $i++) {
$sub_catagory = "select * from reedemer_category where status = 1 && visibility = 1 && parent_id = ".$main_catagory_data[$i]['id'];
$sub_catagory_data = $wpdb->get_results($sub_catagory ,ARRAY_A);
if(count($sub_catagory_data) > 0)
{   
    $h = 0;
    for($j= 0; $j < count($sub_catagory_data); $j++)
    {
        $total_dat = "select count(id) as count from reedemer_offer where subcat_id = ".$sub_catagory_data[$j]['id']." &&  status = 1";
        $total_dat_count = $wpdb->get_results($total_dat ,ARRAY_A);
       $h = $h + $total_dat_count[0]['count'];
   array_push($sub_catagory_data[$j],$total_dat_count); 

    }
   array_push($main_catagory_data[$i],$sub_catagory_data); 
   array_push($main_catagory_data[$i],$h); 
   //array_push($main_catagory_data[$i],count($sub_catagory_data)); 
}

    }
    // print_r($main_catagory_data);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php if (is_home () ) { bloginfo('name'); } elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo('name'); }
elseif (is_single() ) { single_post_title(); }
elseif (is_page() ) { bloginfo('name'); echo ': '; single_post_title(); }
else { wp_title('',true); } ?></title>

    <!-- Bootstrap -->
    <link href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css" rel="stylesheet">
     

     <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/fonts/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" id="ui_css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
      .next,.back{background: #252525; color: #fff; padding: 4px 8px; cursor: pointer;}
      .category-list ul li ul.subcat-dropdown.openSubcat{
      display: block;
      }
      .price-select{color: #73BF21;
    font-weight: bold;}
    </style>
<!-- Latest compiled JavaScript -->
<?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12 search-result">
            <h2>Here are your results </h2>
        
					<?PHP //echo $default_loc;?>
                <div class="col-md-3 col-sm-3 search-widget-area">
                   <div class="box category-list newcategory-list">
                    <h3>Category</h3>
						<?php if($_GET['cat_id'] != '') { ?>
					<ul class="Parent_cat_ul" id="cat_data" curr_cat_id="<?php echo $_GET['cat_id']; ?>" curr_sub_cat_id="-"  curr_sub_sub_cat_id="-">
					<?php 
					}
					else 
					{  ?>
                    <ul class="Parent_cat_ul" id="cat_data" curr_cat_id="-" curr_sub_cat_id="-" curr_sub_sub_cat_id="-">
					<?php } ?>						
					</ul>
                    </div>
                <div class="box category-list">
                    <!--<h3>Category</h3>
					<?php if($_GET['cat_id'] != '') { ?>
					<ul id="cat_data" curr_cat_id="<?php echo $_GET['cat_id']; ?>" curr_sub_cat_id="-"  curr_sub_sub_cat_id="-">
					<?php 
					}
					else 
					{  ?>
                    <ul id="cat_data" curr_cat_id="-" curr_sub_cat_id="-" curr_sub_sub_cat_id="-">
					<?php } ?>	
                    <?php if(count($main_catagory_data) > 0)
                    { foreach ($main_catagory_data as $value1) {
						if($_GET['cat_id'] != '' && $_GET['cat_id'] == $value1['id']) {
                         echo "<li >  <a href='#' class='catagory_section cat' cat_id=".$value1['id']." >".$value1['cat_name']."(".$value1[1].")</a>";
                         
                         if(count($value1[0]) > 0)
                         {  
                            $p = 0;
                            echo "<ul class='subcat-dropdown openSubcat'>";
                            foreach ($value1[0] as $sub_cat)
                            {
																
                                echo "<li >  <a href='#' class='catagory_section sub_cat' cat_id=".$value1['id']."  sub_cat_id=".$sub_cat['id']." >".$sub_cat['cat_name']."(".$sub_cat[0][0]['count'].")</a>"; 
                                $p + $sub_cat[0][0]['count'];								
								echo '<ul class="sub-subcat-dropdown">';
										$sub_cat_id = $sub_cat['id'];
										$sub_sub_cats = $wpdb->get_results("SELECT * FROM reedemer_category where parent_id = $sub_cat_id");
										foreach($sub_sub_cats  as $sub_sub_cat) {
											$sub_sub_cat = $sub_sub_cat->id;
											$sub_pr_num = $wpdb->get_results("SELECT * FROM reedemer_offer_categories WHERE cat_id=$sub_sub_cat"); 
											echo "<li><a href='#' class='catagory_section sub_cat' cat_id=".$value1['id']."  sub_cat_id=".$sub_cat['id']." sub_sub_cat_id =".$sub_sub_cat->id."  >".$sub_sub_cat->cat_name."(".count($sub_pr_num).")</a></li>";
										}
									echo '</ul>';
								echo '</li>';
                            }
                            echo "</ul>";

                         }
                         echo"</li>";  
						}else{
							
							echo "<li >  <a href='#' class='catagory_section cat' cat_id=".$value1['id']." >".$value1['cat_name']."(".$value1[1].")</a>";
                         
                         if(count($value1[0]) > 0)
                         {  
                            $p = 0;
                            echo "<ul class='subcat-dropdown'>";
                            foreach ($value1[0] as $sub_cat)
                            {								
                                echo "<li >  <a href='#' class='catagory_section sub_cat' cat_id=".$value1['id']."  sub_cat_id=".$sub_cat['id']." >".$sub_cat['cat_name']."(".$sub_cat[0][0]['count'].")</a>"; 
                                $p + $sub_cat[0][0]['count'];
									
									$sub_cat_id = $sub_cat['id'];
									$sub_sub_cats = $wpdb->get_results("SELECT * FROM reedemer_category where parent_id = $sub_cat_id");
									if(count($sub_sub_cats) > 0) {
									echo '<ul class="sub-subcat-dropdown">';
									foreach($sub_sub_cats  as $sub_sub_cat) {										
										$sub_pr_num = $wpdb->get_results("SELECT * FROM reedemer_offer_categories WHERE cat_id=$sub_sub_cat->id"); 
										
										echo "<li><a href='#' class='catagory_section sub_cat sub_sub_cat' cat_id=".$value1['id']."  sub_cat_id=".$sub_cat['id']." sub_sub_cat_id =".$sub_sub_cat->id."  >".$sub_sub_cat->cat_name."(".count($sub_pr_num).")</a></li>";
									}
								echo '</ul>';
									}
							echo '</li>';
                            }
                            echo "</ul>";

                         }
                         echo"</li>"; 
						}
                    }

                        } ?>
                        
                    </ul>-->
                </div>
                <div class="clearboth"></div>
                <div class="box category-list price-list">
                    <h3>Price</h3>
                    <p>
                      <label for="amount">Price range:</label>
                      <!-- <input type="text" id="amount" readonly> -->
                      <span class="price-select">$</span><span class="price-select" id="l_bound">49</span>
                      <span class="price-select">-</span>
                      <span class="price-select">$</span><span class="price-select" id="u_bound">526</span>
                    </p>
                    <div id="slider-range"></div>
                    <div class="price-form">
                        <div class="form-inline">
                          <div class="form-group">
                            <input type="text" class="form-control" id="min_pr" placeholder="$">
                          </div>
                          <div class="form-group">
                            <input type="text" class="form-control" id="max_pr" placeholder="$">
                          </div>
                          <button type="submit" class="btn btn-default" id="btn_go_slider">Go</button>
                        </div>
                    </div>
                </div>
                <div class="clearboth"></div>
                <div class="box category-list savings-list">
					
                </div>


                </div>

                    
                <div class="col-md-9 col-sm-9 search-result-view nopadding">
                   <div id="deal_search_results"></div>

		<div class="location-map">
                    <?php 
			$offer_id = $_GET['cat_id'];
			if($offer_id != '') {
				$sql_locations = $wpdb->get_results("SELECT * FROM `reedemer_offer` WHERE status = 1 && cat_id=$offer_id "); 
			}else {
				$sql_locations = $wpdb->get_results("SELECT * FROM `reedemer_offer` WHERE status = 1 "); 
			}

			foreach( $sql_locations as $rs_location ) {
				$offer_description = substr($rs_location->offer_description,0,15);

				$prc_val = ($rs_location->pay_value/$rs_location->retails_value); 
				$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
				$tot_per = 100 - $percent_friendly;
				$tot_per = $tot_per."% OFF";

				$retail_val = $rs_location->retails_value;
				$pay_val = $rs_location->pay_value;

				$lat= $rs_location->latitude; //latitude
				$lng= $rs_location->longitude; //longitude
				$address= getaddress($lat,$lng);

				$markers[] = array(
				"$address",
				$rs_location->latitude,
				$rs_location->longitude,
				"$rs_location->offer_image_path",
				"$offer_description",
				"$tot_per",
				"$retail_val",
				"$pay_val"
				);
			}
					//print_r($markers);
				?>
				<div id="map_wrapper">
				<div id="map_canvas" class="mapping"></div>
			</div>


			<style>

				#map_wrapper {
					height: 300px;
				}

				#map_canvas {
					width: 100%;
					height: 350px;
				}
			.map_ico {
				margin-bottom: 60px;
				max-height: 300px;
			}


			</style>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCb0kirLjsnOe4aUnYsZFVV1ziOulmt-3s"></script>
			
			

			<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"
			  type="text/javascript"></script>-->	
			<script>

				function initialize(markers) {
					
					
					var map;
					var bounds = new google.maps.LatLngBounds();
					var mapOptions = {
						scrollwheel: false,
						mapTypeId: "roadmap",
						center: new google.maps.LatLng(52.791331, -1.918728), // somewhere in the uk BEWARE center is required
						zoom: 20,
					};

					// Display a map on the page
					map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
					map.setTilt(45);

					// Multiple Markers
					
					//var markers = <?php //echo json_encode( $markers ); ?>;
					
					
					
				// Info Window Content
					var infoWindowContent = [
						['<div class="info_content">' +
						'<h3>London Eye</h3>' +
						'<p>The London Eye is a giant Ferris wheel situated on the banks of the River Thames. The entire structure is 135 metres (443 ft) tall and the wheel has a diameter of 120 metres (394 ft).</p>' + '</div>'],
						['<div class="info_content">' +
						'<h3>Palace of Westminster</h3>' +
						'<p>The Palace of Westminster is the meeting place of the House of Commons and the House of Lords, the two houses of the Parliament of the United Kingdom. Commonly known as the Houses of Parliament after its tenants.</p>' +
						'</div>']
					];

					// Display multiple markers on a map
					var infoWindow = new google.maps.InfoWindow();
					var marker, i;

					// Loop through our array of markers & place each one on the map
					for (i = 0; i < markers.length; i++) {
						var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
						bounds.extend(position);
						marker = new google.maps.Marker({
							position: position,
							map: map
						});

						//Allow each marker to have an info window
						google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
							return function () {
						var mar_img = markers[i][3];
						var mar_name = markers[i][4];		
						var tot_per = markers[i][5];		
						var retail_val = markers[i][6];
						var pay_val = markers[i][7];
						var sit_url = "<?php echo site_url() ?>";		
				
						var html = '<div class="product-map"><img src="'+sit_url+'/'+mar_img+'" width="90px" height="40px">'+ '<h2>' + mar_name +'</h2><p class="discount">' + tot_per +'</p><p class="retail">$ ' + retail_val +'</p><p class="final">$ ' + pay_val + '</p></div>';

								infoWindow.setContent(html);
								infoWindow.open(map, marker);
							}
						})(marker, i));
						
						
						google.maps.event.addListener(marker, 'mouseout', (function(marker,i){ 
        				return function() {
           				infoWindow.close();
        				};
    					})(marker,i));
						
						
						google.maps.event.addListener(infoWindow, 'domready', function() {
      							// whatever you want to do once the DOM is ready
							$('.product-map').hover(function(){
								var mar_img = markers[i][3];
								var mar_name = markers[i][4];		
								var tot_per = markers[i][5];		
								var retail_val = markers[i][6];
								var pay_val = markers[i][7];
								var sit_url = "<?php echo site_url() ?>";		

								var html = '<div class="product-map"><img src="'+sit_url+'/'+mar_img+'" width="90px" height="40px">'+ '<h2>' + mar_name +'</h2><p class="discount">' + tot_per +'</p><p class="retail">$ ' + retail_val +'</p><p class="final">$ ' + pay_val + '</p></div>';

								infoWindow.setContent(html);
								infoWindow.open(map, marker);
							});
						});
						
						/*google.maps.event.addListener(marker, 'mouseout', (function (marker, i) {
							return function () {
								//infoWindow.setContent(markers[i][0]);
								infoWindow.close();
							}
						})(marker, i));*/

						// Automatically center the map fitting all markers on the screen
						map.fitBounds(bounds);
					}

					//Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
					var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
						this.setZoom(8);
						map.setOptions({ minZoom: 3 });
						google.maps.event.removeListener(boundsListener);
					});

				}
				


			</script>
                </div>
                <div id="block_data">
                
                
                
              </div>
                <div class="clear">&nbsp</div>
                 <div class="col-md-12 viewall-section" style="display:none;">
                    <a href="#" class="view-btn">Show more</a>
                </div>
                </div>

        </div>


    </div>
</div>
<div class="clear"></div>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>  -->
<!-- <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js" ></script> -->

	


<script type="text/javascript">
 // var j = $.noConflict();
   $(document).ready(function() {
	   
	   
	   
	    var markers = <?php echo json_encode( $markers ); ?>;
		google.maps.event.addDomListener(window, 'load', initialize(markers));
	   
	   
     $.getScript("http://code.jquery.com/ui/1.11.4/jquery-ui.js").done(
        function(){
		$(document).on("click",".cat",function(e){
        //$('.cat').click(function(e){
			e.preventDefault();
	  var cat_location = $('#deal_loc').val();
      $('#cat_data').attr("curr_cat_id",$(this).attr("cat_id"));
      $('#cat_data').attr("curr_sub_cat_id",'-');
	   $('#cat_data').attr("curr_sub_sub_cat_id",'-');
	   var cat_id_one = $(this).attr("cat_id");
      get_result();
      $.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-off-panel/",
              data:	{"location":cat_location,"cat_id":cat_id_one},
              success: function(data){
				  $(".savings-list").html(data);
			  }
		  });	
      });
		$(document).on("click",".sub_cat",function(e){
      //$('.sub_cat').click(function(e){
				 e.preventDefault();
      $('#cat_data').attr("curr_cat_id",$(this).attr("cat_id"));
      $('#cat_data').attr("curr_sub_cat_id",$(this).attr("sub_cat_id"));
	   $('#cat_data').attr("curr_sub_sub_cat_id",'-');
	   var cat_location = $('#deal_loc').val();
	   var cat_id_two = $(this).attr("cat_id");
	   var sub_cat_id_two = $(this).attr("sub_cat_id");
       get_result();
       $.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-off-panel/",
              data:	{"location":cat_location,"cat_id":cat_id_two,"sub_cat_id":sub_cat_id_two},
              success: function(data){
				  $(".savings-list").html(data);
			  }
		  });	
      });
      
		$(document).on("click",".sub_sub_cat",function(e){		
	 // $('.sub_sub_cat').click(function(e){
		  e.preventDefault();
		  $('#cat_data').attr("curr_cat_id",$(this).attr("cat_id"));
		  $('#cat_data').attr("curr_sub_cat_id",$(this).attr("sub_cat_id"));
	   	  $('#cat_data').attr("curr_sub_sub_cat_id",$(this).attr("sub_sub_cat_id"));
	   	   var cat_location = $('#deal_loc').val();
		   var cat_id_three = $(this).attr("cat_id");
		   var sub_cat_id_three = $(this).attr("sub_cat_id");
		   var sub_sub_cat_id_three = $(this).attr("sub_sub_cat_id");
		  get_result();
		   $.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-off-panel/",
              data:	{"location":cat_location,"cat_id":cat_id_three,"sub_cat_id":sub_cat_id_three,"sub_sub_cat_id":sub_sub_cat_id_three},
              success: function(data){
				  $(".savings-list").html(data);
			  }
		  });
      });		
			
		

      $('.value_calculate_type').click(function(){		  
        $( "#accordion" ).attr("curr_value_calculate",$(this).val());
       $(this).parent().parent().parent().attr("clk_data",$(this).attr('id'));
       get_result();
      });

	

      function get_result()
      {
		  
		  var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		};	  
	
		var part_id = getUrlParameter('part_id');
		  
		var deal_cat =   getUrlParameter('deal_catid');
		var deal_cat_sub =   getUrlParameter('deal_subcatid');
		var deal_subsub_cat = getUrlParameter('deal_subsub_parent');
		var src_loc =   getUrlParameter('deal_loc');  
		var def_loc = '';  
		if(src_loc != '' && typeof src_loc != 'undefined'){
			def_loc = src_loc;
			$("#deal_loc").val(src_loc); 
			$("#deal_cat").val(getUrlParameter('cat_name'));
		}
		else 
		{
			var def_loc = $("#deal_loc").val();
		}
		  
		
	      var cat_id = $('#cat_data').attr("curr_cat_id");
		  var sub_cat_id = $('#cat_data').attr("curr_sub_cat_id");
		  var sub_sub_cat_id = $('#cat_data').attr("curr_sub_sub_cat_id"); 	  
	      var curr_percent = $( "#accordion" ).attr("curr_percent");
	      var curr_src_panel =$( "#accordion" ).attr("curr_src_panel");
	      var min_vl = "";
	      var max_vl = "";
		  var brandname = $("#deal_brand").val();
		  var created_by = $("#deal_created_by").val();
		  var key = $("#deal_key").val();
		  
		  var deal_tag = $('#deal_tag').val();
		  
		  var dealcatid = $('#deal_catid').val();
		  var dealsubcat = $('#deal_subcatid').val();
		  var dealsubsubcat = $('#deal_sub_sub_parent').val();
		  
		  if((dealcatid != '' && dealcatid !=0) && (dealsubcat != '' && dealsubcat !=0) && (dealsubsubcat != '' && dealsubsubcat !=0)){
			  
			  var data = {"part_id":part_id,"cat_id":dealsubsubcat,"sub_cat_id":dealsubcat,"min_value":min_vl,"max_value":max_vl,"curr_percent":curr_percent,"curr_src_panel":curr_src_panel,"def_loc":def_loc,"deal_cat":dealcatid,"deal_cat_sub":dealsubcat,"sub_sub_cat_id":dealcatid,"deal_tag":deal_tag,"deal_brandname":brandname,"deal_created_by":created_by,"dealkey":key}
		  }else{
			  
			data =   {"part_id":part_id,"cat_id":cat_id,"sub_cat_id":sub_cat_id,"min_value":min_vl,"max_value":max_vl,"curr_percent":curr_percent,"curr_src_panel":curr_src_panel,"def_loc":def_loc,"deal_cat":deal_cat,"deal_cat_sub":deal_cat_sub,"sub_sub_cat_id":sub_sub_cat_id,"deal_tag":deal_tag,"deal_brandname":brandname,"deal_created_by":created_by,"dealkey":key}
		  }
		  
		  
		   $.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-searching/",
              data: data,			  
              beforeSend: function(){
                  
              },
              success: function(data){
                  //console.log(data);			  
                  var obj = $.parseJSON(data);
                  $('#block_data').empty();
                  if(obj.status == "true")
                  {
         
                     $('#block_data').html(obj.res_data);
                     $( "#slider-range" ).slider( "option", "min", Math.round(obj.min_val) );
                     $( "#slider-range" ).slider( "option", "max", Math.round(obj.max_val) );
                     $( "#slider-range" ).slider( "values",  [ Math.round(obj.min_val), Math.round(obj.max_val ) ]  );

                     $('#l_bound').text(Math.round(obj.min_val));
                     $('#u_bound').text(Math.round(obj.max_val));					 
					 $('#min_pr').val(Math.round(obj.min_val));
					 $('#max_pr').val(Math.round(obj.max_val));  
					  
					  var obj_markers = obj.marker;
					  
					  //console.log(obj_markers);
					  
					  var markers = [];
                       $.each(obj_markers, function(i, obj) {
                       markers.push([obj.address,obj.lat, obj.lng,atob(obj.offer_image_path),obj.offer_desc,obj.total_per,obj.retail_val,obj.pay_val]);
                       });
					  
					  //console.log(markers);
					  
					 
				google.maps.event.addDomListener(window, 'load', initialize(markers));
					  
					
                  }else if(obj.status == "false")
                  {
					 $('#block_data').html(obj.res_data); 
				  }
                 
              }

          });
        var src_cat = getUrlParameter('cat_id');  
		var default_location = $("#deal_loc").val();
		$.ajax({
		type:"post",
		url:"<?php echo site_url(); ?>/index.php/deal-left-cat/",
		data:'default_location='+default_location+'&cat_id='+src_cat,
		success:function(data){

		var objj =$.parseJSON(data);
		
		$('.Parent_cat_ul').html(objj.list_cat_data);
		}		

		});
		

      }
			
	/*============Deal Off Panel Start============*/
			
	function get_result_off_panel()
      {
		  var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : sParameterName[1];
					}
				}
			};	  

			    var deal_cat = $("#deal_catid").val();
				var deal_cat_sub = $("#deal_subcatid").val();
				var deal_created_loc = $("#deal_loc").val();				
				var dealtag = $('#deal_tag').val();
				var dealkey = $('#deal_key').val();
				var dealbrand = $('#deal_brand').val();
				var dealcreated_by = $('#deal_created_by').val();
			    var src_loc =   getUrlParameter('deal_loc');  
			    var def_loc = ''; 
		  	
				  var cat_id = $('#cat_data').attr("curr_cat_id");
				  var sub_cat_id = $('#cat_data').attr("curr_sub_cat_id");		  
				  var sub_sub_cat_id = $('#deal_sub_sub_parent').val(); 
				  var curr_value_calculate = $( "#accordion" ).attr("curr_value_calculate");
				  var curr_percent = $( "#accordion" ).attr("curr_percent");
				  var location = $( "#deal_created_fill" ).val();
		  
		  	var off_pane_data;
		  if(deal_cat == ''){
			  deal_cat = $('#cat_data').attr("curr_cat_id");
		  }
			if(src_loc != '' && typeof src_loc != 'undefined'){
				def_loc = src_loc;
				//$("#deal_loc").val(src_loc); 
				//$("#deal_cat").val(getUrlParameter('cat_name'));
			}
			else 
			{
				var def_loc = $("#deal_loc").val();
			}
		  
		  if(dealtag != '')
				{
					//alert('h1');
					 off_pane_data={"location":def_loc,"deal_tag":dealtag};
				}
		else if(dealkey != '')
				{
					//alert('h2');
					 off_pane_data={"location":def_loc,"deal_key":dealkey};
				}
		else if(dealcreated_by != '')		
				{
					 off_pane_data={"location":def_loc,"dealbrand":dealbrand,"deal_created_by":dealcreated_by,};
				}	
		/*else if(deal_cat_sub == '' || deal_cat_sub == '0')
				{
					//alert('h1');
				  off_pane_data={"location":def_loc,"cat_id":deal_cat};		 
				}*/
		else if (deal_cat_sub != '' && deal_cat != '' && sub_sub_cat_id !='0' && sub_sub_cat_id !='') 
				{
					//alert('h3');
				  off_pane_data={"location":def_loc,"cat_id":sub_sub_cat_id,"sub_cat_id":deal_cat_sub,"sub_sub_cat_id":deal_cat};
				}
		  
		  else if(deal_cat != ''){
			  
			 off_pane_data={"location":def_loc,"cat_id":deal_cat};	 
		  }
		  
		 else
				{
					//	alert('h4');
				off_pane_data={"location":def_loc,"cat_id":deal_cat_sub,"sub_cat_id":deal_cat};	
				}
		  $.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-off-panel/",
              data:	off_pane_data,
              success: function(data){
				  $(".savings-list").html(data);
			  }
		  });
      }		
			
	/*============Deal Off Panel End============*/

       function get_result1()
      {
		  var def_loc = $("#deal_loc").val();
		  var getUrlParameter = function getUrlParameter(sParam) {
		  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : sParameterName[1];
				}
			}
		};	  
	
		  var part_id = getUrlParameter('part_id');
	      var cat_id = $('#cat_data').attr("curr_cat_id");
	      var sub_cat_id = $('#cat_data').attr("curr_sub_cat_id");
		  var sub_sub_cat_id = $('#cat_data').attr("curr_sub_sub_cat_id"); 
	      var curr_value_calculate = $( "#accordion" ).attr("curr_value_calculate");
	      var curr_percent = $( "#accordion" ).attr("curr_percent");
	      var min_vl = $('#l_bound').text();
	      var max_vl = $('#u_bound').text();
          $.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-searching/",
              data:{"part_id":part_id,"cat_id":cat_id,"sub_cat_id":sub_cat_id,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent,"def_loc":def_loc,"sub_sub_cat_id":sub_sub_cat_id},
              beforeSend: function(){
                  
              },
              success: function(data){
                 //console.log(data);
                  var obj = $.parseJSON(data);
                  $('#block_data').empty();
                  if(obj.status == "true")
                  {
         
                     $('#block_data').html(obj.res_data);
                    
                     $( "#slider-range" ).slider( "values",  [ Math.round(obj.min_val), Math.round(obj.max_val ) ]  );

                     $('#l_bound').text(Math.round(obj.min_val));
                     $('#u_bound').text(Math.round(obj.max_val));
					 $('#min_pr').val(Math.round(obj.min_val));
					 $('#max_pr').val(Math.round(obj.max_val)); 
					  
					  
					  var obj_markers = obj.marker;				  
					  
					  
					  var markers = [];
                       $.each(obj_markers, function(i, obj) {
                       markers.push([obj.address,obj.lat, obj.lng,atob(obj.offer_image_path),obj.offer_desc,obj.total_per,obj.retail_val,obj.pay_val]);
                       });
					  
					  
					  
					 
				google.maps.event.addDomListener(window, 'load', initialize(markers));
                    
                  }else if(obj.status == "false")
                  {
					 $('#block_data').html(obj.res_data); 
				  }
                 
              }

          });

      }

			$(document).on("mouseover",".category-list li a",function(e){
            //$(".category-list li").on("click","a",function(e){
            	$(this).parent().find(".subcat-dropdown").toggleClass("openSubcat");
            	e.preventDefault();
            });
			$(document).on("mouseover","ul.subcat-dropdown li a",function(e){
			//$("ul.subcat-dropdown li").on("click","a",function(e){
				//$(this).parent().find(".sub-subcat-dropdown").toggleClass("openSubcat");
				if($(this).closest("li").children("ul").children("li").length){
				$(this).parent().find(".sub-subcat-dropdown").toggleClass("openSubcat");
				}
				e.preventDefault();
			});
              

             $( "#slider-range" ).slider({
                range: true,
                min: 0,
                max: 500,
                values: [ 0,0 ],
                stop: function( event, ui ) {
						
                        $('#l_bound').text(ui.values[ 0 ]);
                        $('#u_bound').text(ui.values[ 1 ]);
						$('#min_pr').val(ui.values[ 0 ]);
						$('#max_pr').val(ui.values[ 1 ]);
                        get_result1();
                }
              });
			
			$("#btn_go_slider").click(function(){				
				
			  
			  var cat_id = $('#cat_data').attr("curr_cat_id");
			  var sub_cat_id = $('#cat_data').attr("curr_sub_cat_id");			  
	  		  var sub_sub_cat_id = $('#cat_data').attr("curr_sub_sub_cat_id"); 	
			  var curr_value_calculate = $( "#accordion" ).attr("curr_value_calculate");
			  var curr_percent = $( "#accordion" ).attr("curr_percent");
			  var min_vl = $("#min_pr").val();
			  var max_vl = $("#max_pr").val();
				  $.ajax({
					  type: "POST",
					  url: "<?php echo site_url() ?>/index.php/deal-searching/",
					  data:{"cat_id":cat_id,"sub_cat_id":sub_cat_id,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent,"sub_sub_cat_id":sub_sub_cat_id},
					  beforeSend: function(){
						  
					  },
					  success: function(data){
						 //console.log(data);
						  var obj = $.parseJSON(data);
						  $('#block_data').empty();
						  if(obj.status == "true")
						  {

							 $('#block_data').html(obj.res_data);

							 $( "#slider-range" ).slider( "values",  [ Math.round(obj.min_val), Math.round(obj.max_val ) ]  );

							 $('#l_bound').text(Math.round(obj.min_val));
							 $('#u_bound').text(Math.round(obj.max_val));
							 $('#min_pr').val(Math.round(obj.min_val));
							 $('#max_pr').val(Math.round(obj.max_val)); 
						  }else if(obj.status == "false")
						  {
							 $('#block_data').html(obj.res_data); 
						  }

					  }

				  });
    						

			});
			
			$(document).ready(function(){
				
			$('#deal_cat').blur(function(){
			$("#suggesstion-box-cat").css("display","none");
	  		 });	
				
			$('#suggesstion-box-cat').on('mousedown', function(event) {
			event.preventDefault();
			}).on('click', '.cat-list>li', function() {
			$('#deal_cat').val(this.textContent).blur();
			});	
				
			/*$("#deal_cat").keyup(function(e){
			var code = e.which;
			if(code != 13){
			$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/index.php/autosearch/",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
			$("#suggesstion-box-cat").css("background","#FFF url(<?php echo site_url(); ?>/wp-content/uploads/2016/06/21.gif) no-repeat 165px");
			},
			success: function(data){
			//$("#suggesstion-box-cat").show();
			//$("#suggesstion-box-cat").html(data);
			//$("#deal_cat").css("background","#FFF");

			var obj =$.parseJSON(data);
			//alert(newobj.subcat_id);
			$('#deal_catid').val(obj.subcat_id);
			$('#deal_subcatid').val(obj.cat_id);
			$("#suggesstion-box-cat").show();
			$("#suggesstion-box-cat").html(obj.list_data);
			$("#deal_cat").css("background","#FFF");





			var key = obj.search_key;

			var valThis = key.toLowerCase();


			$('.cat-list > li').each(function(){
			var text = $(this).text().toLowerCase();
			if(text == valThis){
			$(this).css('background-color','#73bf21');
			}else{
			$(this).css('background-color','white');
			}
			});
			}
			});
			}
			});*/
			$(document).on("keyup","#deal_cat",function(e){
				
			var code = e.which;
			
			if(code == 13){
			   $("#search_deal_btn").trigger("click");
			}else if((code == 38) || (code == 40))
			{
				return false;
			}else
			{
				$.ajax({
			type: "POST",
			url: "<?php echo site_url(); ?>/index.php/autosearch/",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
			$("#suggesstion-box-cat").css("background","#FFF url(<?php echo site_url(); ?>/wp-content/uploads/2016/06/21.gif) no-repeat 165px");
			},
			success: function(data){
				//alert('hyyy');
				
			//$("#suggesstion-box-cat").show();
			//$("#suggesstion-box-cat").html(data);
			//$("#deal_cat").css("background","#FFF");
			if(data === 'null'){$('#deal_key').val('');return false;}else{
			var obj =$.parseJSON(data);
			//alert(obj.sub_sub_parent_id);
			if(obj.subcat_id != '' || obj.subcat_id != null){
			$('#deal_catid').val(obj.subcat_id);
			}
			if(obj.cat_id != '' || obj.cat_id != null){
			$('#deal_subcatid').val(obj.cat_id);
			}
			if(obj.sub_sub_parent_id != '' || obj.sub_sub_parent_id != null){
			$('#deal_sub_sub_parent').val(obj.sub_sub_parent_id);
			}
			$("#suggesstion-box-cat").show();
			$("#suggesstion-box-cat").html(obj.list_data);
			$("#deal_cat").css("background","#FFF");

			var key = obj.search_key;

			var valThis = key.toLowerCase();
			if($('.cat-list > li').length == 0){
			$("#suggesstion-box-cat").hide();
			$('#deal_key').val(obj.search_key);
			$('#deal_tag').val('');
			$('#deal_brand').val('');
			$('#deal_created_by').val('');
			}
			else if (obj.search_key =='')
			{
				$('#deal_key').val('');
			}
			else
			{
				$('#deal_key').val(obj.search_key);
				$('#deal_tag').val('');
				$('#deal_brand').val('');
				$('#deal_created_by').val('');
			}	
			$('.cat-list > li').each(function(){
			var text = $(this).text().toLowerCase();
			if(text == valThis){
			if($(this).data("type") == 'category'){
				$('#deal_key').val('');	
				$('#deal_tag').val('');
				$('#deal_brand').val('');
				$('#deal_created_by').val('');
				$('#deal_cat').val(text);
				}else if($(this).data("type") == 'tag'){	
				$('#deal_key').val('');
				$('#deal_cat').val(text);
				$('#deal_brand').val('');
				$('#deal_created_by').val('');
				$('#deal_tag').val(text);
				}
				else if($(this).data("type") == 'brand'){
				$('#deal_key').val('');
				$('#deal_tag').val('');
				$('#deal_brand').val(text);
				$('#deal_created_by').val($(this).data('created_by'));
				$('#deal_cat').val(text);
			}
			$(this).css('background-color','#73bf21');
			$(this).removeClass('background');
			}else{
			$(this).css('background-color','white');
			$(this).removeClass('background');
			}
		});
		// This is for change color when mouse in and out in autosuggestion box
		$('.cat-list>li').on("mouseover",function(){
			$(this).css('background-color','#73bf21');
		});
				
		$('.cat-list>li').on("mouseout",function(){
			$(this).css('background-color','#fff');
		});
		}	
				
			// for selecting list using up & down arrow	
				
			var li = $('.cat-list > li');	
			var liSelected;
			$(document).on('keydown','#deal_cat', function(e){
				
				var selected;
			    if(e.which === 40){
					
			        if(liSelected){
			            liSelected.removeClass('background');
			            next = liSelected.next();
			            if(next.length > 0){
			                liSelected = next.addClass('background').css('background-color','');
			                selected = next.text();

			            }else{
			                liSelected = li.eq(0).addClass('background').css('background-color','');
			                selected = li.eq(0).text();
			            }
			        }else{
			            liSelected = li.eq(0).addClass('background').css('background-color','');
			                selected = li.eq(0).text();
			        }
					
					if($('.background').data('type') == 'category'){
					var cat_id = $('.background').data('cat_id');
					var sub_catid = $('.background').data('sub_catid');
					var sub_sub_parent= $('.background').data('sub_sub_parent');
						$('#deal_key').val('');
						$('#deal_brand').val('');
						$('#deal_created_by').val('');
						$('#deal_tag').val('');
						$('#deal_catid').val(cat_id);
						$('#deal_subcatid').val(sub_catid);
						$('#deal_sub_sub_parent').val(sub_sub_parent);
					}
					else if($('.background').data('type') == 'tag'){	
						$('#deal_key').val('');
						$('#deal_brand').val('');
						$('#deal_created_by').val('');
						$('#deal_catid').val('');
						$('#deal_subcatid').val('');
						$('#deal_sub_sub_parent').val('');
						$('#deal_tag').val($('.background').text());
					}
					else if($('.background').data('type') == 'brand'){
						var created_by = $('.background').data('created_by');
						$('#deal_key').val('');
						$('#deal_catid').val('');
						$('#deal_subcatid').val('');
						$('#deal_sub_sub_parent').val('');
						$('#deal_tag').val('');
						$('#deal_brand').val($('.background').text());
						$('#deal_created_by').val(created_by);
					}
					
			    }else if(e.which === 38){
			        if(liSelected){
			            liSelected.removeClass('background');
			            next = liSelected.prev();
			            if(next.length > 0){
			                liSelected = next.addClass('background').css('background-color','');
			                selected = next.text();

			            }else{

			                liSelected = li.last().addClass('background').css('background-color','');
			                selected = li.last().text()
			            }
			        }else{

			            liSelected = li.last().addClass('background').css('background-color','');
			            selected = li.last().text()
			        }
					
					if($('.background').data('type') == 'category'){
					var cat_id = $('.background').data('cat_id');
					var sub_catid = $('.background').data('sub_catid');
					var sub_sub_parent= $('.background').data('sub_sub_parent');
			    	$('#deal_key').val('');
					$('#deal_brand').val('');
					$('#deal_created_by').val('');
					$('#deal_tag').val('');
					$('#deal_catid').val(cat_id);
			    	$('#deal_subcatid').val(sub_catid);
			    	$('#deal_sub_sub_parent').val(sub_sub_parent);
					}else if($('.background').data('type') == 'tag'){	
					$('#deal_key').val('');
			    	$('#deal_brand').val('');
					$('#deal_created_by').val('');
			    	$('#deal_catid').val('');
			    	$('#deal_subcatid').val('');
			    	$('#deal_sub_sub_parent').val('');
			    	$('#deal_tag').val($('.background').text());
					}
					
					
				 }else if(li.is( ".background" ) && e.which === 13){
					
					if($('.background').data('type') == 'category'){
					$('#deal_key').val('');
					$('#deal_brand').val('');
					$('#deal_created_by').val('');
					$('#deal_tag').val('');
					$('#deal_cat').val($('.background').text());
					}else if($('.background').data('type') == 'tag'){
					$('#deal_key').val('');
					$('#deal_brand').val('');
					$('#deal_created_by').val('');
					$('#deal_cat').val($('.background').text());
					$('#deal_tag').val($('.background').text());
					}
					else if($('.background').data('type') == 'brand'){
					$('#deal_key').val('');	
					$('#deal_tag').val('');	
					$('#deal_brand').val($('.background').text());
					$('#deal_cat').val($('.background').text());	
					}
					 li.removeClass('background');
					 
				}
			});	
				
				
				
			}
	});
			
			}
			
		});
			});
			
			
			$("#search_deal_btn").click(function(){	
				
				get_result_off_panel();
				var deal_cat = $("#deal_catid").val();
				var deal_cat_sub = $("#deal_subcatid").val();
				var deal_created_loc = $("#deal_loc").val();				
				var dealtag = $('#deal_tag').val();
				var dealkey = $('#deal_key').val();
				var dealbrand = $('#deal_brand').val();
				var dealcreated_by = $('#deal_created_by').val();	
				var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = decodeURIComponent(window.location.search.substring(1)),
					sURLVariables = sPageURL.split('&'),
					sParameterName,
					i;

					for (i = 0; i < sURLVariables.length; i++) {
						sParameterName = sURLVariables[i].split('=');

						if (sParameterName[0] === sParam) {
							return sParameterName[1] === undefined ? true : sParameterName[1];
						}
					}
				};	  

				var part_id = getUrlParameter('part_id');
				if(deal_cat == ''){
				var cat_id = $('#cat_data').attr("curr_cat_id");
				}
			  var sub_cat_id = $('#cat_data').attr("curr_sub_cat_id");		  
	  		  var sub_sub_cat_id = $('#deal_sub_sub_parent').val(); 
			  var curr_value_calculate = $( "#accordion" ).attr("curr_value_calculate");
			  var curr_percent = $( "#accordion" ).attr("curr_percent");
			  var location = $( "#deal_created_fill" ).val();
			 
			  var min_vl = "";
			  var max_vl = "";
			  //alert(dealtag);
			  //alert(deal_cat_sub);
			  //alert(deal_cat);
			  //alert(sub_sub_cat_id);
			  if(deal_cat_sub == '' && deal_cat == ''  && dealtag != '' && (sub_sub_cat_id =='0' || sub_sub_cat_id ==''))
				{
					//alert('h2');
					aj_data={"location":location,"deal_tag":dealtag,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent};
				}
			  else if((deal_cat_sub=='' || deal_cat_sub==0 )  && deal_cat != '' && (sub_sub_cat_id == '' || sub_sub_cat_id == 0 )){
				  //alert('h1');
				  var aj_data={"cat_id":cat_id,"sub_cat_id":sub_cat_id,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent,"location":location,"part_id":part_id,"deal_cat":deal_cat,"deal_cat_sub":deal_cat_sub}; 
						  }
			  else if((deal_cat_sub!='' || deal_cat_sub!=0 )  && deal_cat != '' && (sub_sub_cat_id == '' || sub_sub_cat_id == 0 )){
				  //alert('h3');
				  var aj_data={"cat_id":cat_id,"sub_cat_id":sub_cat_id,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent,"location":location,"part_id":part_id,"deal_cat":deal_cat,"deal_cat_sub":deal_cat_sub}; 
						  }
			  else if(dealbrand != '' && dealcreated_by != '')
				{	//alert('h11');
					aj_data={"location":location,"dealbrand":dealbrand,"deal_created_by":dealcreated_by,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent,};
				}
			  else if( dealkey != '')
				{
					//alert(dealkey);
					
				aj_data={"location":location,"dealkey":dealkey,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent};
				}
			 else
				{
					//alert('h4');
					aj_data={"cat_id":sub_sub_cat_id,"sub_cat_id":deal_cat_sub,"min_value":min_vl,"max_value":max_vl,"curr_value_calculate":curr_value_calculate,"curr_percent":curr_percent,"location":location,"part_id":part_id,"deal_cat":deal_cat,"deal_cat_sub":deal_cat_sub,"sub_sub_cat_id":deal_cat};
				}
			  $("#suggesstion-box-cat").hide();
			  $("#suggesstion-box-loc").hide();
				  $.ajax({
					  type: "POST",
					  url: "<?php echo site_url() ?>/index.php/deal-searching/",
					  
					  data:aj_data,
					
					  beforeSend: function(){
						  
					  },
					  success: function(data){	
						  //console.log(data);
						  var obj = $.parseJSON(data);
						  $('#block_data').empty();
						  if(obj.status == "true")
						  {

							 $('#block_data').html(obj.res_data);

							 $( "#slider-range" ).slider( "values",  [ Math.round(obj.min_val), Math.round(obj.max_val ) ]  );

							 $('#l_bound').text(Math.round(obj.min_val));
							 $('#u_bound').text(Math.round(obj.max_val));
							 $('#min_pr').val(Math.round(obj.min_val));
							 $('#max_pr').val(Math.round(obj.max_val)); 
							  
							  
							  var obj_markers = obj.marker;				  
					  
					  
							  var markers = [];
							   $.each(obj_markers, function(i, obj) {
							   markers.push([obj.address,obj.lat, obj.lng,atob(obj.offer_image_path),obj.offer_desc,obj.total_per,obj.retail_val,obj.pay_val]);
							   });

								google.maps.event.addDomListener(window, 'load', initialize(markers));
							  
						  }else if(obj.status == "false")
						  {
							 $('#block_data').html(obj.res_data); 
						  }

					  }

				  });
    	var default_location = $("#deal_loc").val();
		$.ajax({
		type:"post",
		url:"<?php echo site_url(); ?>/index.php/deal-left-cat/",
		data:'default_location='+default_location,
		success:function(data){

		var objj =$.parseJSON(data);
		
		$('.Parent_cat_ul').html(objj.list_cat_data);
		}		

		});
		if(deal_cat_sub == '' && deal_cat == ''  && dealtag != '' && (sub_sub_cat_id =='0' || sub_sub_cat_id ==''))
				{
					//alert('h0');
					 off_pane_data={"location":default_location,"deal_tag":dealtag};
				}
		else if(deal_cat_sub == '' && deal_cat == ''  && dealtag == '' && (sub_sub_cat_id =='0' || sub_sub_cat_id =='' && dealkey != ''))
				{
					//alert('h0');
					 off_pane_data={"location":default_location,"deal_key":dealkey};
				}
		else if(deal_cat_sub == '' && deal_cat == ''  && dealtag == '' && (sub_sub_cat_id =='0' || sub_sub_cat_id =='' ) && dealkey == '' && dealcreated_by != '')		
				{
					var off_pane_data={"location":default_location,"dealbrand":dealbrand,"deal_created_by":dealcreated_by,};
				}	
		else if(deal_cat_sub == '' || deal_cat_sub == '0')
				{
					//alert('h1');
				  var off_pane_data={"location":default_location,"cat_id":deal_cat};		 
				}
		else if (deal_cat_sub != '' && deal_cat != '' && sub_sub_cat_id !='0' && sub_sub_cat_id !='') 
				{
					//alert('h2');
				  off_pane_data={"location":default_location,"cat_id":sub_sub_cat_id,"sub_cat_id":deal_cat_sub,"sub_sub_cat_id":deal_cat};
				}
		
		else
				{
					//alert('h3');
				off_pane_data={"location":default_location,"cat_id":deal_cat_sub,"sub_cat_id":deal_cat};	
				}
		$.ajax({
              type: "POST",
              url: "<?php echo site_url() ?>/index.php/deal-off-panel/",
              data:	off_pane_data,
              success: function(data){
				  $(".savings-list").html(data);
			  }
		  });		

			});	
			

                    get_result();
			get_result_off_panel();

            

        });


});
//To select category name

function selectCategory(val, cid, subid, sub_sub_id) {
	 // alert('feee');
	$('.cat-list>li').removeClass('background');
	$('#deal_key').val('');
	$("#deal_brand").val('');
	$('#deal_created_by').val('');	
	$("#deal_tag").val('');
	$("#deal_cat").val(val);
	$("#deal_catid").val(cid);
	$("#deal_subcatid").val(subid);
	$("#deal_sub_sub_parent").val(sub_sub_id);
	$("#search_deal_btn").trigger("click");
	}
	function selecttag(tag){
		$('#deal_key').val('');
		$("#deal_brand").val('');
		$('#deal_created_by').val('');	
		$("#deal_cat").val(tag);
		$("#deal_tag").val(tag);
		$("#search_deal_btn").trigger("click");
		}
	function selectbrand(id,name){
	$("#deal_tag").val('');
	$('#deal_key').val('');	
	$("#deal_cat").val(name);
	$("#deal_brand").val(name);
	$('#deal_created_by').val(id);
	$("#search_deal_btn").trigger("click");
	}
	// END *******************************************	
</script>
<?php get_footer(); ?>

