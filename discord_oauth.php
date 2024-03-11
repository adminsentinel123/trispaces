<?php
class DiscordOAuth {
    private $clientId = '1198625672378187906'; // Replace with your Discord application's client ID
    private $clientSecret = 'DtG872X47udJg-RazkImGDWfirM17XNK'; // Replace with your Discord application's client secret
    private $redirectUri = 'https://www.trispace.xyz/'; // Replace with your redirect URI

    public function redirectToAuthorization() {
        $url = 'https://discord.com/api/oauth2/authorize?client_id=' . $this->clientId . '&redirect_uri=' . urlencode($this->redirectUri) . '&response_type=code&scope=identify'; // Add more scopes if needed
        header('Location: ' . $url);
        exit;
    }

    public function getUser($code) {
        $token = $this->getAccessToken($code);
        if ($token) {
            $user = $this->getUserInfo($token);
            return $user;
        } else {
            return false;
        }
    }

    private function getAccessToken($code) {
        $postData = [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://discord.com/api/oauth2/token',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        if (isset($data['access_token'])) {
            return $data['access_token'];
        } else {
            return false;
        }
    }

    private function getUserInfo($token) {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://discord.com/api/users/@me',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $token
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $user = json_decode($response, true);
        return $user;
    }
}
?>
