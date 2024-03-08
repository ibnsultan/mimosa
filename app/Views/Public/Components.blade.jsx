const SampleComponent = (props) => {
    return (        
        <div className="main">
            <div className="spotLight">
                <h4> {props.title} </h4>
                <p> {props.description} </p>
            </div>
        </div>
    );
}