# Harcama Takib (Monitoring of Expenditures). PHP(Slim, tuupola/slim-jwt-auth[token]), vue.js, bootstrap-vue, fortawesome

## Veritabanı İşlemleri (Database Operations)

```
Data dizininde gerekli scriptler mevcuttur. (Required scripts are available in the data directory.)
Aşağıdaki sırayla çalıştırınız. (Run in the following order.)
01-harcama-takib-tablolar.sql
02-nevleri-ekle.sql
03-harcama-gelir-ekle.sql

Veritabanı bilgileri ise şu dosyada tutuluyor:
/ss/src/settings.php
```

## İlk Kurulum (Project setup)

```
npm install
```

### Projenin Derlenmesi ve Çalıştırılması (Compiles and hot-reloads for development) (Varsayılan olarak localhost:8082'den yayın yapacak şekilde ayarlanmıştır.)

```
npm run serve
```

### Rest API Projesinin Çalıştırılması

```
/ss/slim dizinine gidip, aşağıdaki komutu çalıştırınız: (Varsayılan olarak localhost:8081'den yayın yapacak şekilde ayarlanmıştır.)

sh a-php-server.sh
```

### Projenin Derlenerek Hostinge Hazır Hale Getirilmesi (Compiles and minifies for production)

```
npm run build
```

### Customize configuration

See [Configuration Reference](https://cli.vuejs.org/config/).
