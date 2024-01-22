<?php
namespace Libraries\Services\QR;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QR {

    public function __construct() {
    }

    public function generate_qr_svg($url){
        $options = new QROptions(
            [
              'eccLevel' => QRCode::ECC_L,
              'outputType' => QRCode::OUTPUT_MARKUP_SVG,
              'version' => 5,
            ]
        );

        $qrcode = (new QRCode($options))->render($url);

        return $qrcode;
    }

    public function generate_qr_png($url){
        $options = new QROptions(
            [
              'eccLevel' => QRCode::ECC_L,
              'outputType' => QRCode::OUTPUT_IMAGE_PNG,
              'version' => QRCode::VERSION_AUTO,
            ]
        );

        $qrcode = (new QRCode($options))->render($url);

        return $qrcode;
    }

    

    
}