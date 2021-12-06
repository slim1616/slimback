<template>
    <div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="blue">

				<router-link :to="{name : 'home'}" class="logo">
					<h3>Trust Acces</h3>
				</router-link>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button>
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
                <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				
				<div class="container-fluid">
					<div class="collapse" id="search-nav">
						<form class="navbar-left navbar-form nav-search mr-md-3">
							<div class="input-group">
								<div class="input-group-prepend">
									<button type="submit" class="btn btn-search pr-1">
										<i class="fa fa-search search-icon"></i>
									</button>
								</div>
								<input type="text" placeholder="Recherche ..." class="form-control">
							</div>
						</form>
					</div>
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item toggle-nav-search hidden-caret">
							<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
								<i class="fa fa-search"></i>
							</a>
						</li>
						<!-- <li class="nav-item dropdown hidden-caret">
							<a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-bell"></i>
								<span class="notification">4</span>
							</a>
							<ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
								<li>
									<div class="dropdown-title">Vide</div>
								</li>
								<li>
									<a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
								</li>
							</ul>
						</li> -->
						<li class="nav-item dropdown hidden-caret submenu">
							<a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
								<i class="fas fa-layer-group"></i>
							</a>
							<div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
								<div class="quick-actions-header">
									<span class="title mb-1">Actions rapides</span>
								</div>
								<div class="scroll-wrapper quick-actions-scroll scrollbar-outer" style="position: relative;"><div class="quick-actions-scroll scrollbar-outer scroll-content" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 276px;">
									<div class="quick-actions-items">
										<div class="row m-0">
											<a class="col-6 col-md-4 p-0" href="#">
												<div class="quick-actions-item">
													<i class="flaticon-cloud"></i>
													<span class="text">Import</span>
												</div>
											</a>
											<template v-if="['admin'].includes(user.role)">
												<router-link :to="{name : 'usersList'}" class="col-6 col-md-4 p-0">
													<div class="quick-actions-item">
														<i class="flaticon-user-6"></i>
														<span class="text">Utilisateur</span>
													</div>
												</router-link>
											</template>

										</div>
									</div>
								</div><div class="scroll-element scroll-x"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar ui-draggable ui-draggable-handle" style="width: 100px;"></div></div></div><div class="scroll-element scroll-y"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar ui-draggable ui-draggable-handle" style="height: 100px;"></div></div></div></div>
							</div>
						</li>
						<li class="nav-item dropdown hidden-caret submenu show">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="true">
								<div class="avatar-sm">
									<img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="scroll-wrapper dropdown-user-scroll scrollbar-outer" style="position: relative;"><div class="dropdown-user-scroll scrollbar-outer scroll-content" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 271px;">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img :src="user.avatar" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4>{{user.prenom}} {{user.nom}}</h4>
												<p class="text-muted">{{user.email}}</p>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<router-link :to="{name : 'editProfile'}" class="dropdown-item">
											Mon Profil
										</router-link>
										<div class="dropdown-divider"></div>
										<router-link :to="{name : 'myPasswordChange'}" class="dropdown-item">
											Mot de passe
										</router-link>
										<div class="dropdown-divider"></div>
										<template v-if="user.company_id!=null">
											<router-link :to="{name : 'Companiessingle', params:{id : user.company_id}}" class="dropdown-item">
												<span class="link-collapse">{{user.company}}</span>
											</router-link>
										</template>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="#" @click.prevent.stop="logout()">Déconnexion</a>
									</li>
								</div><div class="scroll-element scroll-x"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar ui-draggable ui-draggable-handle" style="width: 100px;"></div></div></div><div class="scroll-element scroll-y"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar ui-draggable ui-draggable-handle" style="height: 100px;"></div></div></div></div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
			<div class="modal fade" id="plan-choser-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Choisir une formule</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row justify-content-center align-items-center mb-1">
								<div class="col-md-3 pl-md-0">
									<div class="card card-pricing">
										<div class="card-header">
											<h4 class="card-title">Basic</h4>
											<div class="card-price">
												<span class="price">$25</span>
												<span class="text">/mo</span>
											</div>
										</div>
										<div class="card-body">
											<ul class="specification-list">
												<li>
													<span class="name-specification">Customizer</span>
													<span class="status-specification">14 days trial</span>
												</li>
												<li>
													<span class="name-specification">Chat History</span>
													<span class="status-specification">No</span>
												</li>
												<li>
													<span class="name-specification">Statistics</span>
													<span class="status-specification">14 days trial</span>
												</li>
												<li>
													<span class="name-specification">Support</span>
													<span class="status-specification">Yes</span>
												</li>
												<li>
													<span class="name-specification">Live Support</span>
													<span class="status-specification">No</span>
												</li>
											</ul>
										</div>
										<div class="card-footer">
											<button class="btn btn-primary btn-block"><b>Get Started</b></button>
										</div>
									</div>
								</div>
								<div class="col-md-3 pl-md-0 pr-md-0">
									<div class="card card-pricing card-pricing-focus card-primary">
										<div class="card-header">
											<h4 class="card-title">Professional</h4>
											<div class="card-price">
												<span class="price">$35</span>
												<span class="text">/mo</span>
											</div>
										</div>
										<div class="card-body">
											<ul class="specification-list">
												<li>
													<span class="name-specification">Customizer</span>
													<span class="status-specification">Yes</span>
												</li>
												<li>
													<span class="name-specification">Chat History</span>
													<span class="status-specification">3 Month</span>
												</li>
												<li>
													<span class="name-specification">Statistics</span>
													<span class="status-specification">3 Month</span>
												</li>
												<li>
													<span class="name-specification">Support</span>
													<span class="status-specification">Yes</span>
												</li>
												<li>
													<span class="name-specification">Live Support</span>
													<span class="status-specification">Yes</span>
												</li>
											</ul>
										</div>
										<div class="card-footer">
											<button class="btn btn-light btn-block"><b>Get Started</b></button>
										</div>
									</div>
								</div>
								<div class="col-md-3 pr-md-0">
									<div class="card card-pricing">
										<div class="card-header">
											<h4 class="card-title">Team</h4>
											<div class="card-price">
												<span class="price">$75</span>
												<span class="text">/mo</span>
											</div>
										</div>
										<div class="card-body">
											<ul class="specification-list">
												<li>
													<span class="name-specification">Customizer</span>
													<span class="status-specification">Yes</span>
												</li>
												<li>
													<span class="name-specification">Chat History</span>
													<span class="status-specification">1 Year</span>
												</li>
												<li>
													<span class="name-specification">Statistics</span>
													<span class="status-specification">1 Year</span>
												</li>
												<li>
													<span class="name-specification">Support</span>
													<span class="status-specification">Yes</span>
												</li>
												<li>
													<span class="name-specification">Live Support</span>
													<span class="status-specification">Yes</span>
												</li>
											</ul>
										</div>
										<div class="card-footer">
											<button class="btn btn-primary btn-block"><b>Get Started</b></button>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>

</template>


<script>
import {mapGetters} from 'vuex'

export default {
    methods:{
		logout(){
            document.getElementById('logout-form').submit();
            
        },
	},
	computed:{
        ...mapGetters({
            user : 'getUser'
        })
    }
}
</script>

<style scoped>
	.logo-header .logo{
		display: flex;
		align-items: center;
		color: #fff;
	}
</style>
