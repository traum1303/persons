# [Install supervisor for listen queue jobs](https://www.zentao.pm/blog/use-Supervisor-to-manage-Laravel-queue-416.html)

```bash
apt-get update
apt-get install supervisor
```

 After it is installed, supervisord.conf is in /etc. 
 If not, run `echo_supervisord_conf > /etc/supervisord.conf` to create one.

## Check that supervisor config was created
```bash
 echo_supervisord_conf > /etc/supervisord.conf 
 ```


## Run command to create a directory to save configuration files.
```bash 
mkdir /etc/supervisor/
```
 
## Go to this directory and run 
``` bash
touch laravel-worker.conf
``` 

Then laravel-worker.conf is created. Edit this file and enter the configuration as shown below.


sudo vim /etc/supervisor/conf.d/laravel-worker.conf

## laravel-worker.conf
``` conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/persons.local/artisan queue:work --queue=processImport,import --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/persons.local/worker.log
stopwaitsecs=3600

```

Save the file, then go to the end of supervisord.conf and change the path as shown below.
**!!!!!!!!!!!! Remove  ';' .**
## supervisord.conf
``` conf
[include]
files = /etc/supervisor/laravel-worker.conf
```

## Start Supervisor
```bash
supervisord -c /etc/supervisord.conf. 
```
If it is started, use `ps -ef` to check PID and `kill` to finish the task.
```bash
ps -ef to
kill
```

## Listen tasks and keep the queue running

```bash
sudo supervisorctl reread  #Restart all programs in configuration files
sudo supervisorctl update  #Update configurations to supervisord
sudo service supervisor reload
sudo supervisorctl start laravel-queue:*
sudo supervisorctl start laravel-schedule-work:*
```

----------------------------------------------------------------------------------------------------------------------------------------------------------------

# Restart Queue signal

```bash
php artisan queue:restart
```
