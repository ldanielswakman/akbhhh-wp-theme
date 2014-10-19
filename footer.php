      <footer>
        <div class="row container-fluid footer-contact-info">
          <?php
          $contact_info_data = simple_fields_fieldgroup("contact_info", get_page_by_title('projecten')->ID);
          foreach($contact_info_data as $column): ?>
          <div class="col-sm-<?php echo 12 / count($contact_info_data); ?>">
            <?php
            if(strpos($column, '[menu]') !== false) :
              $menu = '<ul class="menu">' . wp_list_pages('title_li&depth=1&echo=0') . '</ul>';
              $column = str_replace('[menu]', $menu, $column);
            elseif(strpos($column, '[anbi logo]') !== false) :
              $logo = '<a href="http://anbi.nl/" target="_blank"><img src="' . get_bloginfo( 'template_directory' ) . '/images/logo-anbi.png" alt="" width="120" height="82" /></a>';
              $column = str_replace('[anbi logo]',$logo , $column);
            endif;
            echo $column;
            ?>
          </div>
          <?php endforeach; ?>
        </div>

        <div class="row container-fluid colophon">
          <div class="col-md-8 col-md-offset-2 align-center">
            <a href="http://www.ldaniel.eu/" target="_blank">designed and built by <strong>ldaniel.eu</strong></a>
          </div>
        </div>
      </footer>

			<?php wp_footer(); ?>

    </div><!-- end wrapper --->

  </body>
</html>
