docker run -p 3333:80 -it ^
    --rm ^
    -v %cd%:/var/www/html ^
    api
