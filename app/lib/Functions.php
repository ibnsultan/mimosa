<?php


include_once 'Instances.php';

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
| Delete Directory and its contents
|--------------------------------------------------------------------------
| This function is used to delete a directory and its contents
| 
*/
function delete_dir($dirPath) {
    if (is_dir($dirPath)) {
        $files = scandir($dirPath);
        foreach ($files as $file) {
           if ($file !== '.' && $file !== '..') {
              $filePath = $dirPath . '/' . $file;
              if (is_dir($filePath)) {
                    delete_dir($filePath);
              } else {
                 unlink($filePath);
              }
           }
        }
        rmdir($dirPath);
     }
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
    $blade->addExtension('blade.css', 'blade');

    // react initial state directive @reactInitialize
    $blade->directive('reactInitialize', function () {

        $modulesReference = config->modules->reference;

        $modulesCollection = "\n\t\t";
        foreach($modulesReference as $module){
            $modulesCollection .= "import * as {$module['name']} from '{$module[config->app_env]}';\n\t\t";
        }

        return <<<DATA
        <script type="module">
            $modulesCollection
        \t</script>
        DATA;

    });

    /*$blade->directive('screenStylesheet', function ($experession) {

        if(is_null($experession)) return '';

        $stylesheet = config->viewsDirectory . $experession . '/Stylesheet.css';
        //$stylesheet = file_get_contents($stylesheet);

        return <<<DATA
        <styles>
            $stylesheet;
        </styles>
        DATA;

    });*/

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
        $data['screenStylesheet'] = "$components[0].Stylesheet";
    endif;

    response()->markup( (blade()->make($view, $data)) ?? '' );

}

/*
|--------------------------------------------------------------------------
| Array & Object Iterator
|--------------------------------------------------------------------------
| This function is used to iterate through an array or object recursively
| and apply a callback function to each value
|
| @param array|object $array 
| @return array (?key => value)
|
*/

function object_array_iterator($array, $callback='trim') {
    foreach ($array as $key => $value) {
        if (is_array($value) || is_object($value)) {
            object_array_iterator($value, $callback);
        } else {
            $array[$key] = $callback($value);
        }
    }
    return $array;
}

function get_screen_stylesheet($screen){

}

function auth(){
    $auth =  new \Leaf\Auth;
    $auth->connect(
        config->db_host,
        config->db_name,
        config->db_user,
        config->db_pass,
        config->db_driver
    );

    $auth->useSession();

    // pass auth configs recursively
    foreach(config->auth as $key => $value){
        $auth->config($key, $value);
    }

    return $auth;
}