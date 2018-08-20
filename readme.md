<h2>Instrucciones</h2>

<ol>
    <li>Instalar Dependencias (composer install)</li>
    <li>Configurar la base de datos (archivo .env)</li>
    <li>Ejecutar <code>php artisan migrate --seed</code></li>
    <li>El sistema tiene un cron job que se ejecuta cada 12 minutos para verificar el estado de la transaccion, para poder usarlo hay que agregar la ruta y comando al crontab</li>
    <li>El sistema envia notificaciones a los usuarios para hacerles saber el estado de su transaccion, esto hace parte del cron job. Para recibir las notificaciones hay que agregar la configuracion de correo SMPT (.env)</li>
   </ol>
        
