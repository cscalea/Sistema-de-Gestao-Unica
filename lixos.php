public function verifyDuplicatedEmail($email);

----

public function verifyDuplicatedEmail($email){
        $stmt = $this->conn->prepare("SELECT email FROM users");
        $stmt->execute();
        $usersemail[] = $stmt->fetchAll();
        foreach($usersemail as $ue){  
            $useremail[] = $ue;  
            if($ue = $email){
                $this->message->setMessage("O e-mail já está cadastrado em nosso sistema", 'error', 'back');
            }
        }
        
    }

----

    $userDao->verifyDuplicatedEmail($email);

----


