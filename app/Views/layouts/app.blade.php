<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/app.css">
</head> 
<body>
    
    <div id="root"></div>

    @reactInitialize
    <script type="text/babel">

        @include('layouts.components.global');
        @if(!is_null($screenComponents)) @include($screenComponents); @endif

        const App = () => { return ( <> @yield('jsx') </> ); };

		const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<App />);

    </script>
</body>
</html>