<?php

namespace Hasandotprayoga\Qontak;

class Auth extends Request
{

    protected $endpoint = '/oauth/token';

    public function get()
    {
        $this->setEndpoint('POST', $this->endpoint);
        $this->setBody([
            'username' => $this->username,
            'password' => $this->password,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'password'
        ]);

        $this->hit();

        if ($this->status == true) {
            $data = json_decode(json_encode($this->responseData));

            $this->apiKey = $data->access_token;
            $this->data = $data;
        }

        return $this;
    }
}
