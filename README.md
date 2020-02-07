Ejercicio Pruebas con Symfony 3.4
David Felipe Márquez González


Para iniciar debe clonar el repositorio con git clone git@github.com:davidmarquez94/optime.git o con Https git clone https://github.com/davidmarquez94/optime.git

Ejecute los siguientes comandos en una terminal
cd optime
composer install
(En este punto configure su acceso a la base de datos para el funcionamiento del sistema)

php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force

Para desplegar la aplicación en local digite:
php bin/console server:run