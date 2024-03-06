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
                    <li><a to="javascript:void;">PHP</a></li>
                    <li><a to="javascript:void;">MVC</a></li>
                    <li><a to="javascript:void;">ReactJS</a></li>
                </ul>
            </nav>
        </header>
    )

}