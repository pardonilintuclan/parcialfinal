echo "configurando el selinux para desactivarlo"
sudo cat <<TEST> /etc/selinux/config
# This file controls the state of SELinux on the system.
# SELINUX= can take one of these three values:
#     enforcing - SELinux security policy is enforced.
#     permissive - SELinux prints warnings instead of enforcing.
#     disabled - No SELinux policy is loaded.
SELINUX=disabled
# SELINUXTYPE= can take one of three values:
#     targeted - Targeted processes are protected,
#     minimum - Modification of targeted policy. Only selected processes are protected.
#     mls - Multi Level Security protection.
SELINUXTYPE=targeted
TEST

sudo yum install vim -y

sudo service NetworkManager stop
sudo chkconfig NetworkManager off

sudo service firewalld start

sudo firewall-cmd --zone=public --add-interface=eth1 --permanent
sudo firewall-cmd --zone=public --add-service=http --permanent
sudo firewall-cmd --zone=public --add-service=https --permanent
sudo firewall-cmd --zone=public --add-masquerade --permanent
firewall-cmd --zone="public" --add-forward-port=port=443:proto=tcp:toport=443:toaddr=192.168.100.2 --permanent
firewall-cmd --zone="public" --add-forward-port=port=80:proto=tcp:toport=80:toaddr=192.168.100.2 --permanent
firewall-cmd --zone="public" --add-forward-port=port=8080:proto=tcp:toport=8080:toaddr=192.168.100.2 --permanent
sudo firewall-cmd --zone=public --add-port=80/tcp --permanent
sudo firewall-cmd --zone=public --add-port=443/tcp --permanent
sudo firewall-cmd --zone=public --add-port=8080/tcp --permanent

sudo firewall-cmd --reload

sudo firewall-cmd --zone=internal --add-interface=eth2 --permanent
sudo firewall-cmd --zone=internal --add-masquerade --permanent

sudo firewall-cmd --reload

service firewalld start