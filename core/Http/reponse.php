<?php 


class Response extends Request{
    /**
     * Send API output.
     *
     * @param mixed  $data
     * @param string $httpHeader
     */
    protected function response($data, $httpHeaders=array()){
        header_remove('Set-Cookie');
 
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
 
        echo $data;
       // exit;
    }


    public function res($response, $errorResponseBody = null, $errorResponseHeader = null){
        if($errorResponseBody == null){
            $this->response(
                json_encode($response),
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
       }else{
            $this->response(
                json_encode(array("error" => $errorResponseBody)),
                array('Content-Type: application/json', $errorResponseHeader)
            );
       }
    }
}