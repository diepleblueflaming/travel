<?php

/**
 * Created by PhpStorm.
 * user: Administrator
 * Date: 10/2/2016
 * Time: 2:56 PM
 */
class RestHandler extends simpleRest
{
    // lay du lieu tu database.
    public function  getData($type,$requestContentType,$rawData)
    {
        $statusCode = 200;
        if (!$rawData) {
            // neu khong co du lieu thi gan trang thai la not found.
            $statusCode = 404;
        }

        $this->setHttpHeaders($requestContentType, $statusCode);

        // neu khong co du lieu dung chuong trinh.
        if(!$rawData){
            exit("No found data");
        }

        // neu request la application/json thi ma hoa du lieu ve dang json.
        if (strpos($requestContentType, 'application/json') !== false) {
            $data= $this->encodeJson($rawData,$type);

            //$this->download($data,"js");
            return $data;
        // neu la text/html thi ma hoa ve dang html.
        } else if (strpos($requestContentType, 'text/html') !== false) {
            return $this->encodeHtml($rawData,$type);
        // neu la application/xml thi ma hoa ve dang xml.
        }else if(strpos($requestContentType,"application/xml")!==false) {
            return $this->encodeXml($rawData,$type);
        }
    }

    // chuyen du lieu ve dang json.
    public function encodeJson($responseData,$type)
    {
        if($type=="news"){
            foreach($responseData as &$item) {
                $item['detail_content']=strip_tags($item['detail_content']);
            }
        }
        $returnData = json_encode($responseData,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        return $returnData;
    }

    // chuyen du lieu ve dang xml.
    public function  encodeXml($responseData,$type)
    {
        // ham chuyen du lieu tu mang sang cau truc xml.
        function array_to_xml( $data, &$xml_data ,$type) {
            // duyet mang du lieu.
            foreach( $data as $key => $value ) {
                // neu key la so thi gan lai la the <category>
                if( is_numeric($key) ){
                    $key = $type;
                }
                // neu value la mot mang. ta de quy lai
                if( is_array($value) ) {
                    // luc nay key la mang va value la mang con cua no.
                    $subnode = $xml_data->addChild($key);
                    array_to_xml($value, $subnode,$type);
                } else {
                    // chuan hoa key
                    $xml_data->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }

        // tao moi doi tuong SimpleXMLElement
        $xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><data></data>');

        // chuyen doi mang du lieu tu mang sang cau truc xml.
        array_to_xml($responseData,$xml_data,$type);

        $result = $xml_data->asXML();
        return $result;
    }

    // chuyen du lieu ve dang html.
    public function  encodeHtml($responseData, $type)
    {
        switch($type) {

            case 'news': {
                $htmlResponse = "<style>.large-data{height: 150px; overflow-y: auto}</style><table border='1'>";
                $htmlResponse .= "<tr><th>id</th><th>tieu_de</th><th>noi dung</th><th>noi dung chi tiet</th>
                                <th>chuyen muc</th><th>nguoi dang</th><th>ngay dang</th><th>luot xem</th></tr>";
                foreach ($responseData as $item) {
                    $htmlResponse .= '<tr><td>' . $item['id'] . '</td>';
                    $htmlResponse .= '<td><div class="large-data">' . $item['title'] . '</div></td>';
                    $htmlResponse .= '<td><div class="large-data">' . $item['content'] . '</div></td>';
                    $htmlResponse .= '<td><div class="large-data">' . strip_tags($item['detail_content']) . '</div></td>';
                    $htmlResponse .= '<td>' . $item['category'] . '</td>';
                    $htmlResponse .= '<td>' . $item['sender'] . '</td>';
                    $htmlResponse .= '<td>' . $item['date_create'] . '</td>';
                    $htmlResponse .= '<td>' . $item['views'] . '</td></tr>';
                }
                $htmlResponse .= "</table>";
                return $htmlResponse;
            }
            case 'category' : {
                $htmlResponse = "<table border='1'><tr><th>id</th><th>tieu de</th><th>chuyen_muc_cha</th></tr>";
                foreach ($responseData as $item) {
                    $htmlResponse .= '<tr><td>' . $item['id'] . '</td>';
                    $htmlResponse .= '<td>' . $item['title'] . '</td>';
                    $htmlResponse .= '<td>' . $item['chuyen_muc_cha'] . '</td></tr>';
                }
                $htmlResponse .= "</table>";
                return $htmlResponse;
            }
            case 'comment' : {
                $htmlResponse = "<table border='1'><tr><th>id</th><th>news</th><th>content</th>
                            <th>poster</th><th>date_posted</th></tr>";
                foreach ($responseData as $item) {
                    $htmlResponse .= '<tr><td>' . $item['id'] . '</td>';
                    $htmlResponse .= '<td>' . $item['news'] . '</td>';
                    $htmlResponse .= '<td>' . $item['content'] . '</td>';
                    $htmlResponse .= '<td>' . $item['user_comment'] . '</td>';
                    $htmlResponse .= '<td>' . $item['date_create'] . '</td></tr>';
                }
                $htmlResponse .= "</table>";
                return $htmlResponse;
            }
            case 'user' : {
                $htmlResponse = "<table border='1'><tr><th>id</th><th>username</th><th>email</th>
                            <th>address</th><th>phone</th><th>level</th></tr>";
                foreach ($responseData as $item) {
                    $htmlResponse .= '<tr><td>' . $item['id'] . '</td>';
                    $htmlResponse .= '<td>' . $item['username'] . '</td>';
                    $htmlResponse .= '<td>' . $item['email'] . '</td>';
                    $htmlResponse .= '<td>' . $item['address'] . '</td>';
                    $htmlResponse .= '<td>' . $item['phone'] . '</td>';
                    $htmlResponse .= '<td>' . $item['level'] . '</td></tr>';
                }
                $htmlResponse .= "</table>";
                return $htmlResponse;
            }
        }

    }

    // ham thuc hien tu dong tai xuong file du lieu theo dinh dang.
    public function download($data,$type){

        $file=fopen("fileData.".$type,"w");
        fwrite($file,$data);
        fclose($file);

        $file_url = 'fileData.'.$type;
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename='".$file_url."'");
        readfile($file_url);
        unlink("fileData.".$type);
    }
}