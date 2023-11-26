# Kamiseta galeria
# Asier Pérez, Oier Cao, Brando Insausti, Uhaitz Errekalde, Bitor Delgado eta Luken Escobero

# Erabiltzeko instrukzioak:
1. Web irudia eraiki direktorioan egonda
```
$ docker build -t="web" .
```
2. img eta logs direktorioen baimenak aldatu apachek idatzi ahal izateko, horrela logak eta irudiak erabili ahalko ditugu
```
$ sudo chmod -R 777 app/img
$ sudo chmod -R 777 app/logs
```
3. Zerbitzuen edukiontziak hasi detached moduan
```
$ docker-compose up -d
```
4. Datu basearen dump-a inportatu
```
http://localhost:8890/ direkzioan 5YJBO8FCH1R2poV erabiltzailea eta HYLXpp1lrxI36o0 pasahitza erabiliz "importar" atalean db.sql fitxategia igo
```
5. Web sisteman sartu
```
http://localhost:81/ direkzioan sartu eta web orrialdea erabili 
```
# Erabilitako baliabideak:
<https://www.w3schools.com/php/php_mysql_connect.asp>
<https://www.youtube.com/watch?v=hlwlM4a5rxg>
<https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/isNaN>
<https://donnierock.com/2011/11/05/validar-un-dni-con-javascript/>
<https://www.youtube.com/watch?v=7TRVudILZf4>
<https://www.youtube.com/watch?v=JAgd_L3GhI0>
<https://www.youtube.com/watch?v=FEmysQARWFU>
<https://stackoverflow.com/questions/58514150/how-to-upload-image-to-phpmyadmin-database-and-save-it-to-a-specific-username>
<https://www.youtube.com/watch?v=0mAL4UuVWbU>
