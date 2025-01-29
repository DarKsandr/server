<?php

namespace App\Services;

use App\Enums\OSEnum;

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

    /**
     * @param resource $connect
     * @param string $command
     * @return string
     * @throws \Exception
     */
    public function exec($connect, string $command, OSEnum $os = OSEnum::LINUX): string
    {
        $stdout_stream  = ssh2_exec($connect, $command);

        if($os === OSEnum::WINDOWS){
            return '';
        }

        $sio_stream = ssh2_fetch_stream($stdout_stream, SSH2_STREAM_STDIO);
        $err_stream = ssh2_fetch_stream($stdout_stream, SSH2_STREAM_STDERR);

        stream_set_blocking($sio_stream, true);
        stream_set_blocking($err_stream, true);

        $error = stream_get_contents($err_stream);

        if(!empty($error)){
            throw new \Exception($error);
        }

        return stream_get_contents($sio_stream);
    }
}
