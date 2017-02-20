<?php 
    $menustyle   = @$profile->vcard_name != '' || @$profile->vcard_name != null ? '' : 'display:none';

    $name        = @$profile->vcard_name != '' || @$profile->vcard_name != null ? @$profile->vcard_name : 'Vcard Not Found.';
    $work        = @$profile->vcard_work != '' || @$profile->vcard_work != null ? @$profile->vcard_work : ' -';
    $dob         = @$profile->vcard_date_of_birth != '' || @$profile->vcard_date_of_birth != null ? tgl_format(@$profile->vcard_date_of_birth) : ' -';
    $address     = @$profile->vcard_address != '' || @$profile->vcard_address != null ? @$profile->vcard_address : ' -';
    $email       = @$profile->vcard_email != '' || @$profile->vcard_email != null ? @$profile->vcard_email : ' -';
    $phone       = @$profile->vcard_phone != '' || @$profile->vcard_phone != null ? @$profile->vcard_phone : ' -';
    $website     = @$profile->vcard_website != '' || @$profile->vcard_website != null ? @$profile->vcard_website : ' -';
    $description = @$profile->vcard_description != '' || @$profile->vcard_description != null ? @$profile->vcard_description : ' -';
    $img         = @$profile->vcard_image != '' || @$profile->vcard_image != null ? 'vcard/'.@$profile->vcard_image : 'vcard/no-vcard.jpg';

?>
<!-- Profile -->
<div id="profile"> 
 	<!-- About section -->
	<div class="about">
    	<div class="photo-inner"><img src="<?php echo $img; ?>" height="186" width="153" /></div>
        <h1><?php echo $name;?></h1>
        <h3><?php echo $work;?></h3>
        <p><?php echo $description;?></p>
    </div>
    <!-- /About section -->
     
    <!-- Personal info section -->
	<ul class="personal-info">
		<li><label>Name</label><span><?php echo $name;?></span></li>
        <li><label>Date of birth</label><span><?php echo $dob;?></span></li>
        <li><label>Address</label><span><?php echo $address;?></span></li>
        <li><label>Email</label><span><?php echo $email;?></span></li>
        <li><label>Phone</label><span><?php echo $phone;?></span></li>
        <li><label>Website</label><span><?php echo $website;?></span></li>
    </ul>
    <!-- /Personal info section -->
</div>        
<!-- /Profile --> 

<!-- Menu -->
<div class="menu">
	<ul class="tabs" style="<?php echo $menustyle; ?>">
    	<li><a href="#profile" class="tab-profile">Profile</a></li>
    	<li><a href="#resume" class="tab-resume">Resume</a></li>
    	<li><a href="#portfolio" class="tab-portfolio">Portfolio</a></li>
    	<li><a href="#contact" class="tab-contact">Contact</a></li>
    </ul>
</div>
<!-- /Menu --> 

<!-- Resume -->
<div id="resume">
	<div class="timeline-section">
        <!-- Timeline for Employment  -->   
        <h3 class="main-heading"><span>Employment</span></h3>   
        <ul class="timeline">
            <?php
                foreach ($resume_employment as $key => $value) {
                    ?>
                        <li>
                                               
                            <div class="timelineUnit">
                                <h4><?php echo $value->resume_position ; ?><span class="timelineDate"><?php echo $value->resume_period ; ?></span></h4>
                                <h5><?php echo $value->resume_sub ; ?></h5>
                                <p><?php echo $value->resume_description ; ?></p>
                            </div>
                        </li>
                    <?php
                }
            ?>
            <div class="clear"></div>
        </ul> 
        <!-- /Timeline for Employment  -->

        <!-- Timeline for Education  -->   
        <h3 class="main-heading"><span>Education</span></h3>   
         <ul class="timeline">
            <?php
                foreach ($resume_education as $key => $value) {
                    ?>
                        <li>
                                               
                            <div class="timelineUnit">
                                <h4><?php echo $value->resume_position ; ?><span class="timelineDate"><?php echo $value->resume_period ; ?></span></h4>
                                <h5><?php echo $value->resume_sub ; ?></h5>
                                <p><?php echo $value->resume_description ; ?></p>
                            </div>
                        </li>
                    <?php
                }
            ?>
            <div class="clear"></div>
        </ul> 
        <!-- /Timeline for Education  -->              
    </div>
    <div class="skills-section">
        <!-- Skills -->
        <?php 
            foreach ($skill as $key => $value) {
                ?>
                    <h3 class="main-heading"><span><?php echo str_replace('_',' ',$key); ?></span></h3> 
                    <ul class="skills">
                        <?php
                            foreach ($value as $key2 => $value2) {
                                ?>
                                    <li>
                                        <h4><?php echo $value2['name']; ?></h4>
                                        <span class="rat<?php echo $value2['range']; ?>"></span>
                                    </li>
                                <?php
                            }
                        ?>
                    </ul>
                <?php
            }
        ?>
     <!-- /Skills -->
    </div>
</div>
<!-- /Resume --> 
                        
<!-- Portfolio -->
<div id="portfolio">

    <ul id="portfolio-filter">
        <li><a href="" class="current menu-prtfolio" data-filter="*">All</a></li>
        <?php
            foreach ($portfolio_list as $key => $value) {
                ?>
                    <li><a href="" class="menu-prtfolio" data-filter=".<?php echo $key; ?>"><?php echo $value; ?></a></li>
                <?php
            }
        ?>
    </ul>
    <div class="extra-text">Some of the projects i'm proud with</div>
    <ul id="portfolio-list">
        <?php 
            foreach ($portfolio as $key => $value) {
                ?>
                        <li class="<?php echo $value['class'];?>">
                            <a href="<?php echo $value['href'];?>" title="<?php echo $value['href_title'];?>" rel="portfolio" class="<?php echo $value['href_class'];?>">
                                <img src="<?php echo $value['src'];?>" alt="<?php echo $value['alt'];?>">
                                <h2 class="title"><?php echo $value['title'];?></h2>
                                <span class="categorie"><?php echo $value['categorie'];?></span> 
                            </a>
                        </li>
                <?php
            }
        ?>
    </ul>
</div>
<!-- /Portfolio -->   

<!-- Contact -->
<div id="contact">
	<div id="map"></div>
	<!-- Contact Info -->
    <div class="contact-info">
    <h3 class="main-heading"><span>Contact info</span></h3>
	<ul>
        <li><?php echo $map->map_full; ?><br /><br /></li>
        <?php 
            foreach ($contact as $key => $value) {
                ?>
                    <li><?php echo $value->contact_type;?> &nbsp;:&nbsp; <?php echo $value->contact_value; ?> </li>
                <?php
            }
        ?>
    </ul>
    </div>
    <!-- /Contact Info -->
    
    <!-- Contact Form -->
    <div class="contact-form">
        <h3 class="main-heading"><span>Let's keep in touch</span></h3>
        <div id="contact-status"></div>
        <form action="" id="contactform">
            <p>
            	<label for="name">Your Name</label>
            	<input type="text" name="name" class="input" >
            </p>
            <p>
            	<label for="email">Your Email</label>
            	<input type="text" name="email" class="input">
            </p>
            <p>
            	<label for="message">Your Message</label>
                <textarea name="message" cols="88" rows="6" class="textarea" ></textarea>
            </p>
            <input type="submit" name="submit" value="Send your message" class="submit">
        </form>
    </div>
    <!-- /Contact Form -->
</div>
<script type="text/javascript">
        /* ---------------------------------------------------------------------- */
        /*  Google Maps
        /* ---------------------------------------------------------------------- */
        
        // Needed variables
        var $content            = $("#content");
        var $map                = $('#map'),
            $tabContactClass    = ('tab-contact'),
            $address            = '<?php echo $map->map_full; ?>';
        
        $content.bind('easytabs:after', function(evt,tab,panel) {
            if ( tab.hasClass($tabContactClass) ) {
                $map.gMap({
                    address: $address,
                    zoom: 16,
                    markers: [
                        { 'address' : $address }
                    ]
                });
            }
        });
</script>