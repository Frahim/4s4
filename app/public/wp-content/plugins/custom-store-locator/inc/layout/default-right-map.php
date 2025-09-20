<?php 
/* Default Right Map Layout */
?>
<form class="csl-search-form" action="#" method="get">
	<?php if ($csl_include_title === "yes") { ?>
        <div class="ctm_check">
            <label for="searchBy">
                <input name="searchBy" id="searchBy" type="checkbox" value="1"<?php echo isset($_GET['searchBy']) ? ' checked' : ''; ?> /> <span><?php esc_attr_e('Search By Name', 'custom-store-locator'); ?></span>
            </label>
        </div>
    <?php } ?>
    <label for="userAddress" id="addressWrapper">
        <?php if ($csl_autocompletesearchbox === "yes") { ?>
            <input name="userAddress" id="userAddress" class="autocompleteenabled" type="text" 
                value="<?php echo isset($_GET['userAddress']) ? esc_attr(sanitize_text_field($_GET['userAddress'])) : ''; ?>" 
                placeholder="<?php esc_attr_e('Address or Zipcode', 'custom-store-locator'); ?>" />
        <?php } else { ?>
            <input name="userAddress" id="userAddress" type="text" 
                value="<?php echo isset($_GET['userAddress']) ? esc_attr(sanitize_text_field($_GET['userAddress'])) : ''; ?>" 
                placeholder="<?php esc_attr_e('Zipcode', 'custom-store-locator'); ?>" />
        <?php } ?>
    </label>
    <?php
    if ($csl_include_cat === "yes") {
        $csl_locations_categories = get_terms(array(
            'taxonomy'   => 'csl_locations_categories',
            'hide_empty' => true, 
        ));
        if (!empty($csl_locations_categories)) {
            echo '<select name="csl-locations-categories">';
            echo '<option value="">' . esc_html__('Select Category', 'custom-store-locator') . '</option>';
            foreach ($csl_locations_categories as $csl_locations_category) {
                $selectedcat = ($csllocationscategories === $csl_locations_category->name) ? 'selected="selected"' : '';
                echo '<option value="' . esc_attr($csl_locations_category->name) . '" ' . esc_attr($selectedcat) . '>' . esc_html($csl_locations_category->name) . '</option>';
            }
            echo '</select>';
        }
    }
    ?>
    <a class="currentloc" href="#1">
        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 206.62 206.61"><path d="M13.41,108.56H0V98.44c2.92,0,5.85-.18,8.75,0,3.3.26,4.63-.75,5-4.3,3.8-39.33,33.44-71.87,72-79.24,3.74-.71,7.55-1.07,12-1.69V0h10.43V12.72c49.68,7.19,77.94,35.25,85.62,85.09,1.66.07,3.91.22,6.16.27s4.26,0,6.67,0v9.83a18.84,18.84,0,0,1-2.09.38c-3.46.18-8-.92-10.11.85s-1.67,6.36-2.3,9.73C184.37,160,152.05,189.34,110.46,193a13.27,13.27,0,0,0-1.59.46v13.2H98.42V193.43c-23-1.8-42.62-10.29-58.63-26.33S15.3,131.79,13.41,108.56Zm89.91,38.06c23.52,0,43.42-19.93,43.31-43.36C146.52,79.6,126.84,60,103.27,60S60,79.74,60,103.31,79.71,146.62,103.32,146.62Zm76.23-48.54c-1.67-38.71-36.09-70.6-71.05-70.65,0,6.62-.16,13.25.14,19.87.06,1.17,1.85,3,3.1,3.26,24,4.79,39.41,20.15,44.32,44.16.27,1.29,2.05,3.16,3.19,3.21C165.87,98.24,172.51,98.08,179.55,98.08ZM49.63,97.85a8.82,8.82,0,0,0,.7-1.57c4.76-25.3,19.53-40.72,45-45.78,1.08-.22,2.7-1.7,2.73-2.64.24-6.92.13-13.85.13-20.79-41,1.94-71,38.7-70.73,70.78ZM27,108.72c2.48,42.79,40.68,71,71.16,70.39,0-6-.18-11.93.07-17.89.15-3.45-.77-4.86-4.47-5.48C81,153.61,70.5,147.25,62.17,137.3c-6.9-8.25-10.68-17.86-12.13-28.58Zm81.5,70.9c42.69-2.48,71.25-40.45,70.64-71.12-6.62,0-13.26-.15-19.88.15-1.14.06-2.91,1.92-3.18,3.21-5.18,24.4-19.84,39.11-44.29,44.2-1.27.27-3.09,2.1-3.15,3.28C108.34,166,108.5,172.58,108.5,179.62Z"/><path d="M85.89,103.08c.17-9.36,8.54-17.46,17.77-17.19s17.1,8.29,17.11,17.41c0,9.29-8.25,17.5-17.56,17.46S85.72,112.35,85.89,103.08Z"/></svg>
    </a>
    <input name="maxRadius" id="maxRadius" type="hidden" 
        value="<?php echo esc_attr(!empty($csl_map_default_radius) ? sanitize_text_field($csl_map_default_radius) : '20'); ?>" min="1" />
    <button id="submitLocationSearch"><?php esc_html_e('Search', 'custom-store-locator'); ?></button>
    <button type="reset" name="reset" id="mapreset"><?php esc_html_e('Reset', 'custom-store-locator'); ?></button>
</form>
<h2 id="location-search-alert"><?php esc_html_e('All Locations', 'custom-store-locator'); ?></h2>
<div class="csl-wrapper" id="csl-wrapper">    
    <div class="csl-left">
        <div id="locations-near-you">
            <?php
            if ($listing_query->have_posts()) {
                $i = 0;
            ?>
                <div class="location-near-you-box">
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
                        <div class="csl-list-item">
                            <div data-markerid="<?php echo esc_attr($i); ?>" class="marker-link">
                                <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 167.77 225"><path d="M81.36,225a289.94,289.94,0,0,1-59.69-71.68C11.1,135.44,3.33,116.49.72,95.68-5.68,44.52,31.46,5.76,73.05.85A24.37,24.37,0,0,0,76.36,0h15c6.9,1.66,14,2.76,20.67,5.08,37.62,13.12,60.73,52.49,54.83,91.62-4.45,29.46-17.48,55-35.17,78.2-12.07,15.8-26.16,30.06-39.42,44.94A60.82,60.82,0,0,1,86.36,225Zm1.81-17.8c2-1.95,3.36-3,4.42-4.22C98.8,189.82,110.72,177.17,121,163.3c15.33-20.72,27-43.3,30.72-69.44C158.8,44,111,3.34,63,18.77,27.36,30.24,8.54,66.15,17.91,104.61c6.11,25.1,19,46.7,34.66,66.73C62.16,183.63,72.79,195.1,83.17,207.2Z"/><path d="M45.22,83.8A38.52,38.52,0,0,1,83.73,45c21.68,0,38.77,17.29,38.75,39.15A38.78,38.78,0,0,1,83.93,123C62.31,123,45.24,105.75,45.22,83.8Zm15.21,0a23.84,23.84,0,0,0,23.28,23.85c12.62.11,23.55-10.82,23.57-23.59S96.67,60.32,84,60.23,60.49,71,60.43,83.83Z"/></svg>
                                <h4><?php the_title(); ?></h4>
                                <p>
                                    <?php if ($business_address) {
                                        echo '<strong>' . esc_html__('Address', 'custom-store-locator') . ': </strong>' . nl2br(esc_html($business_address));
                                    } ?>
                                    <?php if (!empty($business_zip_code)) {
                                        echo '<br><strong>' . esc_html__('Postal Code', 'custom-store-locator') . ': </strong> ' . esc_html($business_zip_code);
                                    } ?>
                                    <?php if (!empty($business_phone_number) && $csl_hide_phone !== 'yes') {
                                        echo '<br><strong>' . esc_html__('Phone', 'custom-store-locator') . ': </strong> <a href="tel:' . esc_attr(preg_replace('/[^0-9]/', '', $business_phone_number)) . '">' . esc_html($business_phone_number) . '</a>';
                                    } ?>
                                    <?php if (!empty($business_contact_email) && $csl_hide_email !== 'yes') {
                                        echo '<br><strong>' . esc_html__('Email', 'custom-store-locator') . ': </strong> <a href="mailto:' . esc_attr($business_contact_email) . '">' . esc_html($business_contact_email) . '</a>';
                                    } ?>
                                    <?php if (!empty($business_fax) && $csl_hide_fax !== 'yes') {
                                        echo '<br><strong>' . esc_html__('Fax', 'custom-store-locator') . ': </strong> <a href="fax:' . esc_attr(preg_replace('/[^0-9]/', '', $business_fax)) . '">' . esc_html($business_fax) . '</a>';
                                    } ?>
                                    <?php if (!empty($websiteurl) && $csl_hide_website !== 'yes') {
                                        echo '<br><strong>' . esc_html__('Website', 'custom-store-locator') . ': </strong> <a target="_blank" href="' . esc_url($websiteurl) . '">' . esc_html($websiteurl) . '</a>';
                                    } ?>
                                    <?php if ($business_storehours && $csl_hide_hours !== 'yes') {
                                        echo '<br><strong>' . esc_html__('Store Hours', 'custom-store-locator') . ': </strong>' . nl2br(esc_html($business_storehours));
                                    } ?>
                                </p>                                
                                <a href="#1" class="viewmaplink"><?php esc_html_e('View on Map', 'custom-store-locator'); ?></a>
                            </div>
                        </div>
                    <?php 
                        $i++;
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="csl-right">
        <div id="locations-near-you-map"></div>
        <div id="floating-panel-map" style="display:none;">
            <input type="button" value="<?php esc_attr_e('Back to Map', 'custom-store-locator'); ?>" id="togglemap" />
        </div>
        <div id="pano" style="display:none;"></div>
    </div>
</div>