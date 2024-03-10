function addClassesToBody(classes) {
    var body = document.querySelector('body');
    body.classList.add(...classes.split(' '));
}

addClassesToBody("flex center-all h-screen");

const Header = () => {

    return (
        <header>
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="https://github.com/ibnsultan/mimosa/wiki">Documentation</a></li>
                    <li><a href="/auth/login">Login</a></li>
                </ul>
            </nav>
        </header>
    )

}