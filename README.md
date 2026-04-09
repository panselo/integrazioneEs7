# Installazioni
<h4>Aggiorna repository e controlla versioni aggiornate </h4>

$sudo apt update

<h4>Installazione lamp server</h4>

$sudo apt install lamp-server^

<h4>Avviare il servizio apache</h4>

$sudo service apache2 start

<h4>Avviare il servizio mysql</h4>

$sudo service mysql start

<h4>Installazione phpmyadmin</h4>

$sudo apt install phpmyadmin

# Configurazioni

<h4>Modificare il file /etc/apache2/apache2.conf</h4>
$ sudo nano /etc/apache2/apache2.conf

  <i>inserire la seguente riga alla fine del file</i>
  
    Include /etc/phpmyadmin/apache.conf  

<h4>Modificare il file /etc/phpmyadmin/config-db.php</h4>
$ sudo nano /etc/phpmyadmin/config-db.php   
 
  <i>Impostare</i> 
  
  $dbserver='127.0.0.1';


<h4>Riavviare apache</h4>

$sudo service apache2 restart

<h4>Individuare le credenziali di default nel file /etc/mysql/debian.cnf (username e password di default per mysql)</h4>

<h4>Abilita la porta 80 e rendi il link pubblico</h4>

<h4>Accedere a phpmyadmin con le credenziali di default e modificare la password di root</h4>

ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'TUA_PASSWORD';

<h4>Accedere a phpmyadmin con la password di root</h4>
