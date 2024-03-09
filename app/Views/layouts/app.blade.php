<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config->app_name}}  {{$title ?? ''}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/css/app.css">

    <! -- TODO: Reimplement Inclusion of Screen stylesheets -->
    @if(isset($screenComponents))
        <style>
            @include($screenStylesheet);
        </style>
    @endif
</head> 
<body>
    
    <div id="root"></div>

    @reactInitialize

    <script type="module">
        @yield('imports')
    </script>

    <script type="text/babel">

        const { StrictMode } = React;

        @include('layouts.components.global');

        // TODO: Reimplement Inclusion of the Screen Components
        @if(isset($screenComponents))
            @include($screenComponents);
        @endif

        const App = () => { return ( <> @yield('jsx') </> ); };
 
		const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render( <StrictMode> <App /> </StrictMode> );

    </script>
</body>
</html>