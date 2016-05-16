<?php 

if($_SESSION['geral']){
	
    header("Location: " . stalker\library\Fw\Vital::getUrl("Adm"));
    
}

?>

<script>

    $(function(){

        $("#senha2").select();

    });

<?php 

if($this->view->erro){

    echo "alert('Login inválido');";

}

?>

</script>

<img style="position: fixed;left: 50%;margin-left: -943px;"
src='<?php echo BASE; ?>public/images/engen.jpg' />

<div style='background: black;opacity: 0.6;
top:0px;left:0; position: fixed;
width: 100%;height: 100%;z-index: 2000;'></div>

<div style="position: fixed;padding: 10px;
border-radius: 10px;height: 365px;
z-index: 3000;background: white;
top: 50px;left: 50%;margin-left: -185px;">

    <img width='350' style="margin-top: 10px;"
    src='<?php echo BASE; ?>public/images/ker.png' />

</div>

<div style='left: 50%; position: fixed;z-index: 3001;
width: 350px; margin-left: -175px; top: 180px;'>

    <form id="frm_register" data-ajax='false' method="post" 
    action="<?php echo stalker\library\Fw\Vital::getUrl('Login'); ?>">

        <label for="email">E-mail:</label>

        <input type="text" name='email' id='email' /> <br />

        <label for="senha">Senha:</label>
        <input type="password" name='senha' id='senha' /><br />

        <input type = "submit" value="Entrar" />

    </form>
    
</div>