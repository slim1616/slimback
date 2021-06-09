<template>
    <div class="page-inner">
        <div class="page-header">
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
                    <a href="#">utilisateur</a>
                </li>
                
               
               
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{newuser.prenom}} {{newuser.nom}}</div>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                    <li class="nav-item submenu">
                        <a class="nav-link active show" id="pills-home-tab" data-toggle="pill" href="#edit-profile" role="tab" aria-controls="pills-home" aria-selected="false">Modifier</a>
                    </li>
                    <li class="nav-item submenu">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#historique" role="tab" aria-controls="pills-contact" aria-selected="true">Mot de passe</a>
                    </li>
                </ul>
                <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="edit-profile" role="tabpanel" aria-labelledby="pills-home-tab-icon">
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group" :class="{'has-error' : errornom}">
                                        <label for="">Nom </label>
                                        <input type="text" class="form-control" aria-describedby="" v-model="newuser.nom" placeholder="Nom" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group" :class="{'has-error' : errorprenom}">
                                        <label for="">Prénom </label>
                                        <input type="text" class="form-control" aria-describedby="" v-model="newuser.prenom" placeholder="Nom" required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Email </label>
                                        <input type="email" class="form-control" aria-describedby="" v-model="newuser.email" placeholder="email">
                                        <template v-if="errors['email']">
                                                <p class="text-danger">{{errors['email'][0]}}</p>

                                        </template> 
                                    </div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                            <label for="exampleFormControlSelect1">Role</label>
                                            <select class="form-control" v-model="newuser.role_id">
                                                <option v-for="role in roles" :value="role.id">{{role.name}}</option>
                                                
                                            </select>
                                        </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Tel </label>
                                        <input type="number" class="form-control" id="" aria-describedby="" v-model="newuser.phone" placeholder="Tel">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Sexe</label>
                                        <br/>
                                        <div class="selectgroup selectgroup-pills">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="M" class="selectgroup-input" v-model="newuser.sexe">
                                                <span class="selectgroup-button">Homme</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="value" value="F" class="selectgroup-input" v-model="newuser.sexe">
                                                <span class="selectgroup-button">Femme</span>
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="">Adresse </label>
                                        <input type="text" class="form-control" v-model="newuser.adress" placeholder="adresse">
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
                                
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" v-model="newuser.active">
                                            <span class="form-check-sign">Actif</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="">
                                    <div style="position:relative">
                                    <button type="button" class="btn btn-icon btn-round btn-primary btn-add-avatar" 
                                        data-toggle="modal" data-target="#snapshot-modal"
                                        @click="lunchCam">
                                        <i class="icon-camera"></i>
                                    </button>
                                    <div class="avatar avatar-xxl">
                                        <img :src="newuser.avatar" alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    </div>
                                </div>
                                
                            </div>
                            <button type="submit"  @click.prevent.stop="editUser" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="historique" role="tabpanel" aria-labelledby="pills-contact-tab-icon">
                        <changepassword :user="newuser"/>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="snapshot-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ajouter un avatar</h5>
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
import changepassword from './changepassword'
        var width = 300; // We will scale the photo width to this
        var height = 300; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;
export default {
    components : {changepassword},
    data(){
        return {
            roles : [],
            newuser : {
                nom:'',
                prenom:'',
                prenom:'',
                email:'',
                adress:'',
                sexe:'M',
                phone:'',
                role_id : 1,
                // postal_code:'',
                active : true,
            },
            errornom : false,
            errorprenom : false,
            errorpassword : false,
            errorpasswordlength : false,
            errors : {},
            avatarBase64 : null,
            disabledbtn : true
        }
    },
    methods : {
        saveAvatar(){
                    this.$store.dispatch('setLoader', true)
                    var form = new FormData()
                    form.append('avatar', this.avatarBase64)
                    form.append('user_id', this.newuser.id)
                    let resp = fetch( window.location.origin + '/api/user/addavatar', {
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
                            this.newuser = data.user
                            this.disabledbtn = true
                            this.clearphoto();
                            
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
        },
        clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        },
        getUser(user_id){
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/user/'+ user_id,{
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
                this.$store.dispatch('setLoader', false)
                if (data.status){
                    this.newuser = data.user
                    
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
        getRoles(){
           this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/roles',{
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
                if (data.status){
                    this.roles = data.roles
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
        editUser(){
            this.errors = []
            this.errorprenom = false
            this.errornom = false

            if (this.newuser.nom.trim()==""){
                this.errornom = true
            }
            if (this.newuser.prenom.trim()==""){
                this.errorprenom = true
            }
            if (this.errorprenom||this.errornom){
                return false
            }
            this.$store.dispatch('setLoader', true)
            
            let res = fetch(window.location.origin + '/api/user/edit',{
                method : 'post',
                body : JSON.stringify(this.newuser),
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
                if (data.status){
                    this.$notification.success("Modifié avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                    // this.$router.push({ name: 'usersList' }) 
                }else{
                    this.$store.dispatch('setLoader', false)
                    if (data.errors){
                        this.errors = data.errors
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
        }

    },
    mounted(){
        this.getRoles()
        console.log(this.$route.params.id)
        this.getUser(this.$route.params.id)
        
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        birthday(){
            return this.newuser.birthday? moment(this.newuser.birthday).format('YYYY-MM-DD') : null
        }
    }
    
}
</script>
<style scoped>
    .btn-add-avatar{
        position: absolute;
        right: 0;
        z-index: 9999;
    }
    .camera, .start-button, .output{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .start-button{
        margin: 15px auto;
    }
</style>
