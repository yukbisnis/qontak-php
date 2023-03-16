<?php

namespace Yubi\Qontak;

class Broadcast extends Request
{


    public function direct($phone, $name, $templateId, $body = [])
    {
        $endpoint = '/api/open/v1/broadcasts/whatsapp/direct';

        $this->setEndpoint('POST', $endpoint);
        $this->setBody($this->formatAttr([
            'to_number' => $phone,
            'to_name' => $name,
            'message_template_id' => $templateId,
            'parameters' => [
                'body' => $body
            ]
        ]));

        $auth = (new Auth)->get();
        if ($auth->status) {
            $this->setApiKey($auth->data->access_token);
        } else {
            return $this;
        }

        $this->withAuth();

        $this->hit();

        if ($this->status == true) {
            $data = json_decode(json_encode($this->responseData));

            $this->data = $data->data;
        }

        return $this;
    }

    protected function formatAttr($value)
    {

        $data = [
            'to_number' => '',
            'to_name' => '',
            'message_template_id' => '',
            'channel_integration_id' => $this->channelId,
            'language' => [
                'code' => 'id'
            ],
            'parameters' => []
        ];

        foreach ($data as $k => $v) {
            if (array_key_exists($k, $value)) {
                $data[$k] = $value[$k];
            }
        }

        return $data;
    }
}
