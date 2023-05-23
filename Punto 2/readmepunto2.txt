-Crear la carpeta para guardar el vagrant file junto con los archivos .sh del aprovisionamiento y una carpeta que estará sincronizada con vagrant en nuestro caso se llama Syncvagrant.
-Dentro de Syncvagrant copiamos un archivo de video el cual usaremos más adelante
-Abrir la consola del sistema
-Por medio de comandos entrar a la carpeta donde copiaste el 
vagrantfile y los archivos de aprovisionamiento
-Ejecutar powershell
-Ejecutar el comando
Vagrant up
-Esperar a que las maquinas se aprovisionen y autoconfiguren las maquinas
-En caso de que alguno de los comandos falle abrir el correspondiente archivo .sh y ponerlos manualmente
-Comprobar que en la maquina firewall esté funcionando el servicio de firewall
service firewalld status
-Si está apagado ejecutar el comando service o en algunos casos te dirá que lo ejecutes con el comando systmctl
service firewalld start 
ó
systemctl start firewalld
-En la máquina del servicio streama nos aseguramos de que el servicio streama este ejecutando
service firewalld status
-Si está apagado ejecutar el comando service o en algunos casos te dirá que lo ejecutes con el comando systmctl
service streama start 
ó
systemctl start streama
-Si sale un error de que streama no es detectado como un servicio revisamos que exita el documento en la ruta 
/etc/systemd/system/streama.service
-En caso de no existir copiamos lo siguiente

[Unit]
Description=Streama Server
After=syslog.target
After=network.target

[Service]
User=root
Type=simple
ExecStart=/bin/java -jar /opt/streama/streama.war
Restart=always
StandardOutput=syslog
StandardError=syslog
SyslogIdentifier=Streama

[Install]
WantedBy=multi-user.target


-Desde la consola de la maquina streama copiamos el archivo de video de nuestra carpeta sincronizada en la carpeta media de la maquina streama
cd /vagrant
cp archivodevideo /opt/streama/media
-Guardamos y ejecutamos los comandos de servicio
service streama start 
ó
systemctl start streama
-Abrimos nuestro navegador y entramos a
http://192.168.1.131:8080/
-Aparecera la pagina de inicio de streama e inisiamos sesion
Usuario:admin
Contraseña:admin
-Desde la interfaz de streama al ingresar con las credenciales de admin nos redireccionara a el panel de configuración de streama en este configuraremos las casillas marcada con asterisco "*" que son  
Upload Directory * :/opt/streama
Base URL *:http://192.168.1.131:8080/
Local Video Files:/opt/streama/media
-Damos Apply a todos los cambios, subimos lo más que pueda el scroll lateral y damos save settings
-En la parte superior derecha al lado del usuario admin escojemos la opcion Manage content
-Damos click en Movies, Create new Movie, ponemos un nombre al video y le damos a Save
-Ahora se creará un recuadro el cual no tendra adjunto ningun video le damos click al boton rojo enorme que aparece y podemos arrastrar un archivo o dar en local files y nos mostrará todos los archivos de video que tenemos en la carpeta media de la maquina streama y cerramos con el boton close
-En menú Dashboard tendremos ya disponible para visualizar el video

