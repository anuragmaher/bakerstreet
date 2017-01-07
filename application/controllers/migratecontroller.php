<?php

class MigrateController {
    
    function __construct()
    {
        
    }

    public function userCreationQuery ()
    {
        $query= "CREATE TABLE IF NOT EXISTS `users` (" .
              "`id` int(11) NOT NULL AUTO_INCREMENT, " .
              "`username` varchar(255) NOT NULL, " .
              "`password` varchar(255) NOT NULL," .
              "`lastLogin` datetime DEFAULT NULL," . 
              "`created_at` datetime DEFAULT NULL," . 
              "`updated_at` datetime DEFAULT NULL," . 
              "PRIMARY KEY (`id`)" .
              ") ENGINE=InnoDB DEFAULT CHARSET=latin1; ";
        return $query;
    }

    public function userTokenCreationQuery ()
    {
        return "CREATE TABLE IF NOT EXISTS `authtokens` (" .
              "`id` int(11) NOT NULL AUTO_INCREMENT," .
              "`userid` int(11) NOT NULL," .
              "`token` varchar(255) NOT NULL," .
              "`created_at` datetime DEFAULT NULL," .
              "`updated_at` datetime DEFAULT NULL," .
              "PRIMARY KEY (`id`)," .
              "UNIQUE KEY `token_UNIQUE` (`token`)," .
              "KEY `userid` (`userid`)," .
              "CONSTRAINT `authtokens_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`id`)" .
            ") ENGINE=InnoDB DEFAULT CHARSET=latin1";
    }

    public function productCreationQuery ()
    {
        return "CREATE TABLE IF NOT EXISTS `products` (".
              "`id` int(11) NOT NULL AUTO_INCREMENT,".
              "`name` varchar(255) NOT NULL,".
              "`description` varchar(255) NOT NULL,".
              "`status` varchar(255) NOT NULL,".
              "`created_at` datetime DEFAULT NULL,".
              "`updated_at` datetime DEFAULT NULL,".
              "PRIMARY KEY (`id`)".
            ") ENGINE=InnoDB DEFAULT CHARSET=latin1";
    }

    public function createAdminUser()
    {
        $username = USERNAME;
        $password = Encryption::encrypt(PASSWORD);
        return "insert into `users`(`username`, `password`, `created_at`, `updated_at`) values('$username', '$password', now(), now());";
    }

    public function db()
    {
        $sqlbase = new SQLBase;
        $sqlbase->connect(MYSQL_URI);
        $query = $this->userCreationQuery();
        $sqlbase->insert($query);
        $query = $this->userTokenCreationQuery();
        $sqlbase->insert($query);
        $query = $this->productCreationQuery();
        $sqlbase->insert($query);
        $user = new User;
        $u = $user->getUserByName("admin");
        if(count($u) > 0)
        {
            echo "User already present, skipping";
        }else
        {
            $query = $this->createAdminUser();    
            $sqlbase->insert($query);
        }
        
        return "done";
    }         
}
