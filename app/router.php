<?php

class Route
{
	static function start()
	{  //если пользователь не зарегистрирован то дынные контроллеры ему будут запрещены
			//sha1() - это костыль, если интересно объясню))
		$forbidden_for_unreg = array("","profile","cabinet", "error_pages");
	
		// контроллер и действие по умолчанию
		$routes = explode('/', Library::clearStr($_SERVER['REQUEST_URI']));
		
		// получаем имя контроллера
		error_log("Error:".$_SERVER['REQUEST_URI'], 0);
		if ( !empty($routes[1]) )
		{	if(@$_SESSION['user']){
				if($routes[1] == 'main'){
					$controller_name = 'cabinet';
				}else{
					$controller_name = $routes[1];
				}
			}else{
				if(array_search(strtolower($routes[1]), $forbidden_for_unreg, true)){
					throw new Forbidden('Доступ запрещен. Зарегистрируйтесь и войдите');
					//$controller_name = 'main';
				}else{
					$controller_name = $routes[1];
				}
			}
		}else{
			if(@$_SESSION['user']){
				$default_conrtoller = 'cabinet';
			}else{
				$default_conrtoller = 'main';
			}
			$controller_name = $default_conrtoller;
		}
		$query_vars = '';
		// получаем имя экшена
		if ( !empty($routes[2]) )
		{	
			if(!strpos($routes[2],'?')){
				$action_name = $routes[2];
			}else{
				list($action, $query) = explode('?',$routes[2]);
				$action_name = $action;
				if(!empty($query)){
					$query_vars = array();
					if(strpos($query,'&')){
						foreach(explode('&',$query) as $row){
						//Делим каждую полученную строку на параметр=значение
							@list($var, $val) = @explode('=',$row);
							$query_vars[$var] = $val;
						}
					}else{
						//Делим полученную строку на параметр=значение;
						list($var, $val) = explode('=',$query);
							$query_vars[$var] = $val;
						}
				}
			}
		}else{
			$action_name = 'index';
		}
		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		// подцепляем файл с классом модели
		$model_file = strtolower($model_name).'.php';
		$model_path = "app/models/".$model_file;
		if(file_exists($model_path))
		{
			include "app/models/".$model_file;
		}

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = "app/controllers/".$controller_file;
		if(file_exists($controller_path))
		{
			include "app/controllers/".$controller_file;
		}
		else
		{
			throw new NotFound("Несуществующее имя контроллера");
		}
		
		// создаем контроллер
		$controller = new $controller_name;
		$action = $action_name;
		
		if(method_exists($controller, $action))
		{
			// вызываем действие контроллера
			if(!$query_vars){
				$controller->$action();
			}else{
				$controller->$action($query_vars);
			}
		}
		else
		{
			throw new NotFound("Несуществующеий метод класса");
		}
	
	}
    
}
