sudo yum -y update
sudo yum -y install wget vim
sudo yum -y localinstall jdk-8u131-linux-x64.rpm
sudo wget --no-cookies --no-check-certificate --header "Cookie:oraclelicense=accept-securebackup-cookie" "http://download.oracle.com/otn-pub/java/jdk/8u131-b11/d54c1d3a095b4ff2b6607d096fa80163/jdk-8u131-linux-x64.rpm"
sudo wget https://github.com/dularion/streama/releases/download/v1.1/streama-1.1.war
sudo mkdir /opt/streama
sudo mv streama-1.1.war /opt/streama/streama.war
sudo java -jar /opt/streama/streama.war
sudo mkdir /opt/streama/media
sudo chmod 664 /opt/streama/media

sudo cat <<TEST> /etc/systemd/system/streama.service
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
TEST


sudo systemctl start streama
sudo systemctl enable streama
sudo systemctl restart streama
sudo systemctl status streama
sudo service firewalld status
sudo sestatus
