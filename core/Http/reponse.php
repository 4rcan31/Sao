<?php 


class Response extends Request{
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function response($data, $code = 200,  $httpHeaders=array()){
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        
        echo $data;
        http_response_code($code);
        return 0;
       // exit;
    }


    public function res($response, $code = 200,  $errorResponseBody = null, $errorResponseHeader = null){
        if($errorResponseBody == null){
            $this->response(
                json_encode($response), $code,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
       }else{
            $this->response(
                json_encode(array("error" => $errorResponseBody)), $code,
                array('Content-Type: application/json', $errorResponseHeader)
            );
       }
    }
}