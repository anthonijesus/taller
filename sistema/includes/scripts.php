
    <!--Import Bootstrap-->
    
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/bootstrap-icons.svg">
    <link rel="stylesheet" type="text/css" href="fontawesome/css/all.css">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluye el plugin jQuery Parallax -->
    <script src="https://cdn.jsdelivr.net/parallax.js/1.4.2/parallax.min.js"></script>
    <script>
        $(document).ready(function(){
        $('.parallax-container').parallax();
        });

        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })
    </script>

<style>

body {
  display: auto;
  min-height: 100vh;
  flex-direction: column;
  margin-bottom: 100px;
  background: #FFFF;
  background-repeat: no-repeat;
  background-size: cover;
}
section {
  display: contents;
}
main {
  flex: 1 0 auto;
  margin-bottom: 100px;
}

.dropdown-content {
  background-color: #fff;
  left: 16px;
  top: -60px;
}

.dropdown-content li>a,
.dropdown-content li>span {
  font-size: 15px;
  color: #000;
}
.border {
  border-radius: 15px;
  background-color: #fff3e0;
}
.page-footer {
 padding-top: 20px;
color: #fff;
background-color: #333;
}
table.striped tr {
  border-bottom: none;
}

table.striped > tbody > tr:nth-child(odd) {
  background-color: #3333;
}

table.striped > tbody > tr > td {
  border-radius: 0;
}
table.striped > tbody > tr > td {
padding: 0.1rem;
}
/************** PAGINADOR *****************************/
.paginador ul{
padding: 15px;
list-style: none;
margin-top: 15px;
display: -webkit-flex;
display: -moz-flex;
display: -ms-flex;
display: -o-flex;
display: flex;
justify-content: center;
}

.paginador a, .pageSelected{
color: #428bca;
border: 1px solid #ddd;
padding: 5px;
display: inline-block;
font-size: 14px;
text-align: center;
width: 35px;
border-radius: 10px;
}

.paginador a:hover{
background: #ddd;
}

.pageSelected{
color: #FFF;
background: #428bca;
border: 1px solid #428bca;
}

.cliente-header {
display: flex;
align-items: center;

}

.cliente-header h5 {
margin-right: 30px;
}
.usuario-header {
display: flex;
align-items: center;
}

.usuario-header h5 {
margin-right: 50px;
}
td, th {
padding: 5px 10px;
display: table-cell;
text-align: center;
vertical-align: middle;
border-radius: 2px;
font-size: 14px;
}

/****CLASE PARA BOTONES DE EDICIÓN*****/
.icon_facturar {
width: auto;
height: auto;
border-radius: 50%;
color: #126e00;
cursor: pointer;
}
.icon_editar {
width: auto;
height: auto;
border-radius: 50%;
color: #4f72d4;
cursor: pointer;
}
.icon_delete {
width: auto;
height: auto;
border-radius: 50%;
color: #e65656;
cursor: pointer;
display: inline-block;
}
.icon_cli_add_repa {
width: auto;
height: auto;
border-radius: 50%;
color: #126e00;
cursor: pointer;
display: inline-block;
}
.acciones a {
  display: inline-block;
}
.factura {
border-radius: 30px;
margin: auto;
padding: 20px;
border: 10px solid #d1d1d1;
width: 60%;
}
.container {
width: 85%;
}
.titulos{
border-radius: 5px;
background-color:  #e65;
width: 200px;
height: 40px;
line-height: 40px; /* Asegurando que el contenido se centre verticalmente */
text-align: center;
display: inline-block;
align-items: center;
}
.titulos_rep{
background-color:  #e65656;
border-radius: 10px;
width: auto;
text-align: center;
}
.titulos_prov{
background-color:  #90caf9;
border-radius: 10px;
width: 25%;
text-align: center;
}
tfoot {
color: #126e00;
font-weight: bold;
}
tfoot tr td {
  padding: 10px;
  font-size: 16px;
}
/************** REGISTRO DE USUARIO *****************************/

.form_register{
width: 350px;
margin: auto;
}

.form_register h5{
color: #3c93b0;
text-align: center;
}

hr{
border: 0;
background: #CCC;
height: 1px;
margin: 10px 0;
}

form{
background: #FFFF;
margin: auto;
padding: 10px 20px;
border: 10px;
border-radius: 10px;
}

label{
display: block;
font-size: 12pt;
font-family: 'GothamBook';
margin: auto;
}

input{
display: block;
width: 100%;
font-size: 15pt;
padding: 5px;
border: 1px solid #85929e;
border-radius: 5px;
}

.btn_save{
font-size: 12pt;
background: #26a0a6;
padding: 10px;
color: #FFF;
letter-spacing: 1px;
border: 0;
cursor: pointer;
margin: 15px auto;
}

.alert{
width: 100%;
background: #c6e07d66;
border-radius: 6px;
margin: 10px auto;
}

.msg_error{
color: #e65656;
}

.msg_save{
color: #126e00;
}

.alert p{
padding: 10px;
}
/********** Estilos de Eliminar Usuarios ******/
.data_delete{
text-align: center;
}

.data_delete h2{
font-size: 12pt;
}

.data_delete span{
font-weight: bold;
color: #4f72d4;
font-size: 12pt;
}

.btn_cancel,.btn_ok{
width: 124px;
background: #478ba2;
color: #FFF;
display: inline-block;
padding: 5px;
border-radius: 5px;
cursor: pointer;
margin: 15px
}
.btn_cancel{
background: #D82611;
display: inline-block;
}
.data_delete form{
background: initial;
margin: auto;
padding: 5px 5px;
border: 0;	
}
.edit_cli{
  background-color: #85929e;
}
.modal_form{
  background-color: #CCC;
  width: 70%;
  margin-top: 20px;
  margin-bottom: 25px;
}
.modal-title{
  background-color: #d1d1d1;
  border-radius: 5px;
  margin-top: 15px;
}
/****************************/

</style>

<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="js/materialize.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      M.AutoInit();
      var elems = document.querySelectorAll('.tooltipped');
      var instances = M.Tooltip.init(elems, options);
      var elems = document.querySelectorAll('.modal');
      var instances = M.Modal.init(elems, options);
      var elems = document.querySelectorAll('.parallax');
      var instances = M.Parallax.init(elems, options);
      
   
    });

    function abrirModal(ID_Cliente) {
  // Obtener el modal
    var modal = document.getElementById("staticBackdrop-r");

  // Actualizar el valor del campo oculto con el ID del cliente
    modal.querySelector("#ID_Cliente").value = ID_Cliente;

  // Abrir el modal
    var instanciaModal = M.Modal.init(modal);
    instanciaModal.open();
}

  </script>
