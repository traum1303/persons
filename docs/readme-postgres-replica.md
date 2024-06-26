### Postgres replication
##  Configure Primary Node

```bash
sudo -u postgres psql
CREATE ROLE replica_user WITH REPLICATION LOGIN PASSWORD 'P@ssword321';
postgres-# \q
```

##  Modify configs
```bash
sudo vim /etc/postgresql/14/main/postgresql.conf
```
```conf
listen_addresses = {ip_address}
wal_level = logical
wal_log_hints = on
 ```

## Configure Replica Node and reload postgres
```bash 
sudo vim /etc/postgresql/16/main/pg_hba.conf
host replication replica_user {ip_address}/24 md5
sudo systemctl restart postgresql
sudo systemctl stop postgresql
sudo rm -rv /var/lib/postgresql/16/main/
sudo pg_basebackup -h {ip_address} -U replica_user -X stream -C -S replica_1 -v -R -W -D /var/lib/postgresql/16/main/
sudo chown postgres -R /var/lib/postgresql/16/main/
sudo systemctl start postgresql
```

## Configure .env file
```config 
DB_REPLICA_HOST={replica_ip}
DB_MAIN_HOST={main_ip}
```

## Configure laravel db connection in file persons.local/config/database.php 
```config 
'pgsql' => [
    'read' => [
        'host' => env('DB_REPLICA_HOST', '{replica_ip}')
    ],
    'write' => [
        'host' => env('DB_MAIN_HOST', '{main_ip}')
    ],
 ```