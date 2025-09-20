<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make(__('CTA Block'))
        ->add_tab(__('Content Part'), array(
            Field::make('rich_text', 'cta_heading', __('Section Content')),
            Field::make('text', 'cta_btn_url', __('Button URL')),
            Field::make('text', 'cta_cta_txt', __('Bottom Text')),
        ))
        ->add_tab(__('Style'), array(
            Field::make('color', 'cta_background', 'Background')
            ->set_palette(array('#FF0000', '#00FF00', '#0000FF')),
            Field::make('image', 'cta_bg_image', __('Background Image')),
        ))
        ->set_render_callback(function ($fields, $attributes) {
            ?>

            <section class="cta-area py-120" style="background-color:<?php echo $fields['cta_background']; ?>; background-image:url(<?php echo wp_get_attachment_url($fields['cta_bg_image']) ?>);">    
                <div class="container">
                    <div class="row">
                        <div class="col-12 cta-content wow fadeInUp animated"><?php echo $fields['cta_heading']; ?></div>
                        <div class="ctabtn wow fadeInUp animated" data-wow-delay="0.5s">
                            <a href="<?php echo $fields['cta_btn_url']; ?>" class="contbtn text-decoration-none wow fadeInUp animated" data-wow-delay="0.8s">
                                <?php echo $fields['cta_cta_txt']; ?>
                            </a>
                            <span class="cta_phone_wrap">
                                <span class="cta-txt wow fadeInUp animated" data-wow-delay="1s">Appelez-nous</span>
                                <span class="cta-svg wow fadeInUp animated" data-wow-delay="1.2s"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                        <path d="M5.7977 3.19594L5.79753 3.1961L3.51026 5.48122C3.51008 5.4814 3.5099 5.48158 3.50973 5.48176C3.04192 5.95164 2.82555 6.6214 2.93375 7.26718L2.93387 7.26791C3.3875 10 4.84427 12.731 7.05684 14.9478C9.27161 17.1603 12.0023 18.6188 14.7314 19.0682L14.7349 19.0687C14.8425 19.0872 14.9494 19.0959 15.0627 19.0959C15.6044 19.0959 16.1348 18.8759 16.5181 18.4925L18.8041 16.2066C18.9923 16.0184 19.0938 15.7737 19.0938 15.5096C19.0938 15.2478 18.9902 14.9987 18.8041 14.8125L16.3381 12.353L16.3381 12.3531L16.3353 12.3502C16.2451 12.2588 16.1375 12.1862 16.0189 12.1369C15.9003 12.0876 15.7731 12.0624 15.6446 12.0629H15.6428C15.3818 12.0629 15.1348 12.1658 14.9481 12.3524C14.9481 12.3524 14.9481 12.3524 14.9481 12.3524C14.948 12.3525 14.9479 12.3525 14.9479 12.3526L13.0231 14.2795L12.7828 14.5201L12.4707 14.385C11.3908 13.9177 10.4163 13.2569 9.5828 12.419C8.75034 11.5893 8.08436 10.6079 7.6208 9.52786L7.4873 9.2168L7.72652 8.97731L9.65152 7.05016L9.65172 7.04996C9.83992 6.86176 9.94141 6.61705 9.94141 6.35293C9.94141 6.09113 9.83789 5.84209 9.65175 5.65593C9.65174 5.65592 9.65173 5.65591 9.65172 5.6559L7.18777 3.19625L7.18611 3.19458C7.00114 3.00819 6.75527 2.90625 6.49258 2.90625C6.23153 2.90625 5.9844 3.00923 5.7977 3.19594ZM16.136 18.1082L16.1343 18.1099C15.7923 18.4487 15.306 18.6124 14.8243 18.5316C12.1749 18.0934 9.55857 16.6745 7.44313 14.559C5.32782 12.4437 3.90904 9.82552 3.47071 7.17658C3.38953 6.69427 3.55341 6.20667 3.89606 5.86402L6.14117 3.61891L6.49489 3.26519L6.84844 3.61907L9.22891 6.00168L9.58229 6.35538L9.2286 6.70878L6.86013 9.07529L6.92063 9.23865L6.9211 9.23993C7.41295 10.5791 8.19012 11.7954 9.19875 12.8044C10.2074 13.8133 11.4234 14.5909 12.7624 15.0833L12.7635 15.0837L12.9267 15.1441L15.2932 12.7737L15.6469 12.4194L16.0008 12.7736L18.3813 15.1562L18.7345 15.5097L18.3811 15.8631L16.136 18.1082Z" fill="#0F1517" stroke="#fff"/>
                                    </svg>
                                </span>
                                <a class="cta-phon text-decoration-none wow fadeInUp animated" data-wow-delay="1.5s" href="tel:<?php echo carbon_get_theme_option('crb_phone_number'); ?>">
                                    <?php echo carbon_get_theme_option('crb_phone_number'); ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>          
            </section>

            <?php
        });
