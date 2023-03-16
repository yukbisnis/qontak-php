<?php

namespace Hasandotprayoga\Qontak;

class Qontak extends Singleton
{
    public static function getTemplate()
    {
        $data = (new Template);
        $data->get();

        return $data->getResponse();
    }

    public static function send($phone, $name, $templateId, $params)
    {
        $data = (new Broadcast);
        $data->direct(
            self::cleanPhone($phone),
            $name,
            $templateId,
            $params
        );

        return $data->getResponse();
    }

    protected static function cleanPhone($phone)
    {

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) > 0) {
            $cleanChars = [
                '+',
                '0',
                '62',
            ];

            foreach ($cleanChars as $value) {
                $phone = ltrim($phone, $value);
            }

            $phone = '62' . $phone;
        }

        return $phone;
    }
}
