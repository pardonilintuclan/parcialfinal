-Crear la carpeta para guardar el vagrant file junto con 
los archivos .sh del aprovisionamiento
-Abrir la consola del sistema
-Por medio de comandos entrar a la carpeta donde copiaste el 
vagrantfile y los archivos de aprovisionamiento
-Ejecutar powershell
-Ejecutar el comando
Vagrant up
-Esperar a que las maquinas se aprovisionen y autoconfiguren las maquinas
-En caso de que alguno de los comandos falle abrir el correspondiente archivo .sh y ponerlos manualmente
-Comprovar que en la maquina firewall este funcionando el servicio de firewall
service firewalld status
-Si esta apagado ejecutar el comando service o en algunos caso te dira que lo ejecutes con el comando systmctl
service firewalld start 
ó
systemctl start firewalld
-En la maquina del servicio streama nos aseguramos de que el servicio streama este ejecutando
service firewalld status
-Si esta apagado ejecutar el comando service o en algunos caso te dira que lo ejecutes con el comando systmctl
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
-Guardamos y ejecutamos los comandos de servicio
service streama start 
ó
systemctl start streama
-Abrimos nuestro navegador y entramos a
http://192.168.1.131:8080/
-Aparecera la pagina de inicio de streama e inisiamos sesion
Usuario:admin
Contraseña:admin
