Ejercicio Pruebas con Symfony 3.4<br />
David Felipe Márquez González<br />


Para iniciar debe clonar el repositorio con git clone git@github.com:davidmarquez94/optime.git o con Https git clone https://github.com/davidmarquez94/optime.git<br />

Ejecute los siguientes comandos en una terminal<br />
cd optime<br />
composer install<br />
(En este punto configure su acceso a la base de datos para el funcionamiento del sistema)<br />

php bin/console doctrine:database:create<br />
php bin/console doctrine:schema:update --force<br />

Para desplegar la aplicación en local digite:<br />
php bin/console server:run