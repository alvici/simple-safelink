<?php
$pageTitle   = isset($title) ? $title : config('app_name');
$pageHeading = isset($heading) ? $heading : config('app_name');
$pageType    = isset($type) ? $type : 'site';
$pageSub     = isset($subheading) ? $subheading : config('slogan');
$isPost      = ($pageType === 'post');
$notFound    = !empty($is_not_found);
$fullTitle   = ($pageTitle === config('app_name')) ? $pageTitle : $pageTitle . ' - ' . config('app_name');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?= htmlspecialchars(config('slogan'), ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="author" content="<?= htmlspecialchars(config('post_author'), ENT_QUOTES, 'UTF-8'); ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="theme-color" content="#06080f" />
    <link rel="icon" type="image/svg+xml" href="<?= asset_v('img/logo.svg'); ?>" />
    <link rel="shortcut icon" href="<?= asset_v('img/favicon.ico'); ?>" />
    <link rel="apple-touch-icon" href="<?= asset_v('img/icon.png'); ?>" />
    <title><?= htmlspecialchars($fullTitle, ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <link href="<?= asset_v('themes/css/style.css'); ?>" rel="stylesheet">
</head>

<body>
    <div class="bg-orbs" aria-hidden="true"></div>

    <header class="site-nav" id="siteNav">
        <div class="container nav-inner">
            <a class="brand" href="<?= base_url(); ?>">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M13 2 4.5 13.5H11l-1 8.5L19.5 10H13l0-8Z" />
                    </svg>
                </span>
                <span class="brand-text"><?= htmlspecialchars(config('app_name'), ENT_QUOTES, 'UTF-8'); ?></span>
            </a>

            <button class="nav-toggle" id="navToggle" type="button" aria-label="Toggle menu" aria-expanded="false" aria-controls="navLinks">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>

            <nav class="nav-links" id="navLinks">
                <a href="<?= base_url(); ?>">Home</a>
                <a href="<?= base_url('convert'); ?>">Converter</a>
                <a href="<?= base_url('script'); ?>">Script</a>
            </nav>
        </div>
    </header>

    <?php if ($isPost): ?>
    <section class="page-head page-head--cover" style="background-image: url('<?= asset('img/cover.jpg'); ?>');">
        <div class="container">
            <a class="back" href="<?= base_url(); ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                All articles
            </a>
            <h1><?= htmlspecialchars($pageHeading, ENT_QUOTES, 'UTF-8'); ?></h1>
            <?php if (!$notFound): ?>
            <div class="meta">
                <span class="pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    <?= !empty($post_date) ? date('d M Y', $post_date) : random_date(); ?>
                </span>
                <span class="pill">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    <?= htmlspecialchars(config('post_author'), ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php else: ?>
    <section class="hero hero--cover" style="background-image: url('<?= asset('img/cover.jpg'); ?>');">
        <div class="container">
            <h1 class="hero-title"><?= htmlspecialchars($pageHeading, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="hero-sub"><?= htmlspecialchars($pageSub, ENT_QUOTES, 'UTF-8'); ?></p>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?= base_url('convert'); ?>">
                    Create Safelink
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7" />
                    </svg>
                </a>
                <a class="btn btn-ghost" href="<?= base_url('script'); ?>">Auto Script</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <main>
