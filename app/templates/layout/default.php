<!DOCTYPE HTML>
<!--
	Stellar by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>MixerApi Demo</title>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="images/favicon.png">
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['main', 'noscript', 'fontawesome-all.min']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header" class="alt">
        <h1>MixerAPI Demo</h1>
        <p>Streamline API Development &mdash; CakePHP | REST | OpenAPI</p>
    </header>

    <!-- Nav -->
    <!--
    <nav id="nav">
        <ul>
            <li><a href="#intro" class="active">Introduction</a></li>
            <li><a href="#first">First Section</a></li>
            <li><a href="#second">Second Section</a></li>
            <li><a href="#cta">Get Started</a></li>
        </ul>
    </nav>
    -->

    <?php echo $this->Flash->render() ?>
    <?php echo $this->fetch('content') ?>

    <?php echo $this->element('footer'); ?>

</div>

<!-- Scripts -->
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery.scrollex.min.js"></script>
<script src="/js/jquery.scrolly.min.js"></script>
<script src="/js/browser.min.js"></script>
<script src="/js/breakpoints.min.js"></script>
<script src="/js/util.js"></script>
<script src="/js/main.js"></script>

</body>
</html>
