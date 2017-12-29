<!-- header -->
<link rel="stylesheet" href="http://www.unsam.edu.ar/css/sidemenu.css">


<link href="http://www.unsam.edu.ar/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<div class="container" style="padding-top:30px;">
    <!-- DESKTOP -->
    <div class="row">
    <div class="col-sm-3 col-xs-12 " style="margin:0px" id="logo-unsam"><a href="http://www.unsam.edu.ar/">
      <img src="http://www.unsam.edu.ar/img/logo-unsam-25-aniversario.png" class="img img_width " alt="unsam 25 años" border=0></a></div>
     <div class="col-sm-9 col-xs-12 ">
       <div id="div_menu2" >
           <div class="menuderecho">
             <h1 class="bold" style="font-size:1.8em; margin:0; text-transform: uppercase;"><?php global $tituloSistema; echo $tituloSistema; ?></h1>
             </p>
           </div>
     </div>
    </div>
  <div style="clear:both"></div>

    <!-- /. DESKTOP -->

  </div>
</div>
<style>
.menuderecho{
  float:right;
  text-align:left;
  margin-top:1px;
}
.img_width{width: none;}
@media only screen and (max-width: 767px){
  .menuderecho{
    float:left;
  }
}

@media only screen and (max-width: 425px){
.img_width{
  width: 100%;
}
}
</style>
