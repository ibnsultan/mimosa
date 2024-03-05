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
                    <li><a href="https://github.com/ibnsultan/mimosa/wiki" target="_blank">Documentation</a></li>
                    <li><a href="/404">404</a></li>
                </ul>

            </nav>
            
        </header>
    )

}