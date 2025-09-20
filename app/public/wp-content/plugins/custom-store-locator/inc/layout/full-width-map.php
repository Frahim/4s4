<?php
/* Full Width Map Layout */
$csl_fullwidth_include_loc = get_option('csl_fullwidth_include_loc', 'no'); // Default to 'no' if not set.
?>
<form class="csl-search-form fullwidth-map-search" action="#" method="get">
    <?php wp_nonce_field('csl_search_form', 'csl_search_nonce'); ?>
	<?php if ($csl_include_title === "yes") { ?>
        <div class="ctm_check">
            <label for="searchBy">
                <input name="searchBy" id="searchBy" type="checkbox" value="1"<?php echo isset($_GET['searchBy']) ? ' checked' : ''; ?> /> <span><?php esc_attr_e('Search By Name', 'custom-store-locator'); ?></span>
            </label>
        </div>
    <?php } ?> 
    <label for="userAddress">
        <?php if ($csl_autocompletesearchbox === "yes") { ?>
            <input name="userAddress" id="userAddress" class="autocompleteenabled" type="text" 
                   value="<?php echo isset($_GET['userAddress']) ? esc_attr($_GET['userAddress']) : ''; ?>" 
                   placeholder="<?php esc_attr_e('Address or Zipcode', 'custom-store-locator'); ?>" />
        <?php } else { ?>
            <input name="userAddress" id="userAddress" type="text" 
                   value="<?php echo isset($_GET['userAddress']) ? esc_attr($_GET['userAddress']) : ''; ?>" 
                   placeholder="<?php esc_attr_e('Zipcode', 'custom-store-locator'); ?>" />
        <?php } ?>
    </label>
    <?php if ($csl_fullwidth_include_loc === "yes") { ?>
        <select name="locationslist" id="locationslist">
            <option value=""><?php esc_html_e('All Locations', 'custom-store-locator'); ?></option>
            <?php
            if ($listing_query->have_posts()) {
                $i = 0;
                while ($listing_query->have_posts()) : 
                    $listing_query->the_post(); 
                    $locid = get_the_ID();
            ?>
                    <option data-markerid="<?php echo esc_attr($i); ?>" value="<?php echo esc_attr($locid); ?>">
                        <?php the_title(); ?>
                    </option>
            <?php
                    $i++;
                endwhile;
                wp_reset_postdata();
            }
            ?>
        </select>
    <?php } ?>
    <?php
    if ($csl_include_cat === "yes") {
        $csl_locations_categories = get_terms([
            'taxonomy'   => 'csl_locations_categories',
            'hide_empty' => true,
        ]);
        if (!empty($csl_locations_categories)) {
            echo '<select name="csl-locations-categories" id="locationscat">
                <option value="">' . esc_html__('Select Category', 'custom-store-locator') . '</option>';
            foreach ($csl_locations_categories as $csl_locations_category) {
                $selectedcat = ($csllocationscategories === $csl_locations_category->term_id) ? 'selected="selected"' : '';
                echo '<option value="' . esc_attr($csl_locations_category->term_id) . '"' . esc_attr($selectedcat) . '>' . 
                     esc_html($csl_locations_category->name) . '</option>';
            }
            echo '</select>';
        }
    }
    ?>
    <input name="maxRadius" id="maxRadius" type="hidden" 
           value="<?php echo !empty($csl_map_default_radius) ? esc_attr($csl_map_default_radius) : '20'; ?>" min="1" />
    <button id="submitLocationSearch"><?php esc_html_e('Search', 'custom-store-locator'); ?></button>
    <button type="reset" name="reset" id="mapreset"><?php esc_html_e('Reset', 'custom-store-locator'); ?></button>
</form>
<div class="csl-fullwidthmap-wrapper" id="csl-fullwidthmap-wrapper">
    <div id="fullwidh-locations-near-you-map"></div>
    <div id="floating-panel-map" style="display:none;">
        <input type="button" value="<?php esc_attr_e('Back to Map', 'custom-store-locator'); ?>" id="togglemap" />
    </div>
    <div id="pano" style="display:none;"></div>
</div>