/*  Show/Hidden menu mobile */
function show_menu_mobile(){
	let header_navbar = document.querySelector(".header-navbar");
	let body = document.getElementById('main-body');
	if(header_navbar.classList.contains('active')){
		header_navbar.classList.remove('active');
		body.classList.remove('blocked');
	}else{
		header_navbar.classList.add('active');
		body.classList.add('blocked');
	}
}

/*  Show/Hidden Nav Lateral */
function show_nav_lateral(){
	let NavLateral=document.querySelector('.nav-lateral');
	let PageConten=document.querySelector('.page-content');
	if(NavLateral.classList.contains('active')){
		NavLateral.classList.remove('active');
		PageConten.classList.remove('active');
	}else{
		NavLateral.classList.add('active');
		PageConten.classList.add('active');
	}
}

/*  Btn go back */
function btn_go_back(){
	window.history.back();
}

/*  Show/Hidden Submenus */
const btn_submenu = document.querySelectorAll(".nav-btn-submenu");

btn_submenu.forEach(submenus => {
	submenus.addEventListener("click", show_sub_menu);
});

function show_sub_menu(){
	let SubMenu=this.nextElementSibling;
	let iconBtn=this.children[1];
	if(SubMenu.classList.contains('show-nav-lateral-submenu')){
		this.classList.remove('active');
		SubMenu.classList.remove('show-nav-lateral-submenu');
		iconBtn.classList.remove('fa-rotate-180');
	}else{
		this.classList.add('active');
		SubMenu.classList.add('show-nav-lateral-submenu');
		iconBtn.classList.add('fa-rotate-180');
	}
}