<!-- Main -->
<div id="main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
    <!-- Introduction -->
    <!--
    <section id="intro" class="main">
        <div class="spotlight">
            <div class="content">
                <header class="major">
                    <h2>Welcome to the Demo</h2>
                </header>
                <p>
                    The demo is split up into 3 separate APIs using plugins: Public, Partner, and Admin.
                </p>
                <ul class="actions">
                    <li><a href="generic.html" class="button">Learn More</a></li>
                </ul>
            </div>
            <span class="image"><img src="images/pic01.jpg" alt="" /></span>
        </div>
    </section>
    -->

    <!-- First Section -->
    <section id="first" class="main special">
<!--        <header class="major">
        </header>-->
        <ul class="features">

            <li>
                <span class="icon solid major style1 fa-search"></span></a>
                <h3>Public API</h3>
                <p>
                    Read-only API for viewing films, actors, and other cinematography meta-data<br/>
                </p>
                <a href="/public" class="button">Browse</a>
            </li>
            <!--
            <li>
                <span class="icon solid major style2 fa-shopping-cart"></span>
                <h3>Partner API</h3>
                <p>
                    Example of a Partner API for purchasing movies.<br/>
                </p>
                <a href="/partner" class="button">Shop</a>
            </li>
            -->
            <li>
                <span class="icon solid major style3 fa-lock"></span>
                <h3>Admin API</h3>
                <p>
                    An administrative API for managing actors, movies, etc.<br/>
                </p>
                <a href="/admin" class="button">Manage</a>
            </li>
        </ul>
        <h3>About</h3>
        <p>
            Note: On demo.mixerapi.com, the database is refreshed once every 24 hours and you may only delete
            new records.
        </p>
        <p>
            This demo uses the main APP namespace to host the Public API. The two remaining APIs
            are exposed via plugins. While MixerAPI is setup to run off your main APP namespace by default, this
            demo illustrates how you may logically separate your API using plugins.
        </p>
        <p>
            The demo is based off a modified version of the
            <a href="https://dev.mysql.com/doc/sakila/en/">MySQL Sakila</a> sample database and exposes it as an
            API for viewing, purchasing, and managing movie rentals.
        </p>
    </section>

    <!-- Second Section -->
    <!--
    <section id="second" class="main special">
        <header class="major">
            <h2>Ipsum consequat</h2>
            <p>Donec imperdiet consequat consequat. Suspendisse feugiat congue<br />
                posuere. Nulla massa urna, fermentum eget quam aliquet.</p>
        </header>
        <ul class="statistics">
            <li class="style1">
                <span class="icon solid fa-code-branch"></span>
                <strong>5,120</strong> Etiam
            </li>
            <li class="style2">
                <span class="icon fa-folder-open"></span>
                <strong>8,192</strong> Magna
            </li>
            <li class="style3">
                <span class="icon solid fa-signal"></span>
                <strong>2,048</strong> Tempus
            </li>
            <li class="style4">
                <span class="icon solid fa-laptop"></span>
                <strong>4,096</strong> Aliquam
            </li>
            <li class="style5">
                <span class="icon fa-gem"></span>
                <strong>1,024</strong> Nullam
            </li>
        </ul>
        <p class="content">Nam elementum nisl et mi a commodo porttitor. Morbi sit amet nisl eu arcu faucibus hendrerit vel a risus. Nam a orci mi, elementum ac arcu sit amet, fermentum pellentesque et purus. Integer maximus varius lorem, sed convallis diam accumsan sed. Etiam porttitor placerat sapien, sed eleifend a enim pulvinar faucibus semper quis ut arcu. Ut non nisl a mollis est efficitur vestibulum. Integer eget purus nec nulla mattis et accumsan ut magna libero. Morbi auctor iaculis porttitor. Sed ut magna ac risus et hendrerit scelerisque. Praesent eleifend lacus in lectus aliquam porta. Cras eu ornare dui curabitur lacinia.</p>
        <footer class="major">
            <ul class="actions special">
                <li><a href="generic.html" class="button">Learn More</a></li>
            </ul>
        </footer>
    </section>
    <section id="cta" class="main special">
        <header class="major">
            <h2>Congue imperdiet</h2>
            <p>Donec imperdiet consequat consequat. Suspendisse feugiat congue<br />
                posuere. Nulla massa urna, fermentum eget quam aliquet.</p>
        </header>
        <footer class="major">
            <ul class="actions special">
                <li><a href="generic.html" class="button primary">Get Started</a></li>
                <li><a href="generic.html" class="button">Learn More</a></li>
            </ul>
        </footer>
    </section>
    -->

</div>
