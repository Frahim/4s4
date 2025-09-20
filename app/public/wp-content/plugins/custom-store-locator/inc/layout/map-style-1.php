<?php 
/* Style 1 Layout */
?>
        
<!-- custom-store-locator-1 -->
<section class="sections store_locator_1">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 search_bar">
                <form class="row" action="#" method="get">
                    <?php if ($csl_include_title === "yes") { ?>
                        <div class="col ctm_check">
                            <label for="searchBy">
                                <input name="searchBy" id="searchBy" type="checkbox" value="1"<?php echo isset($_GET['searchBy']) ? ' checked' : ''; ?> /> <span><?php esc_attr_e('Search By Name', 'custom-store-locator'); ?></span>
                            </label>
                        </div>
                    <?php } ?> 
                    <div class="col search_field" id="addressWrapper">
                        <?php if ($csl_autocompletesearchbox === "yes") { ?>
                            <input name="userAddress" id="userAddress" class="autocompleteenabled" type="text" value="<?php echo isset($_GET['userAddress']) ? esc_attr(sanitize_text_field($_GET['userAddress'])) : ''; ?>" placeholder="<?php esc_attr_e('Address or Zipcode', 'custom-store-locator'); ?>" />
                        <?php } else { ?>
                            <input name="userAddress" id="userAddress" type="text" value="<?php echo isset($_GET['userAddress']) ? esc_attr(sanitize_text_field($_GET['userAddress'])) : ''; ?>" placeholder="<?php esc_attr_e('Zipcode', 'custom-store-locator'); ?>" />
                        <?php } ?>
                    </div>
                    <?php 
                        if ($csl_include_cat === "yes") {
                            $csl_locations_categories = get_terms(array(
                                'taxonomy'   => 'csl_locations_categories',
                                'hide_empty' => true, 
                            ));
                            if (!empty($csl_locations_categories)) {
                                echo '<div class="col select_category"><div class="custom_select"><select name="csl-locations-categories">';
                                echo '<option value="">' . esc_html__('Select Category', 'custom-store-locator') . '</option>';
                                foreach ($csl_locations_categories as $csl_locations_category) {
                                    $selectedcat = ($csllocationscategories === $csl_locations_category->name) ? 'selected="selected"' : '';
                                    echo '<option value="' . esc_attr($csl_locations_category->name) . '" ' . esc_attr($selectedcat) . '>' . esc_html($csl_locations_category->name) . '</option>';
                                }
                                echo '</select></div></div>';
                            }
                        }
                    ?>
                    <div class="col locate_me">
                        <a href="#1" class="current_location">
                            <img src="<?php echo esc_url(CSL_URL . '/assets/style/images1/locate-me.png'); ?>" alt="<?php esc_attr_e('current location', 'custom-store-locator'); ?>">
                        </a>
                    </div>
                    <input name="maxRadius" id="maxRadius" type="hidden" value="<?php echo esc_attr(!empty($csl_map_default_radius) ? sanitize_text_field($csl_map_default_radius) : '20'); ?>" min="1" />
                    <div class="col search_btn">
                        <button id="submitLocationSearch" class="site_btn"><?php esc_html_e('Search', 'custom-store-locator'); ?></button>
                    </div>
                    <div class="col reset_btn">
                        <button type="reset" name="reset" id="mapreset" class="site_btn border_btn"><?php esc_html_e('Reset', 'custom-store-locator'); ?></button>
                    </div>
                </form>                
            </div>
            <div class="col-lg-12">
                <h4 id="location-search-alert"><?php esc_html_e('All Locations', 'custom-store-locator'); ?></h4>
            </div>
        </div>
        <div class="row csl-wrapper" id="csl-wrapper">
            <div class="col-lg-7 map_col">
                <div class="map_box">
                    <div id="locations-near-you-map"></div>
                    <div id="floating-panel-map" style="display:none;">
                        <input type="button" value="<?php esc_attr_e('Back to Map', 'custom-store-locator'); ?>" id="togglemap" class="site_btn sm" />
                    </div>
                    <div id="pano" style="display:none;"></div>
                </div>
            </div>
            <div class="col-lg-5 pro_listing_col" id="locations-near-you">
                <?php if ($listing_query->have_posts()) { $i = 0; ?>
                    <div class="listing_bar location-near-you-box">
                        <?php while ($listing_query->have_posts()) : $listing_query->the_post(); 
                            $locid = get_the_ID();
                            $websiteurl = get_post_meta($locid, 'websiteurl', true);
                            $business_phone_number = get_post_meta($locid, 'business_phone_number', true);
                            $business_fax = get_post_meta($locid, 'business_fax', true);
                            $business_contact_email = get_post_meta($locid, 'business_contact_email', true);
                            $business_address = str_replace(array('[\', \']'), '', get_post_meta($locid, 'business_address', true));
                            $business_zip_code = get_post_meta($locid, 'business_zip_code', true);
                            $business_storehours = get_post_meta($locid, 'business_storehours', true);
                            $csl_hide_phone = get_option('csl_hide_phone', '');
                            $csl_hide_email = get_option('csl_hide_email', '');
                            $csl_hide_fax = get_option('csl_hide_fax', '');
                            $csl_hide_website = get_option('csl_hide_website', '');
                            $csl_hide_hours = get_option('csl_hide_hours', '');                        
                        ?>
                            <div class="property_box csl-list-item marker-link" data-markerid="<?php echo esc_attr($i); ?>">
                                <h3><?php the_title(); ?></h3>
                                <ul>
                                    <?php if ($business_address) {
                                        echo '<li><img src="' . esc_url(CSL_URL . '/assets/style/images1/map_marker.png') . '" alt="Marker"><strong>' . esc_html__('Address', 'custom-store-locator') . ': </strong>' . nl2br(esc_html($business_address)) . '</li>';
                                    } ?>
                                    <?php if (!empty($business_zip_code)) {
                                        echo '<li><strong>' . esc_html__('Postal Code', 'custom-store-locator') . ': </strong>' . esc_html($business_zip_code) . '<li>';
                                    } ?>
                                    <?php if (!empty($business_contact_email) && $csl_hide_email !== 'yes') {
                                        echo '<li><strong>' . esc_html__('Email', 'custom-store-locator') . ': </strong><a href="mailto:' . esc_attr($business_contact_email) . '">' . esc_html($business_contact_email) . '</a></li>';
                                    } ?>
                                    <?php if (!empty($business_fax) && $csl_hide_fax !== 'yes') {
                                        echo '<li><strong>' . esc_html__('Fax', 'custom-store-locator') . ': </strong><a href="fax:' . esc_attr(preg_replace('/[^0-9]/', '', $business_fax)) . '">' . esc_html($business_fax) . '</a></li>';
                                    } ?>
                                    <?php if ($business_storehours && $csl_hide_hours !== 'yes') {
                                        echo '<li><strong>' . esc_html__('Store Hours', 'custom-store-locator') . ': </strong>' . nl2br(esc_html($business_storehours)) . '</li>';
                                    } ?>
                                </ul>
                                <div class="btn_bar">
                                    <a href="javascript:;" class="site_btn sm viewmaplink"><?php esc_html_e('View on Map', 'custom-store-locator'); ?></a>
                                    <?php if (!empty($business_phone_number) && $csl_hide_phone !== 'yes') {
                                        echo '<a href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $business_phone_number)) . '" class="site_btn sm white_btn">' . esc_html__('Call', 'custom-store-locator') . '</a>';
                                    } ?>
                                    <?php if (!empty($websiteurl) && $csl_hide_website !== 'yes') {
                                        echo '<a target="_blank" class="site_btn sm white_btn" href="' . esc_url($websiteurl) . '">' . esc_html__('Website', 'custom-store-locator') . '</a>';
                                    } ?>
                                </div>
                            </div>
                        <?php $i++; endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- custom-store-locator-1 -->

   
<script>
    (function($) {
        // select arrow color change
        $('select').on('change', function() {
            if ($(this).val()) {
                return $(this).css('color', '#1e272e');
            } else {
                return $(this).css('color', '#808e9b');
            }
        });
    
        /* Select Tag Styling JS */
        var x, i, j, l, ll, selElmnt, a, b, c;
        /*look for any elements with the class "custom-select":*/
        x = document.getElementsByClassName("custom_select");
        l = x.length;
        for (i = 0; i < l; i++) {
            selElmnt = x[i].getElementsByTagName("select")[0];
            ll = selElmnt.length;
            /*for each element, create a new DIV that will act as the selected item:*/
            a = document.createElement("DIV");
            a.setAttribute("class", "select-selected");
            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
            x[i].appendChild(a);
            /*for each element, create a new DIV that will contain the option list:*/
            b = document.createElement("DIV");
            b.setAttribute("class", "select-items select-hide");
            for (j = 1; j < ll; j++) {
                /*for each option in the original select element,
                create a new DIV that will act as an option item:*/
                c = document.createElement("DIV");
                c.innerHTML = selElmnt.options[j].innerHTML;
                c.addEventListener("click", function(e) {
                    /*when an item is clicked, update the original select box,
                    and the selected item:*/
                    var y, i, k, s, h, sl, yl;
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                    sl = s.length;
                    h = this.parentNode.previousSibling;
                    for (i = 0; i < sl; i++) {
                        if (s.options[i].innerHTML == this.innerHTML) {
                            s.selectedIndex = i;
                            h.innerHTML = this.innerHTML;
                            y = this.parentNode.getElementsByClassName("same-as-selected");
                            yl = y.length;
                            for (k = 0; k < yl; k++) {
                                y[k].removeAttribute("class");
                            }
                            this.setAttribute("class", "same-as-selected");
                            break;
                        }
                    }
                    h.click();
                });
                b.appendChild(c);
            }
            x[i].appendChild(b);
            a.addEventListener("click", function(e) {
                /*when the select box is clicked, close any other select boxes,
                and open/close the current select box:*/
                e.stopPropagation();
                closeAllSelect(this);
                this.nextSibling.classList.toggle("select-hide");
                this.classList.toggle("select-arrow-active");
            });
        }
        function closeAllSelect(elmnt) {
            /*a function that will close all select boxes in the document,
            except the current select box:*/
            var x, y, i, xl, yl, arrNo = [];
            x = document.getElementsByClassName("select-items");
            y = document.getElementsByClassName("select-selected");
            xl = x.length;
            yl = y.length;
            for (i = 0; i < yl; i++) {
                if (elmnt == y[i]) {
                    arrNo.push(i)
                } else {
                    y[i].classList.remove("select-arrow-active");
                }
            }
            for (i = 0; i < xl; i++) {
                if (arrNo.indexOf(i)) {
                    x[i].classList.add("select-hide");
                }
            }
        }
        /*if the user clicks anywhere outside the select box,
        then close all select boxes:*/
        document.addEventListener("click", closeAllSelect);
    })(jQuery);
</script>
