<div class="tab-pane" id="tabs-3" role="tabpanel">
    <p><?php
        $upload_dir = wp_upload_dir()['basedir'] . '/exported_html_files/';
        $upload_url = wp_upload_dir()['baseurl'] . '/exported_html_files/';

        $d = dir($upload_dir);

        echo '<div class="all_zip_files">';

        $c = 0;

        if (!empty($d)) {
            while($file = $d->read()) {
                if (strpos($file, '.zip')!== false) {
                    $c++;
                    echo '<div class="exported_zip_file">'.esc_attr($c).'. <a class="file_name" href="'.esc_html($upload_url).esc_html($file).'">'.esc_html($file).'</a><span class="delete_zip_file" file_name="'.esc_html($file).'"></span></div>';
                }
            }
        }

        if ($c == 0) {
            echo '<div class="files-not-found">Files not found!</div>';
        }
        echo '</div>';
        ?></p>
</div>