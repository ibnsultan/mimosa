<?php

/*
|--------------------------------------------------------------------------
| Pre Load Directory Files
|--------------------------------------------------------------------------
| This function is used to load all files in a given directory
| and its subdirectories into the application recursively.
| 
*/
function load_dir_files($directory) {
	if(is_dir($directory)) 

		$scan = scandir($directory); unset($scan[0], $scan[1]);
		foreach($scan as $file) :

			if(is_dir($directory."/".$file)):
                load_dir_files($directory."/".$file);
                else: if(strpos($file, '.php') !== false) { require_once($directory."/".$file); }
			endif;

		endforeach;

}


/*
|--------------------------------------------------------------------------
| Initialize blade template engine
|--------------------------------------------------------------------------
| This function is used to initialize the blade template engine
| 
*/
function blade(){
    $views = getcwd() . '/app/views';
    $cache = getcwd() . '/app/cache';
    $blade = new \Jenssegers\Blade\Blade($views, $cache);

    $blade->addExtension('blade.jsx', 'blade');

    // react initial state directive @reactInitialize
    $blade->directive('reactInitialize', function () {
        
        return "<?php echo '<script type=\"module\">import \"https://unpkg.com/react@18/umd/react.development.js\";import \"https://unpkg.com/react-dom@18/umd/react-dom.development.js\";import \"https://unpkg.com/@babel/standalone/babel.min.js\";</script>'; ?>";

    });

    return $blade;
}

/*
|--------------------------------------------------------------------------
| Render view
|--------------------------------------------------------------------------
| This function is used to render a view
| 
*/
function render($view, $data = []){
    $newDir = getcwd() .'/app/Views/'. str_replace('.', '/', $view);
        
    if (is_dir($newDir)) { $view = $view . '@Main'; }

    if (strpos($view, '@') !== false) :
        $components = explode('@', $view);
        $view = str_replace('@', '.', $view); 
        $data['screenComponents'] = "$components[0].Components";
    endif;

    response()->markup( (blade()->make($view, $data)) ?? '' );

}