@ECHO OFF

REM Genesis Project Paths
SET GENESIS_PROJECT_PATH=%cd%

if exist node_modules ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\node_modules...
	rd /s /q %GENESIS_PROJECT_PATH%\node_modules\
    pause
)

if exist %GENESIS_PROJECT_PATH%\assets\common\node_modules ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\assets\common\node_modules...
	rd /s /q %GENESIS_PROJECT_PATH%\assets\common\node_modules\
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\common\node_modules ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\common\node_modules...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\common\node_modules\
    pause
)

if exist %GENESIS_PROJECT_PATH%\engines\common\nucleus\node_modules ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\engines\common\nucleus\node_modules...
	rd /s /q %GENESIS_PROJECT_PATH%\engines\common\nucleus\node_modules\
    pause
)

if exist %GENESIS_PROJECT_PATH%\bin\builder\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\bin\builder\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\bin\builder\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\joomla\plg_system_gantry5_debugbar\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\joomla\plg_system_gantry5_debugbar\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\joomla\plg_system_gantry5_debugbar\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\compat\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\compat\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\compat\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\compat\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\compat\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\compat\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5_debugbar\vendor ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5_debugbar\vendor...
	rd /s /q %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5_debugbar\vendor
    pause
)

if exist %GENESIS_PROJECT_PATH%\bin\builder\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\bin\builder\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\bin\builder\composer.lock
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\composer.lock
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\joomla\plg_system_gantry5_debugbar\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\joomla\plg_system_gantry5_debugbar\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\platforms\joomla\plg_system_gantry5_debugbar\composer.lock
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\compat\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\compat\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\platforms\joomla\lib_gantry5\compat\composer.lock
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\composer.lock
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\compat\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\compat\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5\compat\composer.lock
    pause
)

if exist %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5_debugbar\composer.lock ( 
    echo Deleting Folder %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5_debugbar\composer.lock...
	DEL %GENESIS_PROJECT_PATH%\platforms\wordpress\gantry5_debugbar\composer.lock
    pause
)
