<?php

/**
 * Typecho 简约美观现代化风格主题，基于 Bubble 主题魔改。
 * 
 * @package BlueBubble
 * @author B1ue1nWh1te
 * @version 1.0.2
 * @link https://github.com/B1ue1nWh1te/BlueBubble
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<main>
    <section class="section section-lg section-hero section-shaped" style="height: 100vh;">
        <?php printBackground($this->options->indexImage, $this->options->bubbleShow); ?>
        <div class="container shape-container d-flex align-items-center py-lg">
            <div class="col px-0">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 text-center">
                        <div class="index-avatar-container">
                            <img class="index-avatar" src="<?php
                                if ($this->options->avatarUrl == '') {
                                    $this->options->themeUrl("images/avatar.jpg");
                                } else {
                                    $this->options->avatarUrl();
                                }
                                ?>">
                        </div>
                        <h1 class="text-white"><?php $this->options->title() ?></h1>
                        <div class="horizen"></div>
                        <p class="lead text-white"><?php $this->options->saying(); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section section-components bg-secondary content-card-container">
        <div class="container container-lg py-5 align-items-center content-card-container">
            <!-- Article list -->
            <?php $first_flag = true; ?>
            <?php while ($this->next()) : ?>
            <?php printAricle($this, $first_flag);
				$first_flag = false; ?>
            <?php endwhile; ?>

            <!-- Toggle page -->
            <?php printToggleButton($this); ?>
        </div>
    </section>
    <?php if ($this->_currentPage > 1) echo ("<script>$('html,body').animate({ scrollTop: $('.card.shadow.content-card.list-card.content-card-head').offset().top}, 500)</script>") ?>
    <?php $this->need('footer.php'); ?>