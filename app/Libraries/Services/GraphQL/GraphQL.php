<?php

namespace Libraries\Services\GraphQL;

$query_result = [
    "successful" => false,
    "response" => [],
    "error_message" => [],
    "errors" => [],
];

class GraphQL {

    private $_end_point;
    private $_api_key;
    private $_id_token;
    private $_ch;

    /**
     * Class constructor
     */
    public function __construct($end_point, $api_key, $id_token) {
        $this->_initialize($end_point, $api_key, $id_token);
    }

    /**
     * Class destructor (do cleanup)
     */
    public function __destruct() {
    }

    public function query($query_name, $variables) {

        $graphqlPayloadJson = $this->_payload($query_name, $variables);

        $this->_connect();
        
        $result = $this->_send($graphqlPayloadJson);
        
        $this->_close();

        // Check for errors and handle the response
        if (isset($result->errors)) {
            $query_result["successful"] = false;

            $html = "<ul>";

            $i = 0;
            foreach($result->errors as $error) {
                $query_result["error_message"][$i] = $error->message;
                $html = $html . "<li>" . $error->message . "</li>";
                $i++;
            }

            $html = $html . " </ul>";

            $query_result["errors"] = $result->errors;

            $session = service("session");
            $response = service("response");

            if (isset($result->errors[0]->errorType)) {
                if($result->errors[0]->errorType == "UnauthorizedException") {
                    $session->setFlashdata("fail-message", $result->errors[0]->message);
                    $response->redirect(site_url('/login'))->send();
                    exit;
                }
            }
            
            $session->setFlashdata("fail-message", $html);
            $response->redirect(site_url('/error/graphql'))->send();
            exit;
        } else {
            $query_result["successful"] = true;
            $query_result["response"] = $result;
        }

        return $query_result;
    }

    // private function _get_query($query_name) {
    //     return $mutation_update_settings;
    //     return $$query_name;
    // }

    // private function _payload($query, $variables) {
    //     return json_encode(["query" => $query, "variables" => $variables]);
    // }

    private function _initialize($end_point, $api_key, $id_token) {
        $this->_end_point = $end_point;
        $this->_api_key = $api_key;
        $this->_id_token = $id_token;
    }

    private function _connect() {
        // Prepare HTTP headers for the request
        $headers = [
            "Content-Type: application/json;charset=utf-8",
            'User-Agent: PHP Script',
            'Authorization: ' . $this->_id_token, 
            "x-api-key: " . $this->_api_key,
        ];

        $this->_ch = curl_init($this->_end_point); // cURL Session Handle
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->_ch, CURLOPT_POST, true);
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
    }

    private function _payload($query_name, $variables) {
        $q = file_get_contents(GRAPGQL_QUERIES_PATH . $query_name . ".graphql");

        if ($q === false) {
            die('Failed to read the query file.'); // Handle error; the file couldn't be read
        }

        $query =    <<<GRAPHQL
                    $q
                    GRAPHQL;

        return json_encode(['query' => $query, 'variables' => $variables]);
    }

    private function _send($graphqlPayloadJson) {
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $graphqlPayloadJson);
        
        // Execute the POST request
        $response = curl_exec($this->_ch);

        return json_decode($response);
    }

    private function _close() {
        curl_close($this->_ch);
    }
}