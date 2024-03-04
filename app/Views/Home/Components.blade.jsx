const Cards = () => {
    return (
        <div className="flex card mt-3">
            
            @foreach($descriptions as $description)

                <p> {{ $description }} </p>

            @endforeach

            <p>, &nbsp;
                <a href="https://framework-x.org/docs/getting-started/quickstart" target="_blank" className="btn btn-primary">View Documentation</a>
            </p>

        </div>
    );
}