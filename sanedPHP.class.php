<?php 
class sanedPHP {

    public $dir = 'scans';
    public $chmod = 777;
    public $format = Array('jpg', 'png', 'bmp', 'tiff');
    public $mode = Array('color', 'gray', 'lineart');
    public $resolution = Array(75, 300, 600, 1200);

    /*
     *  Utils
     */
    function getPath($s, $f){
        return './'.$this->dir.'/'.$s.'.'.$f;
    }

    function chmodScan($s, $f){
        $cmd = 'chmod '.$this->chmod.' '.$this->getPath($s, $f);
        shell_exec($cmd);
    }

    function convertScan($s, $f){
        $fd = 'tiff';
        $cmd = 'convert '.$this->getPath($s, $fd).' '.$this->getPath($s, $f);
        var_dump($cmd);
        shell_exec($cmd);
        if(!is_file($this->getPath($s, $f))){
            return false;
        }else{
            unlink($this->getPath($s, $fd));
            return true;
        }
    }

    /*
     *  UI
     */
    function viewScan($s, $f){
        $q = $_POST;
        $q['op'] = 'view';
        $qs = '';
        foreach($q as $k => $v){
            $qs .= '&'.$k.'='.$v;
        }
        header('Location: ./?file='.$s.$qs);
    }

    /*
     *  Work with device
     */
	function checkScanners(){
		$exec = shell_exec('sane-find-scanner');
        if(stristr($exec, 'No SCSI scanners found') || stristr($exec, 'No USB scanners found')){
            return true;
        }
	}

	function getScanners(){
		if($this->checkScanners()) {
		    $cmd = 'scanimage -f \'{"id":"%d","vendor":"%v","model":"%m","type":"%t","index":"%i"}%n\'';
            $exec = shell_exec($cmd);
            if($exec){
                $list = explode(PHP_EOL, $exec);
                foreach($list as $device){
                    $data = json_decode($device, true);
                    if($data){
                        $res[] = $data;
                    }
                }
                return $res;
            }
        }
	}

	function makeScan($p){
		if($p){
			if(!is_dir($this->dir)){ mkdir($this->dir); shell_exec('chmod '.$this->chmod.' '.$this->dir); }

			$s = date('Y-m-d_H:i:s');
            $f = $p['format'];
			$fd = 'tiff';
			$format = ' --format '.$fd;
			$device = ' -d '.$p['device'];
			$mode = ' --mode '.$p['mode'];
			$resolution = ' --resolution '.$p['resolution'];
			
			$cmd = 'scanimage '.$device.$format.$mode.$resolution.' >'.$this->getPath($s, $fd);
			shell_exec($cmd);
            if($f != $fd){
                $c = $this->convertScan($s, $f);
                if(!$c){ $f = $fd; }
            }
            $this->chmodScan($s, $f);
			$this->viewScan($s, $f);
		}
	}

}