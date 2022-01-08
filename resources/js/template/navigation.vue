<template>
    <!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img :src="logo" class="avatar-img"/>
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
									{{user.prenom}}
									<span class="user-level">{{user.role}}</span>
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									
									<template v-if="['admin','user'].includes(user.role)">
										<li v-if="user.company_id!=null">
											<router-link :to="{name : 'Companiessingle', params:{id : user.company_id}}">
												<span class="link-collapse">{{user.company}}</span>
											</router-link>
										</li>
										<li v-if="user.company_id!=null">
											<template v-if="user.currentAbonnement!=null">
												<router-link :to="{name : 'Abonnementssingle', params:{id : user.currentAbonnement.id}}">
													<template v-if="user.currentFormule">
														<span class="link-collapse">{{user.currentFormule.title}}</span>
													</template>
													<template v-else>
														Abonnement expiré
													</template>
												</router-link>
											</template>
											<template v-else>
													<template v-if="user.currentFormule">
														<router-link to="#">
															<span class="link-collapse">{{user.currentFormule.title}}</span>
														</router-link>
													</template>
													<template v-else>
														<p class="text-black-50">Abonnement expiré</p>
													</template>
											</template>
										</li>
									</template>
									
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
						<li class="nav-item" :class="{active: $route.meta.route=='home'}">
							<router-link :to="{name:'home'}">
								<i class="fas icon-chart"></i>
								<p>Dashboard</p>
							</router-link>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Menu</h4>
						</li>
						<template v-if="['superadmin', 'admin', 'user'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='menu'}">
								<a data-toggle="collapse" href="#base">
									<i class="fas fa-desktop"></i>
									<p>Mes enquêtes</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="base" :class="{show: $route.meta.route=='menu'}">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name : 'Enqueteslist'}">
												<span class="sub-item">Enquetes</span>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'MesEmplacements'}">
												<span class="sub-item">Emplacements</span>
											</router-link>
										</li>
										
									</ul>
								</div>
							</li>
						</template>
						<template v-if="['superadmin', 'admin', 'user'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='bornes'}">
								<a data-toggle="collapse" href="#bornes">
									<i class="fas fa-map-marker-alt"></i>
									<p>Mes Bornes</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="bornes" :class="{show: $route.meta.route=='bornes'}">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name : 'Borneslist'}">
												<span class="sub-item">Bornes</span>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'Compagneslist'}">
												<span class="sub-item">Compagnes</span>
											</router-link>
										</li>
										
									</ul>
								</div>
							</li>
						</template>

						
			
						
						<!-- superadmin -->
						<template v-if="['superadmin'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='parametres'}">
								<a data-toggle="collapse" href="#gestion" :aria-expanded="$route.meta.route=='parametres'">
									<i class="fas fa-tachometer-alt"></i>
									<p>Gestion</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="gestion" :class="{show: $route.meta.route=='parametres'}">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name:'Companieslist'}" >
												<i class="fas fa-user-check"></i>
												<p>Liste Clients</p>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'Formuleslist'}" >
												<i class="fas fa-dollar-sign"></i>
												<p>Formules</p>
											</router-link>
										</li>
										<li>
											<router-link :to="{name:'Abonnementslist'}">
												<i class="fas fa-hand-holding-usd"></i>
												<p>Abonnements</p>
											</router-link>
										</li>
									</ul>
								</div>
							</li>
						</template>
						<template v-if="user.role=='superadmin'">
							<li class="nav-item" :class="{active: $route.meta.route=='user'}">
								<a data-toggle="collapse" href="#charts">
									<i class="fas fa-user-lock"></i>
									<p>Utisateurs</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="charts">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name : 'usersList'}">
												<i class="fas fa-user-friends"></i>
												<p>Liste</p>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'addUser'}">
												<i class="fas fa-user-plus"></i>
												<p>Ajouter</p>
											</router-link>
										</li>
									</ul>
								</div>
							</li>
						</template>
						<template v-if="user.role=='superadmin'">
							<li class="nav-item" :class="{active: $route.meta.route=='settings'}">
									<router-link :to="{name:'settings'}">
										<i class="fas fa-cogs"></i>
										<p>Paramètres</p>
									</router-link>
								
							</li>
						</template>
						<!-- superadmin -->

						<!-- admin -->
						<template v-if="user.role=='admin'">
							<li class="nav-item" :class="{active: $route.meta.route=='user'}">
								<a data-toggle="collapse" href="#users">
									<i class="fas fa-user-lock"></i>
									<p>Utisateurs</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="users" :class="{show: $route.meta.route=='user'}">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name : 'CompanyUsersList'}">
												<span class="sub-item">Liste</span>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'CompanyAddUser'}">
												<span class="sub-item">Ajouter</span>
											</router-link>
										</li>
									</ul>
								</div>
							</li>
						</template>
						<!-- admin -->
						<li class="nav-item" :class="{active: $route.meta.route=='details'}">
							<a data-toggle="collapse" href="#params">
								<i class="fas fa-user-lock"></i>
								<p>App</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="params" :class="{show: $route.meta.route=='details'}">
								<ul class="nav nav-collapse">
									<li>
										<router-link :to="{name : 'formulesView'}">
											<span class="sub-item">Formules</span>
										</router-link>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>
			
		</div>
		<!-- End Sidebar -->
</template>


<script>
import {mapGetters} from 'vuex'

export default {
    computed:{
        ...mapGetters({
            user : 'getUser'
		}),
		logo(){
			return window.location.origin + '/storage/' + this.user.logo
		}
    }
}
</script>
