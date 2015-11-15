<?php

class VkApi
{
    public static function getUsers ($id)
    {
        global $config;
        $url = $config["urls"]["vkUsers"] . $id;
        $responseText = file_get_contents($url);
        $response = json_decode($responseText);

        if (property_exists($response, "error") || count($response->response) === 0) {
            return false;
        }

        return $response->response;
    }

    public static function getUser($id)
    {
        $users = self::getUsers($id);
        if (!$users)
            return false;

        return $users[0];
    }

    public static function isValidUid($uid)
    {
        $user = self::getUser($uid);
        if (!$user)
            return false;

        return $user->uid === $uid;
    }
}