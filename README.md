Monitoring Tool
==========

The goal of this project is to develop a simple way to monitor servers, with very specific sensors

The project just started, no help is required for the moment

Thanks

Installation :
==============

####Server prerequisite :

```
apt-get install phpmyadmin php5-snmp
```
####Client prerequisite :

```
apt-get install snmpd
```

Snmp port must be reachable

####Server installation

* Unzip or svn checkout files in /var/www/monitoring on your server
* mv config.sample.php config.php
* edit config.php with your mysql environnement
* inject install/monitoring_db.sql in your database
* go to http://localhost/monitoring or http://YOURIP/monitoring

