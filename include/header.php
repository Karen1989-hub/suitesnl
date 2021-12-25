<!doctype html>
<html lang="nl">
<head>
<meta charset="utf-8">
<title><?= $title; ?></title>
<link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
<link rel="manifest" href="/assets/favicon/site.webmanifest">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<meta property="og:locale" content="nl_NL" />
<meta property="og:title" content="<?= $title; ?>" />
<meta property="og:type" content="<?= $type; ?>" />
<meta property="og:url" content="<?= $url; ?>" />
<meta property="og:image" content="<?= $image; ?>" />
<meta property="og:description" content="<?= $description; ?>" />
<meta name="twitter:card" content="summary_large_image" />
<meta name=”twitter:site” content=”@suitesnl” /> 
<meta name=”twitter:title” content=”<?= $title; ?>” /> 
<meta name=”twitter:description” content=”<?= $description; ?>” /> 
<meta name=”twitter:image” content=”<?= $image; ?>” />
<!-- Facebook Pixel Code -->
<script>!function(f,b,e,v,n,t,s){if(f.fbq){return}n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq){f._fbq=n}n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','ID HERE');fbq('track','<?= $fbtype; ?>');</script>
<noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id= ID HERE &ev=PageView&noscript=1" /></noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Analytics -->
