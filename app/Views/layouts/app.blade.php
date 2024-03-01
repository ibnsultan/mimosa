<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- React CDN -->
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>

    <!-- Babel CDN for JSX -->
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <!-- stylesheets -->
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">

        @include('layouts.components.global')

        @yield('components')

        const App = () => {
            return (
                <div className="container">

                    <Header />

                    @yield('content')
                    
                </div>
            );
        };

        // Render the component to the DOM
		const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);

    </script>
</body>
</html>