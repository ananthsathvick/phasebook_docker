## Phasebook 

Clone of Facebook - A socail media networking site implemented using relational database (MySql). Built using laravel php framework and using MySQL R-DB.

Original Project Source code can be found here - [Phasebook!](https://github.com/ananthsathvick/phasebook)

Prerequisites To Run  
- Docker Engine Running on Host machine [Docker!](https://www.docker.com/)  
- Docker Compose v3.x [Docker Compose!](https://docs.docker.com/compose/)

To view the project on your local system - Run the following in your terminal

        $git clone https://github.com/ananthsathvick/phasebook_docker.git
        
        $cd phasebook_docker
        
        $docker-compose build app
        
        $docker-compose up -d
        
        $docker-compose exec app composer install
        
        $docker-compose exec app php artisan key:generate
        
After Executing These Commands Successfully You Should Be Able to See The App Running at `http://server_domain_or_IP:8000`

If you are running on your localhost then `http://localhost:8000`


        
     
        
        
        
        
        
        
        
        
