<?php


class NotifierPHP{


    public static function send(string $rute, array $data, $type){
        $data = base64_encode(json_encode([
            'header' => [
                'type' => $type
            ],
            'body' => $data
        ]));
        header('Location: '.$rute."?resnp=$data");
        exit;
    }

    public static function isThere(){
        return isset(Request::$data['resnp']) && Request::$method == 'GET' ? true : false;
    }

    public static function get($json = false){
        if(self::isThere()){
            return $json ? base64_decode(Request::$data['resnp']) : json_decode(base64_decode(Request::$data['resnp']));
        }
        return null;
    }

    public static function print(){
        if(self::isThere()){
            $type = self::get()->header->type;
            $body = self::get()->body;
            $delay = 300; // Milisegundos de retraso entre toasts
            $verticalOffset = 0;
            $i = 0;
    
            foreach($body as $data){
                $i++;
                $toastHeight = self::getToastHeight($data); // Obtener la altura de la notificación
                echo self::toast($type, $data, $i, $delay * ($i/5), $verticalOffset, $toastHeight);
                $verticalOffset += $toastHeight + 20; // Incrementar el offset vertical según la altura de la notificación
            }
        }
    }
    
    public static function toast(string $title, string $body, $id, $delay, $verticalOffset, $toastHeight, $time = 'now', $img = ''){
        if(!empty($img)){ $img = '<img src="'.$img.'" class="rounded me-2">'; }
        $toastId = 'toast_' . $id; // Generar un ID único
    
        return '<div class="toast-container" style="position: fixed; top:'.$verticalOffset.'px; right: 0; margin: 10px;">
            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="'.$toastId.'">
              <div class="toast-header">
                '.$img.'
                <strong class="me-auto">'.$title.'</strong>
                <small class="text-muted">'.$time.'</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body" style="max-height: '.$toastHeight.'px; overflow-y: auto;">
                '.$body.'
              </div>
            </div>
          </div>
          <script>
          setTimeout(function() {
              var myAlert = document.getElementById("'.$toastId.'"); 
              var bsAlert = new bootstrap.Toast(myAlert); 
              bsAlert.show(); 
          }, '.$delay.');
          </script>';
    }
    
    public static function getToastHeight($content){
        if(strlen($content) > 50){
            return 90;
        }else if(strlen($content) < 50){
            return 70;
        }else{
            return 200;
        }
    }
    
    
}