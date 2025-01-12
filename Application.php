<?php
namespace eork\phpmvc;

use eork\phpmvc\db\Database;
use eork\phpmvc\db\DbModel;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Application
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc
  *
  */

  class Application
  {
    const EVENT_BEFORE_REQUEST = "beforeRequest";
    const EVENT_AFTER_REQUEST = "afterRequest";

    protected array $eventListners = [];

    public string $layout = 'main';
    public string $userClass;
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Session $session;
    public Database $db;
    public ?UserModel $user;
    public ?Controller $controller = null;
    public View $view;

    public function __construct($rootPath, array $config)
    {
      $this->userClass = $config['userClass'];
      self::$ROOT_DIR = $rootPath;
      self::$app = $this;

      $this->request = new Request();
      $this->response = new Response();
      $this->session = new Session();
      $this->router = new Router($this->request, $this->response);

      $this->view = new View();
      $this->db = new Database($config['db']);

      $primaryValue = $this->session->get('user');
      
      if($primaryValue){
        $primaryKey = $this->userClass::primaryKey();
        $this->user = $this->userClass::findOne([ $primaryKey => $primaryValue ]);  
      }else{
        $this->user = null;
      }
      
    }
    
    public function run(){
      $this->triggerEvent(self::EVENT_BEFORE_REQUEST);
      try{
        echo $this->router->resolve();
      }catch(\Exception $e){
        $this->response->setStatusCode($e->getCode());
        echo Application::$app->view->renderView('_error', [
          'exception' => $e
        ]);
      }
        
    }

    public function getController(): \eork\phpmvc\Controller
    {
      return $this->controller;
    }

    public function setController(\eork\phpmvc\Controller $controller): void
    {
      $this->controller = $controller;
    }

    public static function isGuest()
    {
      return !(self::$app->user);
    }

    public function login(UserModel $user)
    {
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
      $this->user = null;
      $this->session->remove('user');

    }

    public function triggerEvent($eventName)
    {
      $callbacks = $this->eventListners[$eventName] ?? [];

      foreach($callbacks as $callback){
        call_user_func($callback);
      }
    }

    public function on($eventName, $callback)
    {
      $this->eventListners[$eventName][] = $callback;
    }
  }