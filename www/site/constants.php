<?php
define("HOST_URL", 'http://'.$_SERVER['HTTP_HOST']);
define("ROOT_URL", '/');
 
define("M_C_PATH", M_FRAME_PATH."/controllers"); /**путь к mainframe папке контроллеров**/
define("M_M_PATH", M_FRAME_PATH."/models"); /**путь к mainframe папке моделей**/

define("M_LIB_PATH", M_FRAME_PATH."/lib"); /**путь**/
define("M_E_PATH", M_FRAME_PATH."/extensions"); /**путь**/

 
define("S_PATH", ROOT_PATH."/site"); /**путь к папке site**/
define("C_PATH", S_PATH."/controllers"); /**путь к папке контроллеров**/
define("M_PATH", S_PATH."/models"); /**путь к папке моделей**/

define("LIB_PATH", S_PATH."/lib"); /**путь**/
define("E_PATH", S_PATH."/extensions"); /**путь**/
define("T_PATH", S_PATH."/templates"); /**путь к шаблонам**/

define("TMP_PATH", S_PATH."/tmp"); /**tmp папка**/
