<?php


/**
 * The main router class
 *
 * @package Router
 */
class Routerold extends Requestold{


    /** @var Route[] Currently registered routes */
    public $routes = array();

    protected $path;


    function __construct($path){
        $this->path = $path;
    }
    /**
     * Add a route
     *
     * @param string $expr
     * @param callable $callback
     * @param array|string $methods
     * @return void
     */
    public function all($expr, $callback, $methods = null){
        $this->routes[] = new Route($expr, $callback, $methods, $this->method);
    }

    /**
     * Alias for all
     *
     * @param string $expr
     * @param callable $callback
     * @param null|array $methods
     */
    public function add($expr, $callback, $methods = null){
        $this->all($expr, $callback, $methods);
    }

    /**
     * Add a route for GET requests
     *
     * @param string $expr
     * @param callable $callback
     */
    public function get($expr, $callback){
        $this->routes[] = new Route($expr, $callback, 'GET', $this->method);
    }

    /**
     * Add a route for POST requests
     *
     * @param string $expr
     * @param callable $callback
     */
    public function post($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'POST', $this->method);
    }

    /**
     * Add a route for HEAD requests
     *
     * @param string $expr
     * @param callable $callback
     */
    public function head($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'HEAD', $this->method);
    }

    /**
     * Add a route for PUT requests
     *
     * @param string $expr
     * @param callable $callback
     */
    public function put($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'PUT', $this->method);
    }

    /**
     * Add a route for DELETE requests
     *
     * @param string $expr
     * @param callable $callback
     */
    public function delete($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'DELETE', $this->method);
    }

    /**
     * Test all routes until any of them matches
     *
     * @throws RouteNotFoundException if the route doesn't match with any of the registered routes
     */
    public function route(){
        foreach ($this->routes as $route) {
            if ($route->matches($this->path)) {
                return $route->exec();
            }
        }

       // throw new RouteNotFoundException("No routes matching {$this->path}");
    }

    /**
     * Get the current url or the url to a path
     *
     * @param string $path
     * @return string
     */
    public function url($path = null)
    {
        if ($path === null) {
            $path = $this->path;
        }

        return $this->base_path . $path;
    }

    /**
     * Redirect from one url to another
     *
     * @param string $from_path
     * @param string $to_path
     * @param int $code
     */
    public function redirect($from_path, $to_path, $code = 302)
    {
        $this->all($from_path, function () use ($to_path, $code) {
            http_response_code($code);
            header("Location: {$to_path}");
        });
    }


    public function test(){
       prettyPrint($this->routes);
    }
}
