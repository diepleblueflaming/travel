<?php
	class pagination{
		
		public $config = array(
			
			'current_page'=>1, // trang hien tai
			'total_page'=>1,	// tong so trang sau khi phan trang,
			'total_record'=>1,	// tong so ban ghi 
			'limit'=>5,		// so ban ghi trong mot trang
			'start'=>0,		// diem bat dau lay ban ghi cua 1 trang
			'range'=>9,		// so button trong 1 trang
			'min'=>0,		// 
			'max'=>0,		
			'link_full'=>"",	// link full cua 1 trang domain/com/{page}
			'link_first'=>''	// link cua trang dau tien
		);
		

        public function __set($property,$val){

            if(isset($this->config[$property])){
                $this->config[$property] = $val;
            }
        }
    		// ham khoi tao ban dau
		function init($config = array())
		{
			// lap mang chuyen vao neu ton tai key thi moi gan gia tri cho thuoc tinh cua doi tuong.
			
			foreach($config as $key=>$val)
			{
				if(isset($this->config[$key]))
					$this->config[$key]=$val;
			}
			
			
			// kiem tra limit truyen vao.Neu nho hon khong thi gan bang 0.
			$this->config['limit']= $config['limit']  > 0 ? $config['limit'] : 0; 
			
			// neu Total_record < 1 thi gan bang 1 
			
			$this->config['total_record']= $config['total_record']  > 1 ? $config['total_record'] : 1;
			
			// tinh toan total_page
			
			$this->config['total_page']=ceil($this->config['total_record'] / $this->config['limit']);
			
			
			// neu user truyen vao so trang < 1 hoac lon tong so trang ta can su ly
			// neu khog web cua ta se bi loi.

			if($this->config['current_page'] < 1)
				$this->config['current_page']=1;
			
			if($this->config['current_page'] > $this->config['total_page'])
				$this->config['current_page']=$this->config['total_page'];
			
			
			// tinh toan start.
			
			$this->config['start']=($this->config['current_page'] -1)* $this->config['limit'];
			
			// tinh toan range cho moi page.
			
			// truoc tien can tinh middle
			$middle=ceil($this->config['range'] / 2);
			// ta se roi vao TH total_page nho hon tong so trang do vay ta
			// can show het trong 1 trang = cach
			// gan min=1; max=total_page

			if($this->config['range'] > $this->config['total_page'])
			{
				$this->config['min'] =1;
				$this->config['max']=$this->config['total_page'];
			}
			
			// neu range nho hon total_page ta 
			// tinh min,max nhu sau:
			else{
				$this->config['min']=$this->config['current_page'] - $middle + 1;
				$this->config['max']=$this->config['current_page'] + $middle - 1;
			}
			
			// sau khi tinh min,max
			// neu min < 1 thi ta gan min=1;  max=range;
			
			if($this->config['min'] < 1)
			{
				$this->config['min']=1;
				$this->config['max']=$this->config['range'];
			}

			// neu max > total_page
			if($this->config['max'] > $this->config['total_page'])
			{
				$this->config['min'] =$this->config['total_page']- $this->config['range'] + 1; 
				$this->config['max']=$this->config['total_page'];
			}
			
		}
			// ham lay link cho trang.
			
			function __link($page)
			{
				// neu trang < 1 thi ta lay trang dau tien.
				if($page <= 1 && $this->config['link_first'])
					return $this->config['link_first'];
				
				// neu khong ta se lay link full
				
				return str_replace("{page}",$page,$this->config['link_full']);
			}
			// ham hien thi pagination cho trang
			function html()
			{
				if($this->config['total_record'] > $this->config['limit'])
				{
					$paging='<ul class="pagination">';
					// theo free{tust} la : $this->config['current_page']
					// khi nao hien thi nut first va prev
					if($this->config['current_page'] > 1)
					{
					
						$paging.= '<li><a href="'.$this->__link(1).'">First</a></li>';
						$paging.= '<li><a href="'.$this->__link($this->config['current_page'] - 1).'">Prev</a></li>';
					}
					// lap khoang giua.
					for($i=$this->config['min'];$i <=$this->config['max']; $i++ )
					{
						if($i==$this->config['current_page'])
							$paging.= '<li class="active"><span>'.$i.'</span></li>';
						else 
							$paging.= '<li><a href= "'.$this->__link($i).'">'.$i.'</a></li>';
					}
					// khi nao hien thi nut Next va Last
					if($this->config['current_page'] < $this->config['total_page'])
					{
						$paging.= '<li><a href="'.$this->__link($this->config['total_page']).'">Next</a></li>';
						$paging.= '<li><a href="'.$this->__link($this->config['current_page'] + 1).'">Last</a></li>';
					}
					$paging.= '</ul>';	
					return $paging;
				}
		}
}
?>
