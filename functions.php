<?php
require_once 'easybitcoin.php';

class Functions
{
    protected $bitcoin;
    protected $username = 'unra';
    protected $password = 'unrapass';
    protected $host = '127.0.0.1';
    protected $port = '4370';
//    protected $port = '6472';

    public function __construct()
    {
        $this->bitcoin = new Bitcoin($this->username, $this->password, $this->host, $this->port);
    }

    //=============================================================== custom methods
    public function toJson($data){
        return json_encode($data);
    }
    //=============================================================== general methods
    public function getBlockchainParams()
    {
        return $this->bitcoin->getblockchainparams();
    }

    public function getRuntimeParams()
    {
        return $this->bitcoin->getruntimeparams();
    }

    public function setRuntimeParam($param_name, $value)
    {
        return $this->bitcoin->setruntimeparam($param_name, $value);
    }

    public function getInfo()
    {
        return $this->bitcoin->getinfo();
    }

    //=============================================================== managing wallet addresses
    public function getAddresses($verbose)
    {
        return $this->bitcoin->getaddresses($verbose);
    }

    public function getAllAddresses()
    {
        return $this->bitcoin->getaddresses();
    }

    public function getNewAddresses()
    {
        return $this->bitcoin->getnewaddresses();
    }

    public function getUploadAsset()    //----------- not implemented
    {
        return $this->bitcoin;
    }

    public function grantPermission()  //----------- not implemented
    {
        return $this->bitcoin;
    }

    //=============================================================== streams

    public function createStream($stream)
    {
        return $this->bitcoin->create("stream", $stream, false);
    }

    public function liststreams()
    {
        return $this->bitcoin->liststreams();
    }

    public function listStreamItems($stream)
    {
        return $this->bitcoin->liststreamitems($stream);
    }

    public function publishFrom($stream)
    {
        return $this->bitcoin->liststreamitems($stream);
    }


    public function hashImage($path)
    {
//        $path = 'myfolder/myimage.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    public function addAssets($address, $asset_name, $image)
    {
        $quantity = 1;
        $smallest_unit = 1;
        $native_amount = 0;
        $custom_fields = array('file' => $image);
        return $this->bitcoin->issue($address, $asset_name, $quantity, $smallest_unit, $native_amount, $custom_fields);
    }

    public function listAssets(){
        return $this->bitcoin->listassets();
    }

    //=============================================================== Permissions management

    public function grantFrom($from, $to, $permissions){
        return $this->bitcoin->grantfrom($from,$to,$permissions); //permissions = a string of permissions comma delimited
    }

    public function revokeFrom($from, $to, $permissions)
    {
        return $this->bitcoin->revokefrom($from, $to, $permissions); //permissions = a string of permissions comma delimited
    }

    public function listPermissions()
    {
        $permissions = 'issue';
        $addresses = $this->bitcoin->listpermissions($permissions);
        return $addresses[0]['address'];
    }

    public function listIssuePermissions()
    {
        $address_list = [];
        $permissions = 'issue';
        $addresses = $this->bitcoin->listpermissions($permissions);
        foreach($addresses as $item) {
            array_push($address_list,$item['address']);
        }
        return $address_list;
    }

    //------------------------------------- return errors
    public function getErrors()
    {
        return $this->bitcoin->error;
    }

    public function upload($filepath){
//        if (isset($_POST['submit']))
//        {
            $filename = basename($filepath);
//            $filename = $_FILES["file"]["name"];
            $file_basename = substr($filename, 0, strripos($filename, '.')); // get file name
            $file_ext = substr($filename, strripos($filename, '.')); // get file extention
            $filesize = $_FILES["file"]["size"];
            $allowed_file_types = array('.png','.jpg','.pdf','.jpeg');

            if (in_array($file_ext,$allowed_file_types) && ($filesize < 200000))
            {
                // Rename file
                $newfilename = md5($file_basename) . $file_ext;
                if (file_exists("uploads/" . $newfilename))
                {
                    // file already exists error
                    echo "You have already uploaded this file.";
                }
                else
                {
                    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);
                    echo "File uploaded successfully.";
                }
            }
            elseif (empty($file_basename))
            {
                // file selection error
                echo "Please select a file to upload.";
            }
            elseif ($filesize > 200000)
            {
                // file size error
                echo "The file you are trying to upload is too large.";
            }
            else
            {
                // file type error
                echo "Only these file typs are allowed for upload: " . implode(', ',$allowed_file_types);
                unlink($_FILES["file"]["tmp_name"]);
            }
//        }
    }


}