<?php

namespace App;

use App\Router;
use Jenssegers\Blade\Blade;
use React\Http\Message\Response;

/**
 * -----------------------------------------------------------------------
 * Class MVC
 * -----------------------------------------------------------------------
 * This class is responsible for handling all basic operations of the 
 * application, such as rendering views, router, exception handling, etc.
 * 
 */

class MVC{

    public $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    protected function blade()
    {        
        $blade = new Blade('app/Views', 'app/Cache');

        // add support for jsx files
        $blade->addExtension('blade.jsx', 'blade');

        // react initial state directive @reactInitialize
        $blade->directive('reactInitialize', function () {
            
            return "<?php echo '<script type=\"module\">import \"https://unpkg.com/react@18/umd/react.development.js\";import \"https://unpkg.com/react-dom@18/umd/react-dom.development.js\";import \"https://unpkg.com/@babel/standalone/babel.min.js\";</script>'; ?>";

        });

        return $blade;
    }

    public function render($view, $data = [])
    {
        // check if the view is a directory
        $newDir = getcwd() .'/app/Views/'. str_replace('.', '/', $view);
        
        if (is_dir($newDir)) { $view = $view . '@Main'; }

        if (strpos($view, '@') !== false) :
            $components = explode('@', $view);
            $view = str_replace('@', '.', $view); 
            $data['screenComponents'] = "$components[0].Components";
        endif;

        exit($this->blade()->make($view, $data));
    }


    public function view($view, $data = [])
    {
        $blade = new Blade('app/Views', 'app/Cache');

        // add support for jsx files
        $blade->addExtension('blade.jsx', 'blade');
        exit($blade->make($view, $data)); 
    }

    public function getRouter()
    {
        return new Router();
    }

}