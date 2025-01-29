<?php

namespace App\Services;

class SshService
{
    /**
     * @return resource
     * @throws \Exception
     */
    public function connect()
    {
        $connect = ssh2_connect(config('ssh.host'));
        if(!$connect){
            throw new \Exception('Connection to SSH failed');
        }
        if(!ssh2_auth_password($connect, config('ssh.user'), config('ssh.password'))){
            throw new \Exception('Password authentication failed');
        }
        return $connect;
    }
}
