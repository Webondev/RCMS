<?php

	require_once("site/init.php"); 

	$app = new app;
	
	if(!$app->getController()){
		$app->getController("index", "error404");
	}


/****
 * Created on Nov 24, 2012
Моя Цмс
mainframe - главная папка движка с начальным функционалом
site   		- изменяемая часть, 
models 		- методы для работы с бд заданного контроллера
controllers - мои любимые контроллеры
extensions 	- для разных расширений, так как они бывают разные и очень разные, чтоб не было гемороя по адаптации, 
				все кидаем в одну папку, 
lib 		- тут кидаем разные классы и функции 
ВСЕ КЛАССЫ ДОЛЖНЫ БЫТЬ С РАЗНЫМИ НАЗВАНИЯМИ,
этот движок, делается для достаточно простого освоения и использования. Если нужно что то серьезное - есть yii и другие


запускается 

index.php
||
загружаем контроллер согласно полученному урлу  если ничего нет то загружеам ошибку
$app->getController()

загружая контроллер мы загружаем группу классов






 */
