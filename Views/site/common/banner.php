<style>
    #banner{
        background-color: #0285bd;
    }
    #logo a{
        overflow: hidden;
        height: auto;
    }
    #txtFind{
        width: 100%;
        padding: 6px 0 6px 3px;
        font-size: 17px;
        border: 1px solid #E9EDEE;
    }
    #form_search_site{
        margin-right: 10px;
        margin-top: 25px;
    }

    @media only screen and (max-width: 425px) {
        #form_search_site{
            margin-top: 15px;
            margin-right: 0;
            margin-bottom: -5px;
        }
    }

    #menu_mobile_button i{
        font-size: 43px;
        color: white;
        margin-top: -3px;
    }

    @media only screen and (min-width: 426px ) and (max-width: 768px){
        #form_search_site{
            margin-top: 15px;
        }
    }
</style>
<div class="row" id="banner">
    <div class="col-xs-12 col-sm-4 col-md-3 pull-right" id="form_search_site">
        <div class="row">
            <div class="col-xs-2 icon" id="menu_mobile_button">
                <i class="glyphicon glyphicon-menu-hamburger"></i>
            </div>
            <form action="<?=base_url("timkiem/");?>" method="post" class="col-xs-10 col-sm-12">
                <input type="text" id="txtFind" placeholder="Tìm kiếm..." name="tag">
            </form>
        </div>
    </div>
   <div  class="col-xs-12 col-sm-4 col-md-3 pull-left" id="logo">
       <a href="<?php echo base_url("")?>">
           <img id="banner" src="<?php echo base_url("public/icon/logo.png")?>" width="100%">
       </a>
   </div>
</div>
