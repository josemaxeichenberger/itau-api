<!--Botão whatsapp-->
<style>
	.btn-whatsapp a {

color:#fff; 
text-decoration:none; 
display:block; 
}

.btn-whatsapp {
   
   position:fixed; 
   left: 5%;
   bottom:30px; 
   transform: translate(-50%, -50%);  
   background-color:rgb(37, 211, 102); 
   width:60px; height:60px; 
   text-align:center; 
   line-height:58px; 
   font-size:1.8em; 
   color:#ffffff !important; 
   font-weight:100; 
   border-radius:50%; 
}
 .fa-whatsapp{
	color: #ffffff;
}
.btn-whatsapp:before,
.btn-whatsapp:after

{

content: '';
   display:block;
   position: absolute;
   border-radius:50%;
   border:1px solid #25d366;
   left: -20px;
   right: -20px;
   bottom: -20px;
   top: -20px;
   animation: animate 1.5s linear infinite;
   opacity:0;
   backface-visibility:hidden;    
}

.pulsaDelay:after { animation-delay: .5s; }

@keyframes animate {


  0%   { transform: scale(0.5); opacity:0; }
  50%  { opacity:1; }
  100% { transform: scale(1.2); opacity:0; }

}
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="wpp.php" target="_blank">
    <div class="btn-whatsapp pulsaDelay"><i class="fa fa-whatsapp"></i></div>
</a>
<!--Botão whatsapp-->
<div class="modal fade" id="modal_dados" tabindex="-1" aria-labelledby="modal_dados" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" id="conteudo_dados">

		</div>
	</div>
</div>


<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
	<!--begin::Container-->
	<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
		<!--begin::Copyright-->
		<div class="text-dark order-2 order-md-1">
			<span class="text-gray-700 fw-bold me-1">2021©</span>
			<a href="https://lawsecsa.com.br" target="_blank" class="text-gray-800 text-hover-primary">LAW SMART!</a>
		</div>
		<!--end::Copyright-->
		<!--begin::Menu-->
		<ul class="menu menu-gray-700 menu-hover-primary fw-bold order-1">
			<li class="menu-item">
				<a href="#" target="_blank" class="menu-link px-2">Sobre</a>
			</li>
			<li class="menu-item">
				<a href="#" target="_blank" class="menu-link px-2">Suporte</a>
			</li>
		</ul>
		<!--end::Menu-->
	</div>
	<!--end::Container-->
</div>
<script>
	function Logout() {
		Swal.fire({
			title: "Deseja mesmo sair do sistema?",
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: "Sim",
			denyButtonText: "Não"
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				window.location.href = 'logout.php';	
			} 
		});
	}
</script>