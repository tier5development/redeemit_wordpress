<?php 
/*Template Name:Deal Details Page
*/
?>

<?php 
if($_COOKIE['location_input'] != '') {
	$default_loc = $_COOKIE['location_input'];
}
else 
{
	$default_loc = 'Yonkers';
}

$min_distance = 50;

$address_dis = $default_loc;
$latLong = getLatLong($address_dis);
$lat_dis = $latLong['latitude'];
$lon_dis = $latLong['longitude'];

?>

<?php 
 $user_data = get_user_by("id",get_current_user_id());
 $get_user = "SELECT id  from users  where email = '".$user_data->user_login."'";
 $get_user1=$wpdb->get_results($get_user,ARRAY_A);
 
 $msg_value = "";
 $curr_offer_banked = "SELECT * FROM reedemer_user_bank_offer where user_id = ".$get_user1[0]['id']." && offer_id = ".$_GET['offer'];
$curr_offer_banked1 = $wpdb->get_results($curr_offer_banked,ARRAY_A);

if(isset($curr_offer_banked1) && !empty($curr_offer_banked1))
{

$msg_value = "banked";

}

 $curr_offer_passed = "SELECT * FROM reedemer_user_passed_offer where user_id = ".$get_user1[0]['id']." && offer_id = ".$_GET['offer'];
$curr_offer_passed1 = $wpdb->get_results($curr_offer_passed,ARRAY_A);


if(isset($curr_offer_passed1) && !empty($curr_offer_passed1))
{

$msg_value = "passed";

}


$offer_id = $_GET['offer'];
$created_by = $wpdb->get_results("select usr.membership_level,usr.id,rof.* from users as usr, reedemer_offer as rof where rof.created_by = usr.id && rof.status = 1 && usr.status = 1 && rof.id = $offer_id" );

foreach($created_by as $created_bys) {
	$membership_level = $created_bys->membership_level;
	$user_id = $created_bys->created_by;
	$offer_id = $created_bys->id;
	$cat_id = $created_bys->cat_id;
	$cat_id = $created_bys->cat_id;
}
				


$offer_details="SELECT usr.id, usr.location, usr.company_name, usr.first_name, usr.last_name, usr.membership_level , usr.address, usr.zipcode, usr.lat, usr.lng, usr.email, usr.mobile, usr.web_address, usr.password, usr.subcat_id, usr.owner, usr.create_offer_permission, usr.status,usr.approve,usr.type,usr.remember_token,usr.device_token,usr.source,usr.created_at,usr.updated_at, ofr.id,ofr.campaign_id,ofr.cat_id,ofr.subcat_id,ofr.offer_description,ofr.max_redeemar,ofr.redeem_offer,ofr.price,ofr.pay,ofr.start_date,ofr.end_date,ofr.what_you_get,ofr.more_information,ofr.pay_value,ofr.retails_value,ofr.include_product_value,ofr.discount,ofr.value_calculate,ofr.validate_after,ofr.validate_within,ofr.zipcode,ofr.latitude,ofr.longitude,ofr.status,ofr.created_by,ofr.offer_image,ofr.offer_image_path,ofr.offer_large_image_path,ofr.created_at,ofr.updated_at, ps.setting_val,ps.price_range_id,ps.created_by,ps.created_at,ps.updated_at FROM reedemer_offer AS ofr, users as usr, reedemer_partner_settings as ps WHERE ofr.id = ".$_GET['offer']." && ofr.published = 'true' &&  ofr.created_by = usr.id && ofr.created_by = ps.created_by";
//echo $offer_details;
$offer_details_res=$wpdb->get_results($offer_details,ARRAY_A);
//print_r($offer_details_res);
// $offer_details_res[0]['membership_level'] = 3;
if($membership_level == 1){

	

$right_sidebar = "SELECT ro.*,usr.location, SQRT(POW(69.1 * (ro.latitude - $lat_dis), 2) + POW(69.1 * ($lon_dis - ro.longitude) * COS(latitude / 57.3), 2)) AS distance FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && ro.id != $offer_id && ro.created_by != $user_id && ro.cat_id = $cat_id HAVING distance < $min_distance  ORDER BY RAND() limit 4";	
	
$right_sidebar_rand= "SELECT ro.*,usr.location, SQRT(POW(69.1 * (ro.latitude - $lat_dis), 2) + POW(69.1 * ($lon_dis - ro.longitude) * COS(latitude / 57.3), 2)) AS distance FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && ro.id != $offer_id && ro.created_by != $user_id HAVING distance < $min_distance  ORDER BY RAND() limit 4";	
	
$count_val = $wpdb->get_results($right_sidebar);
if(count($count_val) > 0){
	$right_sidebar1 = $wpdb->get_results($right_sidebar,ARRAY_A);
}else {
	$right_sidebar1 = $wpdb->get_results($right_sidebar_rand,ARRAY_A);	
}
	


$bottom_grid = "SELECT ro.*,usr.location, SQRT(POW(69.1 * (ro.latitude - $lat_dis), 2) + POW(69.1 * ($lon_dis - ro.longitude) * COS(latitude / 57.3), 2)) AS distance FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && ro.id != $offer_id HAVING distance < $min_distance ORDER BY RAND() limit 6";	


$bottom_grid1=$wpdb->get_results($bottom_grid,ARRAY_A);
}

if($membership_level == 4){


$right_sidebar = "SELECT ro.*,usr.location, SQRT(POW(69.1 * (ro.latitude - $lat_dis), 2) + POW(69.1 * ($lon_dis - ro.longitude) * COS(latitude / 57.3), 2)) AS distance FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && ro.id != $offer_id && ro.created_by != $user_id HAVING distance < $min_distance  ORDER BY RAND() limit 4";

$right_sidebar1 = $wpdb->get_results($right_sidebar,ARRAY_A);

$bottom_grid = "SELECT ro.*,usr.location, SQRT(POW(69.1 * (ro.latitude - $lat_dis), 2) + POW(69.1 * ($lon_dis - ro.longitude) * COS(latitude / 57.3), 2)) AS distance FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && cat_id = $cat_id && id != $offer_id HAVING distance < $min_distance ORDER BY RAND() limit 6";	
$bottom_grid1=$wpdb->get_results($bottom_grid,ARRAY_A);
// print_r($bottom_grid1);
}

if($membership_level == 5){

$right_sidebar = "SELECT usr.id, usr.location, usr.first_name, usr.last_name, usr.address, usr.zipcode, usr.lat, usr.lng, usr.email, usr.mobile, usr.web_address, usr.password, usr.cat_id, usr.subcat_id, usr.owner, usr.create_offer_permission, usr.status,usr.approve,usr.type,usr.remember_token,usr.device_token,usr.source,usr.created_at,usr.updated_at, ofr.id,ofr.campaign_id,ofr.cat_id,ofr.subcat_id,ofr.offer_description,ofr.max_redeemar,ofr.redeem_offer,ofr.price,ofr.pay,ofr.start_date,ofr.end_date,ofr.what_you_get,ofr.more_information,ofr.pay_value,ofr.retails_value,ofr.include_product_value,ofr.discount,ofr.value_calculate,ofr.validate_after,ofr.validate_within,ofr.zipcode,ofr.latitude,ofr.longitude,ofr.status,ofr.created_by,ofr.offer_image,ofr.offer_image_path,ofr.created_at,ofr.updated_at, ps.setting_val,ps.price_range_id,ps.created_by,ps.created_at,ps.updated_at FROM reedemer_offer AS ofr, users as usr, reedemer_partner_settings as ps WHERE ofr.cat_id = ".$offer_details_res[0]['cat_id']." && ofr.created_by = ".$offer_details_res[0]['created_by']."  && ofr.id != ".$_GET['offer']." && ofr.created_by = usr.id && ofr.created_by = ps.created_by  ORDER BY RAND() limit 4";
  // echo $right_sidebar;
$right_sidebar1 = $wpdb->get_results($right_sidebar,ARRAY_A);

$bottom_grid = "SELECT ro.*,usr.location FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && usr.location = '$default_loc' && ro.created_by = $user_id && ro.id != $offer_id ORDER BY RAND() limit 6";	
$bottom_grid1=$wpdb->get_results($bottom_grid,ARRAY_A);
// print_r($bottom_grid1);

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
     <!--<link href="<?php bloginfo('template_directory'); ?>/custom.css" rel="stylesheet">-->

     <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/fonts/font-awesome/css/font-awesome.min.css">	 
    <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/rlightbox/css/ui-lightness/jquery-ui-1.8.16.custom.css" />
    <link type="text/css" rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/rlightbox/css/lightbox.css" />  
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
      
<!-- Latest compiled JavaScript -->
<?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
  <?php get_header(); ?>
<?php 
 if (!is_user_logged_in())
{
?>
<script>
     $(document).ready(function(){

         $("#bank_it").click(function(e){
            e.preventDefault();
            location.assign("<?php echo site_url(); ?>/index.php/signin/");
            });

         $("#pass_it").click(function(e){
            e.preventDefault();
            location.assign("<?php echo site_url(); ?>/index.php/signin/");
            });
     }); 
</script>
<?php
}else
{ ?>

<script type="text/javascript">
    $(document).ready(function(){
		
// $('#dialog_box').dialog();

 $("#bank_it").click(function(e){
	 
    e.preventDefault();
offer_message = $(this).parent();
if( $(offer_message).attr("offer_message") == "passed" )
{

    alert("You Have Already Passed This Offer");

}else{

var user_id = $(this).attr("user");
var offer_id = $(this).attr("offer_id");

        $.ajax({
        type: "POST",
        url: "<?php echo site_url() ?>/index.php/bank-it/",
        //url: '<?php echo site_url(); ?>/admin/public/index.php/bridge/bankoffer?data={"webservice_name":"bankoffer","user_id":'+user_id+',"offer_id":'+offer_id+'}',
         data:{"user_id":user_id,"offer_id":offer_id},
        //data:"{'webservice_name':'bankoffer','user_id':1,'offer_id':6}",

        success: function(data){
           var obj = $.parseJSON(data)
           console.log(obj);
			

          if(obj.status_result == "R01001")
          {
            $(offer_message).attr("offer_message","banked");
            $("#save_offer_count").html(obj.new_saved_count);
            alert("You Have Successfully Banked This Offer");
            $(".select-buttons").html("You Have Successfully Banked This Offer");
          }
          if(obj.status_result == "R01002")
          {
           
            $(offer_message).attr("offer_message","banked");
            alert("You Have Already Banked This Offer");
          }
        }

        });
    }

    });
			/*for header autocomplete search*/
		
		$('#deal_cat').blur(function(){
		$("#suggesstion-box-cat").css("display","none");
		});

		$('#suggesstion-box-cat').on('mousedown', function(event) {
		event.preventDefault();
		}).on('click', '.cat-list>li', function() {
		$('#deal_cat').val(this.textContent).blur();
		});
	
		
	
	
		$(document).on("keyup","#deal_cat",function(e){
			var code = e.which;
			
			if(code == 13){
			   	$("#search_deal_btn_other").trigger("click");
				
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
				
			//$("#suggesstion-box-cat").show();
			//$("#suggesstion-box-cat").html(data);
			//$("#deal_cat").css("background","#FFF");
			if(data === 'null'){return false;}else{
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
			$('#deal_cat').val(text);
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
					
					var cat_id = $('.background').data('cat_id');
					var sub_catid = $('.background').data('sub_catid');
					$('#deal_catid').val(cat_id);
			    	$('#deal_subcatid').val(sub_catid);
					
					
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
					
					var cat_id = $('.background').data('cat_id');
					var sub_catid = $('.background').data('sub_catid');
					$('#deal_catid').val(cat_id);
			    	$('#deal_subcatid').val(sub_catid);
					
					
				 }else if(li.is( ".background" ) && e.which === 13){
					
					$('#deal_cat').val($('.background').text());
					 li.removeClass('background');
					 
				}
			});	
				
				
				
			}
	});
			
			}
			
		});
			

  $("#pass_it").click(function(e){
	var user_id = $(this).attr("user");
	var offer_id = $(this).attr("offer_id");
   
        $.ajax({
        type: "POST",
        url: "<?php echo site_url() ?>/index.php/pass-it/",
        //url: '<?php echo site_url(); ?>/index.php/bridge/passoffer?data={"webservice_name":"bankoffer","user_id":'+user_id+',"offer_id":'+offer_id+'}',
        data:{"user_id":user_id,"offer_id":offer_id},

        success: function(data){

          var obj = $.parseJSON(data)
          console.log(obj);

          if(obj.status_result == "R01001")
          {
            $(offer_message).attr("offer_message","passed");
            alert("You Have Successfully Passed This Offer");
            $(".product-details").html("<h2>YOU HAVE PASSED THIS OFFER</h2>");
            
          }
         if(obj.status_result == "R01002")
          {
             $(offer_message).attr("offer_message","passed");
            alert("You Have Already Passed This Offer");
          }
        }
        });

     });

    });

  //To select category name
function selectCategory(val, cid, subid) {
 // alert('feee');
$('.cat-list>li').removeClass('background');
$("#deal_cat").val(val);
$("#deal_catid").val(cid);
$("#deal_subcatid").val(subid);
$("#search_deal_btn_other").trigger("click");
} 
</script>
 <?php } ?>

<!-- Deal SEARCH METHOD END -->
<div id="OfferDetails">

<div class="container">
    <div class="row">
         <div class="col-md-9 col-sm-9 product-details">
            <h2><?php  echo $offer_details_res[0]['offer_description'];  ?></h2>
			 <?php
				$img_explod = explode('/',$offer_details_res[0]['offer_large_image_path']);
				if($img_explod[0] == 'http:'){
				$img_offers = $offer_details_res[0]['offer_large_image_path'];
				}else{
				$img_offers = home_url().'/'.$offer_details_res[0]['offer_large_image_path'];

				}


				$img_logo = $wpdb->get_results("select logo_name from reedemer_logo where reedemer_id = '".$offer_details_res[0]['created_by']."' && default_logo = 1");
			 ?>
			 <div class="deal-d-big">
				 <img src="<?php  echo $img_offers; ?>" class="img-responsive">
			 <?php foreach($img_logo as $new_img_logo){
				 
				 			$new_pic_logo=$new_img_logo->logo_name;
							$str = $new_pic_logo;
							$tes = explode(".",$str);
							if($tes[1]=='jpg'){$final_logo_image= $tes[0].".png";}
							else{$final_logo_image=$new_pic_logo ;}
				echo '<span class="deal-d-float"><img src="'.home_url().'/filemanager/userfiles/large/'.$final_logo_image.'" alt="img"></span>';
				 }?>
            
			</div>
			 <div class="product-savings">
						<?php 		 		
							//echo "SELECT * FROM `reedemer_offer` WHERE id = $offers->id";
							$id_dts = $offer_details_res[0]['id'];
							$offer_prc = $wpdb->get_results("SELECT * FROM `reedemer_offer` WHERE id = '$id_dts' && status = 1");
							
						foreach($offer_prc as $off_prc){

						if($off_prc->discount > 0) {

						?>
						<span class="savings">
							<?php 
							/*$prc_val = ($off_prc->pay_value/$off_prc->retails_value); 
							$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
							$tot_per = ceil(100 - $percent_friendly);
							echo $tot_per."%OFF";*/
							?>
							
							<?php
							$offer_mode= $off_prc->value_calculate;
							if ($offer_mode=='2') {
							$prc_val = ($off_prc->pay_value/$off_prc->retails_value);
							$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
							$tot_per = ceil(100 - $percent_friendly);
							$offer_type= $off_prc->value_text;
							$offer_mode= $off_prc->value_calculate;
							if ($offer_type=='1'){$offer_type_value='OFF';}
							elseif ($offer_type=='2'){$offer_type_value='DISCOUNT';}
							elseif ($offer_type=='3'){$offer_type_value='SAVINGS';}
							else{$offer_type_value='OFF';}
							echo $tot_per."%".$offer_type_value;
							}
							else{
							$prc_val = ($off_prc->retails_value - $off_prc->pay_value);
							$tot_per = ceil($prc_val);
							$offer_type= $off_prc->value_text;
							$offer_mode= $off_prc->value_calculate;
							if ($offer_type=='1'){$offer_type_value='OFF';}
							elseif ($offer_type=='2'){$offer_type_value='DISCOUNT';}
							elseif ($offer_type=='3'){$offer_type_value='SAVINGS';}
							else{$offer_type_value='OFF';}
							echo "$".$tot_per."".$offer_type_value;
							}
							?>
							
						</span>
						<span class="pricesection">
							<color><?php echo "$".$off_prc->retails_value; ?></color>
							<?php echo "$".$off_prc->pay_value; ?>
						</span>

						<?php }else { ?>

						<span class="pricesection" style="border:none;">
							<?php echo "$".$off_prc->pay_value; ?>
						</span>

						<?php } 

						}?>
				 <div class="col-expires" id="save_offer_count">
					 <?php 
					 $saved_count_qury= "SELECT * FROM `reedemer_user_bank_offer` WHERE `offer_id`= $offer_id ";
					 $new_saved_count_qury = $wpdb->get_results($saved_count_qury ,ARRAY_A);
					 $saved_count= count($new_saved_count_qury);					 
					 echo $saved_count." Saved It";?>
					 </div>
				</div>
			 
			 
			 
            
            <div class="select-buttons" offer_message="<?php echo $msg_value; ?>">
			<?php 
			$new_offer_id=$offer_details_res[0]['id'];
			$new_user_id=$get_user1[0]['id'];
			$check_offer_query = "SELECT * FROM `reedemer_user_bank_offer` WHERE `offer_id` = $new_offer_id && `user_id`= $new_user_id";
			$check_offer_query = $wpdb->get_results($check_offer_query ,ARRAY_A);
			$check_offer_query_count= count($check_offer_query);
			if($check_offer_query_count==0)
			{
			?>
                <a href="#" id="pass_it" user = "<?php echo $get_user1[0]['id']; ?>" offer_id = "<?php echo $offer_details_res[0]['id'] ; ?>"  >Pass offer</a>
                <a href="#" id="bank_it" user = "<?php echo $get_user1[0]['id'] ; ?>" offer_id = "<?php echo $offer_details_res[0]['id'] ; ?>">Bank Offer</a>
                <?php 
            }
                 else
                 {echo "You already banked this offer";}?>
            </div>
            <div class="clear"></div>
            <div class="pro-content">
                <h3><?php echo $offer_details_res[0]['company_name']; ?></h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <h3>What You Get</h3>
                <p><?php echo $offer_details_res[0]['what_you_get']; ?></p>
            </div>
            <div class="clear"></div>
            <div class="contact">
                <div class="map">
                    			
					
					<div class="map_ico">
			<?php 
					$offer_id = $_GET['offer'];
					$add_rss = $offer_details_res[0]['address'];
					$markers = array(
						     array(
						     "$add_rss",
						      $offer_details_res[0]['lat'],
                                                      $offer_details_res[0]['lng']		
						   )
						);
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
					height: 100%;
				}
			/*.map_ico {
				margin-bottom: 60px;
				max-height: 400px;
			}*/


			</style>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDw-L-AcQvJIgTXJGYJSH3Ad4fnwFdQ10U"></script>

			<!--<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"
			  type="text/javascript"></script>-->	
			<script>

				function initialize() {
					var map;
					var bounds = new google.maps.LatLngBounds();
					var mapOptions = {
						mapTypeId: "roadmap",
						center: new google.maps.LatLng(52.791331, -1.918728), // somewhere in the uk BEWARE center is required
						zoom: 20,
					};

					// Display a map on the page
					map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
					map.setTilt(45);

					// Multiple Markers
					var markers = <?php echo json_encode( $markers ); ?>;

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
							map: map,
							title: markers[i][0]  
						});



						// Allow each marker to have an info window
						/*google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
							return function () {
						var mar_img = markers[i][5];
						var mar_name = markers[i][4];		
						html = mar_img + '<br>' + mar_name;

								infoWindow.setContent(html);
								infoWindow.open(map, marker);
							}
						})(marker, i));

					    google.maps.event.addListener(marker, 'mouseout', (function (marker, i) {
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
						this.setZoom(18);
						google.maps.event.removeListener(boundsListener);
					});

				}
				google.maps.event.addDomListener(window, 'load', initialize);


			</script>

			</div>
					
					
					
                </div>
                <div class="address">
                    <span>
                        <i class="fa fa-map-marker" aria-hidden="true"></i><br>
                        <?php echo $offer_details_res[0]['company_name']; ?>
                    </span>
                    <p><?php echo $offer_details_res[0]['address']; ?></p>
                   
                </div>
            </div>
        </div>
         <div class="col-md-3 col-sm-3 product-list">
			<?php  if($membership_level != 5){
			foreach($right_sidebar1 as $right_sidebar) { ?>
			 
            <div class="product-box">
                <a href="<?php echo home_url(); ?>/index.php/deal-details/?offer=<?php echo $right_sidebar['id']; ?>">
					<div class="home-page-deal-pic">
						<?php
						$img_explod = explode('/',$right_sidebar['offer_image_path']);
						if($img_explod[0] == 'http:'){
						$img_offers = $right_sidebar['offer_image_path'];
						}else{
						$img_offers = home_url().'/'.$right_sidebar['offer_image_path'];
						}
						
						$img_logo = $wpdb->get_results("select logo_name from reedemer_logo where reedemer_id = '".$right_sidebar['created_by']."' && default_logo = 1");
			 			?>
						
						<?php foreach($img_logo as $new_img_logo){
							
							$new_pic_logo=$new_img_logo->logo_name;
							$str = $new_pic_logo;
							$tes = explode(".",$str);
							if($tes[1]=='jpg'){$final_logo_image= $tes[0].".png";}
							else{$final_logo_image=$new_pic_logo ;}
							echo '<span class="floate-pic"><img src="'.home_url().'/filemanager/userfiles/small/'.$final_logo_image.'" alt="img"></span>';
				 		}?>
                        <img src="<?php echo $img_offers; ?>" alt="img01" class="img-responsive">
							
						</div>
                        <div class="tab-product">
                            <div class="product-title">
								<?php if(strlen($right_sidebar['offer_description']) > 40) { 
									echo substr($right_sidebar['offer_description'],0,40)."....";
								} else { 
									echo $right_sidebar['offer_description'];
								} ?>
							</div>
							
							<div class="product-savings">
							<?php 		 		
								$sim_id = $right_sidebar['id'];
														
								$offer_prc = $wpdb->get_results("SELECT * FROM `reedemer_offer` WHERE id = $sim_id && status = 1");
							foreach($offer_prc as $off_prc){							
								
								$cmp_id = $off_prc->created_by;	
								$offer_lat = $off_prc->latitude;
								$offer_lon = $off_prc->longitude;

							if($off_prc->discount > 0) {

							?>
							<span class="savings">
								<?php 
								/*$prc_val = ($off_prc->pay_value/$off_prc->retails_value); 
								$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
								$tot_per = ceil(100 - $percent_friendly);
								
								echo $tot_per."%OFF";*/
								?>
								
								<?php
								$offer_mode= $off_prc->value_calculate;
								if ($offer_mode=='2') {
								$prc_val = ($off_prc->pay_value/$off_prc->retails_value);
								$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
								$tot_per = ceil(100 - $percent_friendly);
								$offer_type= $off_prc->value_text;
								$offer_mode= $off_prc->value_calculate;
								if ($offer_type=='1'){$offer_type_value='OFF';}
								elseif ($offer_type=='2'){$offer_type_value='DISCOUNT';}
								elseif ($offer_type=='3'){$offer_type_value='SAVINGS';}
								else{$offer_type_value='OFF';}
								echo $tot_per."%".$offer_type_value;
								}
								else{
								$prc_val = ($off_prc->retails_value - $off_prc->pay_value);
								$tot_per = ceil($prc_val);
								$offer_type= $off_prc->value_text;
								$offer_mode= $off_prc->value_calculate;
								if ($offer_type=='1'){$offer_type_value='OFF';}
								elseif ($offer_type=='2'){$offer_type_value='DISCOUNT';}
								elseif ($offer_type=='3'){$offer_type_value='SAVINGS';}
								else{$offer_type_value='OFF';}
								echo "$".$tot_per."".$offer_type_value;
							}
							?>
							</span>
							<span class="pricesection">
								<color><?php echo "$".$off_prc->retails_value; ?></color>
								<?php echo "$".$off_prc->pay_value; ?>
							</span>

							<?php }else { ?>

							<span class="pricesection" style="border-top:none;">
								<?php echo "$".$off_prc->pay_value; ?>
							</span>

							<?php } 

							}?>
                        </div>
						<div class="col-expires">
							<img src="<?php echo get_template_directory_uri(); ?>/images/location.png" alt="location" class="img-responsive" />
							
							<?php 
														
								$cmp_id = $right_sidebar['created_by'];
								$cmp_nam = $wpdb->get_results("SELECT `location` FROM `users` WHERE id = $cmp_id");
				 				foreach($cmp_nam as $cmp_nms) {         
									echo $cmp_nms->location." (";  
								}             
								if($default_loc != ''){

									$address = $default_loc;
									$latLong = getLatLong($address);
									$lat = $latLong['latitude'];
									$lon = $latLong['longitude'];

								}else {

								  $lat = "40.9312099";
								  $lon = "-73.89874689999999";
								}
								echo floor(distance($lat, $lon, $offer_lat, $offer_lon, "M"))." Miles)"; ?>
							
                         </div>
                              </div>
                         </a>   
            </div>
            <?php } 
				}else { ?>
					<div class="product-box">
			 		<h4>Galery</h4>
			 		<div class="vertical-slider">
					   <div id="carousel">
							<a href="http://vimeo.com/13763341" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider1.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider2.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider2.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider3.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider3.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider4.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider4.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider5.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider5.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider6.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider6.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider1.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider1.jpg" class="img-responsive"/></a>
							<a href="<?php echo get_template_directory_uri(); ?>/images/v_slider2.jpg" class="lb_gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/v_slider2.jpg" class="img-responsive"/></a>
						</div>
							<a href="#" id="ui-carousel-next"><span>next</span></a>
							<a href="#" id="ui-carousel-prev"><span>prev</span></a>
					</div>
					</div>
				<?php }?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="separator"></div>
<div class="clear"></div>

<!-- Product Grid -->
<div class="product-grid container">
        <div class="row">
            <div class="col-md-12">
                <h2>More deals</h2>
				<div class="row">
                  <?php 
					$partners_id = $offer_details_res[0]['created_by'];

					$bottom_grid = "SELECT ro.*,usr.location, SQRT(POW(69.1 * (ro.latitude - $lat_dis), 2) + POW(69.1 * ($lon_dis - ro.longitude) * COS(latitude / 57.3), 2)) AS distance FROM `reedemer_offer` as ro INNER JOIN `users` as usr ON ro.created_by = usr.id  WHERE ro.status = 1 && ro.published = 'true' && ro.created_by = $partners_id && ro.id != $offer_id HAVING distance < $min_distance ORDER BY RAND() limit 6";


					$bottom_grid1 = $wpdb->get_results($bottom_grid,ARRAY_A);
					

					if(isset($bottom_grid1) && !empty($bottom_grid1)){
						$k = 1;

            foreach ($bottom_grid1 as $grid_value) {
                ?>
                <div class="col-md-4 col-sm-4">
                    <a href="<?php echo home_url(); ?>/index.php/deal-details/?offer=<?php echo $grid_value['id']; ?>">
						<div class="deal-d-mid">
						<?php
						$img_explod = explode('/',$grid_value['offer_medium_image_path']);
						if($img_explod[0] == 'http:'){
						$img_offers = $grid_value['offer_medium_image_path'];
						}else{
						$img_offers = home_url().'/'.$grid_value['offer_medium_image_path'];
						}
						$img_logo = $wpdb->get_results("select logo_name from reedemer_logo where reedemer_id = '".$grid_value['created_by']."' && default_logo = 1");
						
			 			?>
						<?php foreach($img_logo as $new_img_logo){
							
							$new_pic_logo=$new_img_logo->logo_name;
							$str = $new_pic_logo;
							$tes = explode(".",$str);
							if($tes[1]=='jpg'){$final_logo_image= $tes[0].".png";}
							else{$final_logo_image=$new_pic_logo ;}
							echo '<span class="deal-d-float1"><img src="'.home_url().'/filemanager/userfiles/medium/'.$final_logo_image.'" alt="img"></span>';
				 		}?>
                        <img src="<?php echo $img_offers; ?>" alt="img01" class="img-responsive">
							</div>
                        <div class="product">
                            <div class="product-title">
								<?php if(strlen($grid_value['offer_description']) > 55) { 
									echo substr($grid_value['offer_description'],0,55)."....";
								} else { 
									echo $grid_value['offer_description'];
								} ?>
							</div>
							
							<div class="product-savings">
							<?php 		 		
								$sim_id = $grid_value['id'];
								//echo "SELECT * FROM `reedemer_offer` WHERE id = $offers->id";
								$offer_prc = $wpdb->get_results("SELECT * FROM `reedemer_offer` WHERE id = $sim_id && status = 1");
							foreach($offer_prc as $off_prc){
								
							$cmp_id = $off_prc->created_by;	
							$offer_lat = $off_prc->latitude;
							$offer_lon = $off_prc->longitude;	

							if($off_prc->discount > 0) {

							?>
							<span class="savings">
								<?php 
								/*$prc_val = ($off_prc->pay_value/$off_prc->retails_value); 
								$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
								$tot_per = ceil(100 - $percent_friendly);
								echo $tot_per."%OFF";*/
								?>
								<?php
								$offer_mode= $off_prc->value_calculate;
								if ($offer_mode=='2') {
								$prc_val = ($off_prc->pay_value/$off_prc->retails_value);
								$percent_friendly = number_format( $prc_val * 100, 2 ) . '%';
								$tot_per = ceil(100 - $percent_friendly);
								$offer_type= $off_prc->value_text;
								$offer_mode= $off_prc->value_calculate;
								if ($offer_type=='1'){$offer_type_value='OFF';}
								elseif ($offer_type=='2'){$offer_type_value='DISCOUNT';}
								elseif ($offer_type=='3'){$offer_type_value='SAVINGS';}
								else{$offer_type_value='OFF';}
								echo $tot_per."%".$offer_type_value;
								}
								else{
								$prc_val = ($off_prc->retails_value - $off_prc->pay_value);
								$tot_per = ceil($prc_val);
								$offer_type= $off_prc->value_text;
								$offer_mode= $off_prc->value_calculate;
								if ($offer_type=='1'){$offer_type_value='OFF';}
								elseif ($offer_type=='2'){$offer_type_value='DISCOUNT';}
								elseif ($offer_type=='3'){$offer_type_value='SAVINGS';}
								else{$offer_type_value='OFF';}
								echo "$".$tot_per."".$offer_type_value;
							}
							?>
							</span>
							<span class="pricesection">
								<color><?php echo "$".$off_prc->retails_value; ?></color>
								<?php echo "$".$off_prc->pay_value; ?>
							</span>

							<?php }else { ?>

							<span class="pricesection" style="border-top:none;">
								<?php echo "$".$off_prc->pay_value; ?>
							</span>

							<?php } 

							}?>
                        </div>
						<div class="col-expires">
							<img src="<?php echo get_template_directory_uri(); ?>/images/location.png" alt="location" class="img-responsive" />
							 <?php 
				
								$cmp_id = $grid_value['created_by'];
								$cmp_nam = $wpdb->get_results("SELECT `location` FROM `users` WHERE id = $cmp_id");
				 				foreach($cmp_nam as $cmp_nms) {         
									echo $cmp_nms->location." (";  
								}             
								if($default_loc != ''){

									$address = $default_loc;
									$latLong = getLatLong($address);
									$lat = $latLong['latitude'];
									$lon = $latLong['longitude'];

								}else {

								  $lat = "40.9312099";
								  $lon = "-73.89874689999999";
								}
								echo floor(distance($lat, $lon, $offer_lat, $offer_lon, "M"))." Miles)"; ?>
                         </div>
                              </div>
                         </a>
                    </div>
                <?php 
					if($k%3 == 0)
							{
								echo   '</div><div class="row">' ;
							}
						$k++;
               	}
                 
                    
                }else{ echo "<h2>NO More Deals Data Available</h2>";}

                ?>

            </div>

        </div>




        </div>
</div>

<div id="dialog_box"></div>

<!-- Product Grid -->

<div class="clear"></div>


</div>

<!-- CLOSE THE DEAL DETAISL -->

<div class="clear"></div>



<!-- SEARCH DIV END -->
<div class="clear"></div>


<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.rcarousel.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.ui.rlightbox.min.js"></script>	
<script type="text/javascript">
    jQuery(function($) {
        $( ".lb_gallery" ).rlightbox({
            videoHeight:385,
            videoWidth:640
        });


        $("#carousel").rcarousel({
            orientation: "vertical"
        }); 
        
       
        $( "#ui-carousel-next" ).add( "#ui-carousel-prev" ).hover(
                function() {
                    $( this ).css( "opacity", 0.7 );
                },
                function() {
                    $( this ).css( "opacity", 1.0 );
                }
            );                  
    });
</script>	

<?php get_footer(); ?>
