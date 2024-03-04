function addClassesToBody(classes) {
    var body = document.querySelector('body');
    body.classList.add(...classes.split(' '));
}

addClassesToBody("flex center-all h-screen");

const Header = () => {

    return (
        <header>

            <ul>
                <li className="logo"><a href="/">🌿 Mimosa</a></li>
                <li><a href="/">Home</a></li>
                <li><a href="https://github.com/ibnsultan/mimosa" target="_blank">Documentation</a></li>
                <li><a href="/404">404</a></li>
            </ul>
            
        </header>
    )

}