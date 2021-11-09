<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>
<style type="text/css">
	.sidebar ol, .sidebar ul {
	    list-style: none;
	    padding: 0;
	    margin: 0;
	    padding: 0;
	}
	.popular-posts .posts-list li:first-child {
	    margin-top: 0;
	}
	.stl_list_item .widget-content ul li {
	    margin-bottom: 15px;
	    float: left;
	    width: 100%;
	}
	.popular-posts .posts-list li {
	    overflow: hidden;
	}
	.featured-thumb {
	    text-align: center;
	}
	.featured-thumb {
	    float: left;
	    margin: 0 15px 0px 0;
	    position: relative;
	}
	.sidebar a, .sidebar .block-layered-nav .price .sub {
	    color: #222;
	    font-size: 14px;
	    color: black;
	}
	.popular-posts h4 {
	    font-size: 15px;
	    line-height: 18px;
	    padding-top: 0px;
	    margin-bottom: 5px;
	    margin-top: 0px;
	    clear: initial;
	}
	.popular-posts h4 a {
	    color: #333;
	    -webkit-transition: all 0.2s ease-out;
	    -moz-transition: all 0.2s ease-out;
	    transition: all 0.2s ease-out;
	    font-size: 16px;
	    font-family: 'Roboto', sans-serif;
	    font-weight: bold;
	}
	.popular-posts .post-meta {
	    margin-bottom: 0;
	    font-size: 14px;
	    color: #999;
	}
	.ad-spots {
	    padding-bottom: 15px;
	        position: relative;
	    margin-bottom: 20px;
	    width: 100%;
	    float: left;
	}
	.ad-spots img {
	    width: 100%;
	}
	.col-right {
	    margin-bottom: 0px;
	}
	.sidebar {
	    font-size: 14px;
	    background: #fff;
	}
	.bg-white {
	    float: left;
	    width: 100%;
	}
	.pad-15 {
	    padding: 15px;
	}
	.bg-white {
	    background: #fff;
	}
	.widget_wrapper13 {
		padding: 15px 0px;
	}
	

	.item-footer-bottom ul li {
	    float: left;
	    width: 100%;
	    padding-left: 20px;
	    color: #fff;
	    letter-spacing: .3px;
	    line-height: 21px;
	    background: url(css/images/icon-dot.png) 0px 8px no-repeat;
	    margin-bottom: 9px;
	        font-family: 'Roboto Condensed', sans-serif;
	    font-size: 15px;
	    font-weight: 300;
	}
	.navigation-box{
	    float: left;
	    width: 100%;
	    margin-bottom: 10px;
	    margin-top: 10px;
	}
	.navigation-box a, .navigation-box p {
	    float: left;
	    margin-right: 10px;
	    color: #777;
	}
	.navigation-box a span{
	    margin-left: 10px;
	}
	.navigation-box a:hover{
	    color: #fc3c3c;
	}
	.sidebar {
	    font-size: 14px;
	    background: #fff;
	}
	.title-site h2 {
	    float: left;
	    width: 100%;
	    padding: 0px 0px 10px 0px;
	    margin-bottom: 15px;
	    border-bottom: 1px double #ebebeb;
	    margin-top: -5px;
	}
	h2 {
	    font-size: 20px;
	}
	.blog_entry {
	    padding-bottom: 15px;
	    margin-bottom: 15px;
	    border-bottom: 1px solid #ebebeb;
	    display: block;
	    float: left;
	    width: 100%;
	}
	.blog_entry header {
	    width: auto;
	    height: auto;
	    margin: 0px;
	}
	.blog_entry-header-inner {
	    overflow: hidden;
	    padding: 0px;
	    border-bottom: 0px solid #E3E3E3;
	    margin-bottom: 5px;
	}
	.blog_entry-title {
	    font-size: 26px;
	    line-height: 1.2em;
	    text-transform: none;
	    text-align: left;
	    margin: 0px;
	    font-family: 'Roboto', sans-serif;
	}
	.interview{
	    float: left;
	    width: 100%;
	    margin-bottom: 10px;
	}
	.blog_entry-title a {
	    font-family: 'Roboto', sans-serif;
	    font-size: 20px;
	}
	.interview div {
	    float: left;
	    margin-right: 10px;
	}
	.interview div p {
	    color: #b7b7b7;
	}
	.blog_entry .entry-content, .entry-footer {
	    padding: 0px 0px 0px 0px;
	    font-size: 15px;
	    color: #666;
	}
	.blog_entry .featured-thumb {
	    margin-bottom: 18px;
	    float: none;
	    position: relative;
	    overflow: hidden;
	    float: left;
	    width: 250px;
	    margin-bottom: 10px;
	    margin-right: 15px;
	}
	.blog_entry .featured-thumb a {
	    display: block;
	}
	.blog_entry .featured-thumb a img {
	    max-width: 100%;
	    height: auto;
	    vertical-align: top;
	}
	.col2-right-layout .col-main .page-title {
	    padding: 0px 0px 4px 0px;
	    margin: 0 0 10px;
	}
	h1.blog_entry-title{
	    margin: 0px;
	    font-size: 22px;
	    color: #000;
	}
	p.description{
	    font-weight: 600;
	    font-family: 'Roboto', sans-serif;
	    color: #222;
	    float: left;
	    width: 100%;
	    margin-bottom: 10px;
	}
	.col1-layout .col-main {
	    float: none;
	    width: auto;
	}
	.page-title {
	    padding: 0px 0px 10px 0px;
	    margin: 0 0 0px 0px;
	    overflow: hidden;
	}
	.title-site h2 {
	    font-weight: 500;
	    float: left;
	    width: 100%;
	    padding: 0px 0px 10px 0px;
	    margin-bottom: 15px;
	    border-bottom: 1px double #ebebeb;
	    margin-top: -5px;
	    clear: both;
	}
	.title-site h2 a {
		font-size: 17px;
		font-weight: bold;
	    font-family: 'Roboto Condensed', sans-serif;
	    text-transform: uppercase;
	}
</style>
<div id="main-content" style="background: #f7f5f5; padding-top: 15px;">
    <div class="container">
        <div class="row mar-10">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pad-10 mar-bottom-15">
                <?= frontend\widgets\breadcrumbs\BreadcrumbsWidget::widget(); ?>
            </div>
            <?= $content ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>