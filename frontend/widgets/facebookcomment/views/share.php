<script src="https://sp.zalo.me/plugins/sdk.js"></script>

<div class="social-item fb-share-button fb_iframe_widget" data-href="<?= $link; ?>" data-layout="button_count"
     fb-xfbml-state="rendered"
     fb-iframe-plugin-query="app_id=&amp;container_width=0&amp;href=<?= $link; ?>&amp;layout=button_count&amp;locale=vi_VI&amp;sdk=joey"></div>
<div class="social-item fb-like fb_iframe_widget" data-href="<?= $link; ?>" data-layout="button_count"
     data-action="like" data-show-faces="true" data-share="false" fb-xfbml-state="rendered"
     fb-iframe-plugin-query="action=like&amp;app_id=&amp;container_width=0&amp;href=<?= $link; ?>&amp;layout=button_count&amp;locale=vi_VI&amp;sdk=joey&amp;share=false&amp;show_faces=true"></div>
<div class="zalo-share-button" data-href="<?= $link; ?>" data-oaid="579745863508352884" data-layout="1" data-color="blue"
     data-customize="false"></div>
<a class="btn tw share_tw wow bounceIn" data-wow-delay="0.3s" href="https://twitter.com/intent/tweet?url=<?= $link; ?>">
  <img src="<?= yii::$app->homeUrl ?>images/tw.png" alt=""><span>Tweet</span>
</a>
