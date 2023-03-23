<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>
        <?php 
            $this->archiveTitle(array(
                'category'  =>  _t('%s 下的文章'),
                'search'    =>  _t('包含关键字 %s 的文章'),
                'tag'       =>  _t('标签 %s 下的文章'),
                'author'    =>  _t('%s 的文章')
            ), '', ' - '); 
        ?>
        <?php
            $this->options->title();
            if ($this->is('index') && $this->options->subtitle != '') echo " - {$this->options->subtitle}";
        ?>
    </title>

    <!-- Favicon -->
    <link type="image/png" rel="icon" href="
        <?php
            if ($this->options->logoUrl == '') {
                $this->options->themeUrl("images/logo.png");
            } else {
                $this->options->logoUrl();
            }
        ?>">

    <!-- Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Noto+Serif+SC:wght@300,400,600,700&display=swap">

    <!-- FontAwesome CSS -->
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl("assets/css/font-awesome.min.css"); ?>">

    <!-- Main CSS -->
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl("assets/css/main.min.css"); ?>">

    <!-- Custom CSS -->
    <?php if ($this->options->customCss) : ?>
    <style type="text/css">
    <?php $this->options->customCss();
    ?>
    </style>
    <?php endif; ?>

    <!-- KaTeX CSS -->
    <?php if ($this->options->katex) : ?>
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl("assets/css/katex.min.css"); ?>">
    <?php endif; ?>

    <!-- Viewer CSS -->
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl("assets/css/viewer.min.css"); ?>" />

    <!-- PrismJS CSS -->
    <?php if ($this->options->prismjs) : ?>
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl("assets/css/prism-tomorrow.css"); ?>" />
    <link type="text/css" rel="stylesheet" href="<?php $this->options->themeUrl("assets/css/prism-toolbar.css"); ?>" />
    <?php if ($this->options->prismLine) : ?>
    <link type="text/css" rel="stylesheet"
        href="<?php $this->options->themeUrl("assets/css/prism-line-numbers.css"); ?>" />
    <?php endif; ?>
    <?php endif; ?>

    <!-- Typecho Header -->
    <?php $this->header(); ?>

    <!-- Jquery JS-->
    <script src="<?php $this->options->themeUrl("assets/js/jquery.min.js"); ?>"></script>

    <!-- Baidu Statistics -->
    <script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?<?php $this->options->baiduStatisticsKey(); ?>";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    </script>
</head>

<body>
    <header class="header-global">
        <nav id="navbar-main" class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light headroom">
            <div class="container">
                <a class="navbar-brand" href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title() ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-default"
                    aria-controls="navbar-default" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-default">
                    <div class="navbar-collapse-header">
                        <div class="row">
                            <div class="col-6 collapse-brand">
                                <a href="<?php $this->options->siteUrl(); ?>">
                                    <h5><?php $this->options->title() ?></h5>
                                </a>
                            </div>
                            <div class="col-6 collapse-close">
                                <button type="button" class="navbar-toggler" data-toggle="collapse"
                                    data-target="#navbar-default" aria-controls="navbar-default" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav ml-lg-auto align-items-lg-center">
                        <?php
						$this->widget('Widget_Contents_Page_List')->to($pages);
						while ($pages->next()) :
						?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php $pages->permalink(); ?>"
                                title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
                        </li>
                        <?php endwhile; ?>
                        <li class="navbar_search_container">
                            <form method="post" action="" id="search">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    </div>
                                    <input type="text" name="s" class="form-control" placeholder="搜索文章" type="text"
                                        autocomplete="off">
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php if ($this->options->Pjax) _e('<div id="pjax-container">'); ?>