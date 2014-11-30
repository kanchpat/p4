<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Book Rental</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a>
                <li><a href="/signup">Signup</a>
                <li><a href="/login">Login</a>
                <li><a href="/logout">Log Out</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Library Management <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/book/list">Show My Library</a></li>
                        <li><a href="#">Show My Messages</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Your books update</li>
                        <li><a href="/book/create">Add Book</a></li>
                        <li><a href="#">Remove Book</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>