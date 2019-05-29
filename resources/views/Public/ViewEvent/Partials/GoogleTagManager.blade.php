<?php
$gtm_code = '';
if (empty($event->google_tag_manager_code) === false) {
    $gtm_code = $event->google_tag_manager_code;
} elseif (empty($event->organiser->google_tag_manager_code) === false) {
    $gtm_code = $event->organiser->google_tag_manager_code;
}
?>

@if(empty($gtm_code) === false)
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $gtm_code }}');</script>
<!-- End Google Tag Manager -->
@endif