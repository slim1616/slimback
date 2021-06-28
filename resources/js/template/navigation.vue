<template>
    <!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
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
									<li>
										<router-link :to="{name : 'editProfile'}">
											<span class="link-collapse">Edit Profile</span>
										</router-link>
									</li>
									<template v-if="['superadmin', 'admin'].includes(user.role)">
									<li v-if="user.company_id!=null">
										<router-link :to="{name : 'Companiessingle', params:{id : user.company_id}}">
											<span class="link-collapse">Edit Company</span>
										</router-link>
									</li>
									</template>
									<li>
										<router-link :to="{name : 'myPasswordChange'}">
											<span class="link-collapse">Mot de passe</span>
										</router-link>
									</li>
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
						<template v-if="['superadmin', 'admin'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='zones'}">
								<a data-toggle="collapse" href="#base">
									<i class="fas fa-building"></i>
									<p>Mon Compte</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="base">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name : 'BatimentsList'}">
												<span class="sub-item">Batiemnts</span>
											</router-link>
										</li>
										
									</ul>
								</div>
							</li>
						</template>
						<template v-if="['superadmin', 'admin'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='timezone'}">
								<a data-toggle="collapse" href="#sidebarLayouts">
									<i class="fas far fa-clock"></i>
									<p>Horaires de travail</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="sidebarLayouts">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name : 'TimezonesList'}">
												<span class="sub-item">Time zones</span>
											</router-link>
										</li>
									
									</ul>
								</div>
							</li>
						</template>
						
						<template v-if="['superadmin', 'admin'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='historique'}">
								<a data-toggle="collapse" href="#maps">
									<i class="fas fa-file-alt"></i>
									<p>Reporting</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="maps">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name:'pointage'}">
												<span class="sub-item">Pointage</span>
											</router-link>
										</li>
									</ul>
								</div>
							</li>
						</template>
						<template v-if="['superadmin'].includes(user.role)">
							<li class="nav-item" :class="{active: $route.meta.route=='parametres'}">
								<a data-toggle="collapse" href="#params" :aria-expanded="$route.meta.route=='parametres'">
									<i class="fas fa-user-lock"></i>
									<p>Paramètres de l'app</p>
									<span class="caret"></span>
								</a>
								<div class="collapse" id="params" :class="{show: $route.meta.route=='parametres'}">
									<ul class="nav nav-collapse">
										<li>
											<router-link :to="{name:'Companieslist'}" >
												<i class="fas fa-building"></i>
												<p>Liste Companies</p>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'Formuleslist'}" >
												<i class="fas fa-calendar-alt"></i>
												<p>Plans</p>
											</router-link>
										</li>
										<li>
											<router-link :to="{name:'Abonnementslist'}">
												<i class="fas fa-sitemap"></i>
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
												<span class="sub-item">Liste</span>
											</router-link>
										</li>
										<li>
											<router-link :to="{name : 'addUser'}">
												<span class="sub-item">Ajouter</span>
											</router-link>
										</li>
									</ul>
								</div>
							</li>
						</template>
						<template v-if="user.role=='admin'">
							<li class="nav-item" :class="{active: $route.meta.route=='settings'}">
									<router-link :to="{name:'settings'}">
										<i class="fas fa-cogs"></i>
										<p>Paramètres</p>
									</router-link>
								
							</li>
						</template>
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
        })
    }
}
</script>
