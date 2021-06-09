<template>
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Employées</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="#">
                        <i class="flaticon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Employées</a>
                </li>
               
               
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="align-items-center d-flex justify-content-between">
                    <div class="card-title">{{employe.prenom}} {{employe.nom}}</div>
                    <button class="btn btn-primary" @click.prevent.stop="sendToDevice">Envoyer</button>
                </div>

            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-secondary  nav-pills-no-bd nav-pills-icons" id="pills-tab-with-icon" role="tablist">
                    <li class="nav-item submenu">
                        <a class="nav-link d-flex align-items-center active show" id="pills-home-tab-icon" data-toggle="pill" href="#edit-emp" role="tab" aria-controls="pills-home-icon" aria-selected="false">
                            <i class="flaticon-user-5"></i>
                            <span style="margin-left:5px">Profil</span>
                        </a>
                    </li>
                    <li class="nav-item submenu">
                        <a class="nav-link d-flex align-items-center" id="pills-profile-tab-icon" data-toggle="pill" href="#access-emp" role="tab" aria-controls="pills-profile-icon" aria-selected="true">
                            <i class="flaticon-lock-1"></i>
                            <span style="margin-left:5px">Accès</span>
                        </a>
                    </li>
                    <li class="nav-item submenu">
                        <a class="nav-link d-flex align-items-center" id="pills-contact-tab-icon" data-toggle="pill" href="#historique-emp" role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                            <i class="flaticon-stopwatch"></i>
                           <span style="margin-left:5px">Historique</span>
                        </a>
                    </li>
                    <li class="nav-item submenu">
                        <a class="nav-link d-flex align-items-center" @click="employe.marge_entree = 15" id="pills-contact-tab-icon" data-toggle="pill" href="#emploi-emp" role="tab" aria-controls="pills-contact-icon" aria-selected="false">
                            <i class="la flaticon-calendar"></i>
                           <span style="margin-left:5px">Emploi du temps</span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-with-icon-tabContent">
                    <div class="tab-pane fade active show" id="edit-emp" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Nom </label>
                                        <input type="text" class="form-control" aria-describedby="" v-model="employe.nom" placeholder="Nom" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Prénom </label>
                                        <input type="text" class="form-control" aria-describedby="" v-model="employe.prenom" placeholder="Nom" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Fonction </label>
                                        <input type="text" class="form-control" aria-describedby="" v-model="employe.fonction" placeholder="fonction">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                            <label for="exampleFormControlSelect1">Departement</label>
                                            <select class="form-control" v-model="employe.departement_id">
                                                <option v-for="departement in departements" :value="departement.id">{{departement.title}}</option>
                                                
                                            </select>
                                        </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Email </label>
                                        <input type="email" class="form-control" aria-describedby="" v-model="employe.email" placeholder="email">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Matricule </label>
                                        <input type="text" class="form-control" aria-describedby="" v-model="employe.matricule" placeholder="matricule">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Tel </label>
                                        <input type="number" class="form-control" id="" aria-describedby="" v-model="employe.phone" placeholder="Tel">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Sexe</label>
                                        <br/>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="M" class="selectgroup-input" v-model="employe.sexe">
                                                <span class="selectgroup-button">Homme</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="F" class="selectgroup-input" v-model="employe.sexe">
                                                <span class="selectgroup-button">Femme</span>
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Date de naissance</label>
                                        <datetime v-model="employe.birthday"
                                                    value-zone="Africa/Tunis"
                                                    type="date"
                                                    format="dd/MM/yyyy"

                                                            input-class="form-control">
                                            </datetime>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="">Adresse </label>
                                        <input type="text" class="form-control" v-model="employe.adress" placeholder="adresse">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Code Postal </label>
                                        <input type="number" class="form-control" v-model="employe.postal_code" placeholder="code postal">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Photo</label>
                                        <input type="file" class="form-control-file">
                                    </div>
                                </div> -->
                                <div class="col-sm-8"></div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <label for="">Empreinte 1</label>
                                        <a href="#" class="delete-btn m-1" @click.prevent.stop="employe.fingerPrint1=''"><i class="icon-close"></i></a>
                                        <a href="#" class="paste-btn m-1" @click.prevent.stop="pastef1"><i class="fa fa-paste"></i></a>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" @mouseup="showfp1 = false" @mousedown="showfp1 = true" id="basic-addon1" :class="[employe.fingerPrint1==''? 'bg-red' : 'bg-green']"><i class="fas fa-fingerprint"></i></span>
                                            </div>
                                            <textarea v-show="showfp1" class="form-control" aria-label="With textarea" ref="fp1" v-model="employe.fingerPrint1" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Empreinte 2</label>
                                        <a href="#" class="delete-btn m-1" @click.prevent.stop="employe.fingerPrint2=''"><i class="icon-close"></i></a>
                                        <a href="#" class="paste-btn m-1" @click.prevent.stop="pastef2"><i class="fa fa-paste"></i></a>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" @mouseup="showfp2 = false" @mousedown="showfp2 = true" id="basic-addon1" :class="[employe.fingerPrint2==''? 'bg-red' : 'bg-green']"><i class="fas fa-fingerprint"></i></span>
                                            </div>
                                            <textarea v-show="showfp2" class="form-control" aria-label="With textarea" ref="fp2" v-model="employe.fingerPrint2" ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">CardNo </label>
                                        <input type="number" class="form-control" v-model="employe.cardNo" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" v-model="employe.active">
                                            <span class="form-check-sign">Actif</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Photo </label>
                                        <input accept="image/*" type="file" id="file" ref="file" @change="onChangeFileUpload()"/>
                                    </div>
                                    <div style="position: relative;display: inline-block;">
                                        <img v-if="url" :src="avatarBase64" style="max-width: 80%;height: auto;"/>
                                        <button @click.prevent.stop="saveAvatar" type="button" class="btn btn-icon btn-round" v-if="avatarBase64" style="position: absolute;bottom: 0;right: 0;box-shadow: 0px 0px 1px 1px #000;">
											<i class="icon-cloud-upload"></i>
										</button>
                                    </div>
                                </div>
                                <div class="">
                                    <div style="position:relative">
                                    <button type="button" class="btn btn-icon btn-round btn-primary btn-add-avatar" 
                                        data-toggle="modal" data-target="#snapshot-modal"
                                        @click="lunchCam">
                                        <i class="icon-camera"></i>
                                    </button>
                                    <div class="avatar avatar-xxl">
                                        <img :src="employe.avatar" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" @click.prevent.stop="save" class="btn btn-secondary">Enregistrer</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="access-emp" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                        <div class="row">
                            <template v-if="access.length > 0">
                            <div class="table-responsive">
                                    <table class="table table-bordered table-head-bg-primary">
                                        <thead>
                                            <tr>                           
                                                <th scope="col">Département</th>                                        
                                                <th scope="col">Batiment</th>                                                                                                                                   
                                                <th scope="col">Zone</th>                                                                                                                                   
                                                <th scope="col">Timezone</th>                                                                                                                                   
                                                <th scope="col">Porte</th>                                                                                                                                   
                                                <th scope="col">
                                                    
                                                    <label style="color:#fff !important">
                                                        Effacez
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(access,index) in access"  >
                                                <tr :key="access.id">
                                                        <td>
                                                            {{access.departement.title}} 
                                                        </td>
                                                        <td>
                                                            {{access.batiement.title}} 
                                                        </td>                                                                            
                                                        <td>
                                                            {{access.zone.title}} 
                                                        </td>
                                                        <td>
                                                            {{access.timezone.titre}} 
                                                        </td>
                                                        <td>
                                                            {{access.porte.marque}} {{access.porte.model}} {{access.porte.titre}}
                                                        </td>
                                                        <td>
                                                            <a href="#" class="efface" @click.prevent.stop="effacerAccess(access.employe.id, access.porte.id, access.timezone.id)">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                </div>
                            </template>
                            <template v-else>
                                    <p class="text-warning">Vide!</p>
                            </template>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="historique-emp" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Date début</label>
                                    <datetime v-model="date_deb"
                                                value-zone="Africa/Tunis"
                                                type="datetime"
                                                format="dd/MM/yyyy HH:mm"
                                                input-class="form-control">
                                        </datetime>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="">Date fin</label>
                                    <datetime v-model="date_fin"
                                                value-zone="Africa/Tunis"
                                                type="datetime"
                                                format="dd/MM/yyyy HH:mm"
                                                input-class="form-control">
                                        </datetime>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Nature</label>
                                        <select class="form-control" v-model="nature" >
                                            <option value="">Tous</option>
                                            <option value="access">Accèes</option>
                                            <option value="pointage">Pointage</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="align-items-center align-items-end d-flex justify-content-end">
                                        <button class="btn btn-border btn-round btn-success"  @click.prevent.stop="filter">filter</button>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                    <table class="table table-bordered table-head-bg-primary" name="table" ref="table" id="pdf-make" v-if="historiques.length > 0">
                                        <thead>
                                            <tr>                           
                                                <th scope="col">Batiment</th>                                                                                                                                   
                                                <th scope="col">Zone</th>                                                                                                                                   
                                                <th scope="col">Nature</th>                                                                                                                                   
                                                <th scope="col">Porte</th>                                                                                                                                   
                                                <th scope="col">
                                                    
                                                    <label style="color:#fff !important">
                                                        Date/Heure
                                                    </label>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(historique,index) in historiques"  >
                                                <tr :key="historique.id">

                                                        <td>
                                                            {{historique.batiement}} 
                                                        </td>                                                                            
                                                        <td>
                                                            {{historique.zone}} 
                                                        </td>
                                                        <td>
                                                            {{historique.nature_porte}} 
                                                        </td>
                                                        <td>
                                                            {{historique.porte}}
                                                        </td>
                                                        <td>
                                                            {{historique.datetime}}
                                                        </td>
                                                </tr>
                                            </template>
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-primary btn btn-border btn-rounded" v-if="next_page_url" @click="loadMore(next_page_url)">
                                            <i class="fa fa-plus"></i> Plus
                                        </button>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="emploi-emp" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="usegrid">
                                        <span class="form-check-sign">Vue Tableau</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                            <label>Marge entree</label>
                                          <input class="form-control" type="number" v-model="employe.marge_entree"/>
                                </div>
                            </div>
                            <!-- <div class="col-sm-2">
                                <div class="form-group">
                                            <label>Marge sortie</label>
                                          <input class="form-control" type="number" v-model="employe.marge_sortie"/>
                                </div>
                            </div> -->
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                            <label>Marge entree retard</label>
                                          <input class="form-control" type="number" v-model="employe.marge_entree_retard"/>
                                    </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                        <label>Marge sortie retard</label>
                                        <input class="form-control" type="number" v-model="employe.marge_sortie_retard"/>
                                </div>
                            </div> -->
                            <div class="col-sm-2 p-1">
                                <button class="btn btn-secondary btn-border btn-round" @click.prevent.stop="save">Enregistrer</button>
                            </div>
                        </div>
                        <div v-show="usegrid==false">
                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Lundi</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            
                                            <input class="form-control" type="time" v-model="emploi[1][0][0]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                
                                            <input class="form-control" type="time" v-model="emploi[1][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                
                                            <input class="form-control" type="time" v-model="emploi[1][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            
                                            <input class="form-control" type="time" v-model="emploi[1][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[1]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(1, currentDay)"></i> 
                                </div>
                                
                            </div>

                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Mardi</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            
                                            
                                                <input class="form-control" type="time" v-model="emploi[2][0][0]"/>
                                            
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                
                                                <input class="form-control" type="time" v-model="emploi[2][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                
                                                <input class="form-control" type="time" v-model="emploi[2][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            
                                            <input class="form-control" type="time" v-model="emploi[2][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[2]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(2, currentDay)"></i> 
                                </div>
                            </div>

                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Mercredi</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[3][0][0]"/>    
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[3][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[3][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            <input class="form-control" type="time" v-model="emploi[3][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[3]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(3, currentDay)"></i> 
                                </div>
                            </div>


                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Jeudi</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[4][0][0]"/>    
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[4][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[4][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            <input class="form-control" type="time" v-model="emploi[4][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[4]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(4, currentDay)"></i> 
                                </div>
                            </div>

                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Vendredi</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[5][0][0]"/>    
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[5][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[5][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            <input class="form-control" type="time" v-model="emploi[5][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[5]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(5, currentDay)"></i> 
                                </div>
                            </div>
                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Samedi</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[6][0][0]"/>    
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[6][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[6][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            <input class="form-control" type="time" v-model="emploi[6][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[6]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(6, currentDay)"></i> 
                                </div>
                            </div>

                            <div class="row m-3 bg-grey2" v-if="emploi.length>0">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                    <label>Dimanche</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[0][0][0]"/>    
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[0][0][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                                <input class="form-control" type="time" v-model="emploi[0][1][0]"/>
                                        </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                            <input class="form-control" type="time" v-model="emploi[0][1][1]"/>
                                    </div>
                                </div>
                                <div class="col-sm-2 align-items-center col-sm-2 d-flex justify-content-around">
                                    <i class="fa fa-copy copy" @click="currentDay = emploi[0]"></i>
                                    <i class="fa fa-paste paste" @click="changeDay(0, currentDay)"></i> 
                                </div>
                            </div>
                        </div>
                        <div v-show="usegrid==true">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3 class="text-primary">Emploi</h3>
                                </div>
                            </div>
                            <div class="">
                                <div id="weekly-schedule"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="snapshot-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modifier avatar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="camera">
                            <video id="video">Video stream not available.</video>
                        </div>
                        <div class="start-button">
                            <button id="startbutton" type="button" class="btn btn-icon btn-round btn-secondary">
                                <i class="icon-camera"></i>
                            </button>
                        </div>
                        <canvas id="canvas" style="display:none"></canvas>
                        <div class="output">
                            <img id="photo" alt="The screen capture will appear in this box.">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" :disabled="disabledbtn" :class="{disabled :disabledbtn}" @click="saveAvatar">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import * as moment from 'moment';
import { Datetime } from 'vue-datetime';
import 'vue-datetime/dist/vue-datetime.css'
window.moment = moment

        var width = 300; // We will scale the photo width to this
        var height = 300; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;
export default {
    components : {Datetime},
    data(){
        return {
            nature : '',
            date_deb : moment().startOf('month').toISOString(),
            date_fin : moment().endOf('month').toISOString(),
            employe : {},
            departements : [],
            avatarBase64 : null,
            disabledbtn : true,
            access : [],
            image : null,
            url : null,
            historiques : [],
            next_page_url : null,
            showfp2 : false,
            showfp1 : false,
            emploi : [],
            usegrid : false,
            currentDay : []

        }
    },
    methods : {
        changeDay(index, currentDay){
            let newTab = this.emploi.map((emp, i) => {
                console.log(i)
                if (i==index){
                    
                    return currentDay
                }else{
                    return emp
                }
            })
            this.emploi = newTab
        },
        async pastef2(){
            // console.log(this.$refs.fp2)
            this.$refs.fp2.focus();
            const text = await navigator.clipboard.readText();
            this.employe.fingerPrint2 = ""
            this.employe.fingerPrint2 = text
            // console.log(text);
            // document.execCommand('paste');
        },
        async pastef1(){
            this.$refs.fp1.focus();
            const text = await navigator.clipboard.readText();
            this.employe.fingerPrint1 = ""
            this.employe.fingerPrint1 = text
        },
        async loadMore(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( this.next_page_url,{
                method : 'post',
                body : JSON.stringify({nature : this.nature,
                                       date_deb : moment(this.date_deb).format('YYYY-MM-DD HH:mm:ss'),
                                       date_fin : moment(this.date_fin).format('YYYY-MM-DD HH:mm:ss')}),
                    headers : {
                        'Content-type' : 'Application/json',
                        // 'Accept':'application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
            })
            .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }else{
                        this.$store.dispatch('setLoader', false)
                        swal("Erreur", "Une erreur c'est produite", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
            })
            .then(function(response){
                that.$store.dispatch('setLoader', false)
                that.historiques = [...that.historiques,...response.historiques]
                that.next_page_url = response.next_page_url
            })
            .catch((error) => {
                console.log(error)
                that.$store.dispatch('setLoader', false)
                swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                });
        },
        async filter(){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/filterhistoriquebyemp/' + this.employe.id ,{
                method : 'post',
                body : JSON.stringify({nature : this.nature,
                                       date_deb : moment(this.date_deb).format('YYYY-MM-DD HH:mm:ss'),
                                       date_fin : moment(this.date_fin).format('YYYY-MM-DD HH:mm:ss')}),
                    headers : {
                        'Content-type' : 'Application/json',
                        // 'Accept':'application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
            })
            .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }else{
                        this.$store.dispatch('setLoader', false)
                        swal("Erreur", "Une erreur c'est produite", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
            })
            .then(function(response){
                that.$store.dispatch('setLoader', false)
                that.historiques = response.historiques
                that.next_page_url = response.next_page_url
            })
            .catch((error) => {
                console.log(error)
                that.$store.dispatch('setLoader', false)
                swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                });

        },
            onChangeFileUpload(){
                const image = this.$refs.file.files[0];
                this.url = URL.createObjectURL(image);
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = (e) => {
                    this.avatarBase64 = e.target.result
                };
            },
            sendToDevice(){
                let that = this
                this.$store.dispatch('setLoader', true)
                    let res = fetch(window.location.origin + '/api/sendusertoportes/'+ this.employe.id,{
                        headers : {
                            'Content-type' : 'Application/json',
                            // 'Accept':'application/json',
                            'X-Requested-With' : 'XMLHttpRequest',
                            'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then((response) => {
                        if (response.ok) {
                        return response.json();
                        }else{
                            this.$store.dispatch('setLoader', false)
                            swal("Erreur", "Une erreur c'est produite", {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            });
                        }
                    })
                    .then(data => {
                        console.log(data)
                        if (data.status){
                            that.$notification.success("Envoyé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                            this.$store.dispatch('setLoader', false)
                            
                        }else{
                            this.$store.dispatch('setLoader', false)
                            swal("Erreur", data.msg, {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.$store.dispatch('setLoader', false)
                        swal("Erreur", "Une erreur c'est produite", {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            });
                    })
            },
        async effaceAcces(employe_id, porte_id, timezone_id){
            let that = this
            this.$store.dispatch('setLoader', true)
            let res = await fetch( window.location.origin +  '/api/employeseffaceaccess',{
                method : 'post',
                body : JSON.stringify({
                                       timezone_id : timezone_id, 
                                       porte_id : porte_id, 
                                       employe_id : employe_id,
                                       }),
                    headers : {
                        'Content-type' : 'Application/json',
                        // 'Accept':'application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
            })
            .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }else{
                        this.$store.dispatch('setLoader', false)
                        swal("Erreur", "Une erreur c'est produite", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }
            })
            .then(function(response){
                that.$store.dispatch('setLoader', false)
                // that.$notification.success("Effacé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                that.getAccess()
            })
            .catch((error) => {
                console.log(error)
                that.$store.dispatch('setLoader', false)
                swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                });
        },
        effacerAccess(employe_id, porte_id, timezone_id){
            var that = this;
            swal({
                    title: 'Vous êtes sure?',
                    text: "Vous allez effacer l'accès!",
                    type: 'warning',
                    buttons:{
                        
                        cancel: {
                            text : 'Annuler',
                            visible: true,
                            className: 'btn btn-danger'
                        },
                        confirm: {
                            text : 'Oui',
                            className : 'btn btn-success'
                        }
                    }
                }).then((Delete) => {
                    if (Delete) {
                        this.effaceAcces(employe_id, porte_id, timezone_id)
                    } else {
                        swal.close();
                    }
                });
        },
        getAccess(){
            this.$store.dispatch('setLoader', true)
            let resp = fetch( window.location.origin + '/api/access/employe/' + this.$route.params.id, {
                headers : {
                    'X-Requested-With' : 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                }else{
                    this.$store.dispatch('setLoader', false)
                    swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            })
            .then(data => {
                this.$store.dispatch('setLoader', false)
                if (data.status){
                    // this.$store.dispatch('setUser', data.user)
                    this.access = data.access
                }else{
                    
                    swal("Erreur", data.msg, {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            })
            .catch(error => {
                console.log(error)
                this.$store.dispatch('setLoader', false)
                swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
            })
        },
        saveAvatar(){
                    this.$store.dispatch('setLoader', true)
                    var form = new FormData()
                    form.append('avatar', this.avatarBase64)
                    form.append('employe_id', this.employe.id)
                    let resp = fetch( window.location.origin + '/api/employe/addemployeavatar', {
                        method : 'post',
                        body : form,
                        headers : {
                            'X-Requested-With' : 'XMLHttpRequest',
                            'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then((response) => {
                        if (response.ok) {
                         return response.json();
                        }else{
                            this.$store.dispatch('setLoader', false)
                            swal("Erreur", "Une erreur c'est produite", {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            });
                        }
                    })
                    .then(data => {
                        this.$store.dispatch('setLoader', false)
                        if (data.status){
                            // this.$store.dispatch('setUser', data.user)
                            this.employe = data.employe
                            this.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                            this.disabledbtn = true
                            this.clearphoto();
                            this.avatarBase64 = null
                            
                        }else{
                            
                            swal("Erreur", data.msg, {
                                icon : "error",
                                buttons: {
                                    confirm: {
                                        className : 'btn btn-danger'
                                    }
                                },
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.$store.dispatch('setLoader', false)
                        // swal("Erreur", "Une erreur c'est produite", {
                        //         icon : "error",
                        //         buttons: {
                        //             confirm: {
                        //                 className : 'btn btn-danger'
                        //             }
                        //         },
                        //     });
                    })
        },
        lunchCam(){
            let vm = this
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            photo = document.getElementById('photo');
            startbutton = document.getElementById('startbutton');

            // access video stream from webcam
            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                // on success, stream it in video tag
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function(ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            startbutton.addEventListener('click', function(ev) {
                vm.takepicture();
                ev.preventDefault();
            }, false);

            vm.clearphoto();
        },
        takepicture() {
            this.disabledbtn = false
            if (canvas){
                console.log('canvas')
                console.log(canvas)
                var context = canvas.getContext('2d');
                if (width && height) {
                    canvas.width = width;
                    canvas.height = height;
                    context.drawImage(video, 0, 0, width, height);

                    var data = canvas.toDataURL('image/png');
                    this.avatarBase64 = data
                    photo.setAttribute('src', data);
                } else {
                    this.clearphoto();
                }
            }
        },
        clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        },
        getEmploye(employe_id){
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/employe/' + employe_id,{
                headers : {
                    'Content-type' : 'Application/json',
                    // 'Accept':'application/json',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.ok) {
                return response.json();
                }else{
                    this.$store.dispatch('setLoader', false)
                     swal("Erreur de requete", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                    // throw response;
                }
            })
            .then(data => {
                if (data.status){
                    this.employe = data.employe
                    if (data.employe.emploi){
                        let tab = JSON.parse(data.employe.emploi)
                        // console.log(tab)
                        const obj = {...tab};
                        // this.emploi = [...tab]
                        // console.log([...tab])
                        this.emploi = [...tab].map(jour => {
                            if (jour[0]){
                                // console.log(jour)
                                if (jour[1]){
                                    return jour;
                                }else{
                                    return [...jour , ['00:00', '00:00']]
                                }
                            }else{
                                return [['00:00', '00:00'], ['00:00', '00:00']]
                            }
                        })
                        // console.log(this.emploi)
                        
                        try{
                            
                            setTimeout(() => {
                                if (obj){
                                    $("#weekly-schedule").data('artsy.dayScheduleSelector').deserialize(obj);
                                }

                            },1000)
                        }catch(error){
                            console.log(error)
                        }
                    
                    }
                    this.departements = data.departements
                    this.$store.dispatch('setLoader', false)
                }else{
                    this.$store.dispatch('setLoader', false)
                    console.log('getEmploye')
                    swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            })
            .catch(error => {
                this.$store.dispatch('setLoader', false)
                console.log(error)
                swal("Erreur", "Une erreur c'est produite", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            })
        },
        save(){
            let employe = this.employe
            console.log(this.birthday)
            if (this.usegrid){
                employe.emploi = $("#weekly-schedule").data('artsy.dayScheduleSelector').serialize({ });
                console.log(employe.emploi)
            }else{
                employe.emploi = {...this.emploi}
                console.log(this.emploi)
                 let tab = this.emploi.map(jour => {
                     console.log(jour)
                            if (jour[0][0]=='00:00'&&jour[1][0]=='00:00'){
                                return [];
                            }else if (jour[0][0]!='00:00'&&jour[1][0]!='00:00'){
                                return [...jour];
                            }else if (jour[0][0]!='00:00'&&jour[1][0]=='00:00'){
                                return [[...jour[0]]]
                            }else if (jour[1][0]!='00:00'&&jour[0][0]=='00:00'){
                                return [[...jour[1]]]
                            }
                   
                    })
                console.log(tab)
                employe.emploi = tab
            }
            if (this.birthday){
                employe.birthday = this.birthday
            }
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/employe/update',{
                method : 'post',
                body : JSON.stringify(this.employe),
                headers : {
                    'Content-type' : 'Application/json',
                    // 'Accept':'application/json',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then((response) => {
                if (response.ok) {
                return response.json();
                }else{
                    this.$store.dispatch('setLoader', false)
                     swal("Erreur de requete", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                    // throw response;
                }
            })
            .then(data => {
                if (data.status){
                    this.employe = data.employe
                    this.$notification.success("Modifié avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                }else{
                    this.$store.dispatch('setLoader', false)
                     swal("Erreur", "Une erreur c'est produite", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }
            })
            .catch(error => {
                this.$store.dispatch('setLoader', false)
                swal("Erreur", "Une erreur c'est produite", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            })
        },
        drawTab(){
         $("#weekly-schedule").dayScheduleSelector({
                days        : [1, 2, 3, 4, 5, 6, 0],  
                startTime   : '07:00',         
                endTime     : '20:00',     
                interval    : 30,    
                stringDays  : ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],

                // Custom template                 
                template    : '<div class="day-schedule-selector">'         +
                                '<table class="schedule-table">'            +
                                '<thead class="schedule-header"></thead>' +
                                '<tbody class="schedule-rows"></tbody>'   +
                                '</table>'                                  +
                            '<div>'

            });
    }

    },
    mounted(){
        // console.log(this.$route.params.id)
        this.getEmploye(this.$route.params.id)
        
        this.getAccess(this.$route.params.id)
        var vm = this
            setTimeout(function() {
                vm.drawTab()
            },1000)
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        birthday(){
            return moment(this.employe.birthday).isValid() ? moment(this.employe.birthday).format('YYYY-MM-DD') : '';
        }
    }
    
}
</script>

<style scoped>
.efface{
    color: #f25961;
}
    .btn-add-avatar{
        position: absolute;
        right: 0;
        z-index: 999;
    }
    .camera, .start-button, .output{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .start-button{
        margin: 15px auto;
    }
    .delete-btn, .delete-btn:hover{
        color: red;
        text-decoration: none;
    }
    .paste-btn, .paste-btn:hover{
        color: blue;
        text-decoration: none;
    }
    .bg-green{
        background: #31ce36;
        color: #fff;
    }
    .bg-red{
        background: #f25961;
        color: #fff;
    }
    .copy{
        color: #317fe0;
    }
    .paste{
        color: #57a51e;
    }
</style>
<style>
    .schedule-table{
        width : 100% !important;
    }
 .schedule-rows td {
        width: 80px;
        height: 2px !important;
        margin: 3px;
        padding: 2px !important;
        background-color: #0b438e;
        cursor: pointer;
        border: solid 1px #fff;
    }
</style>
