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
                    <a href="#">Mon profil</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Modifier mon profil</div>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Nom </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="user.nom" placeholder="Nom">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Prénom </label>
                                <input type="text" class="form-control" aria-describedby="" v-model="user.prenom" placeholder="Prénom">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Email </label>
                                <input type="email" class="form-control" aria-describedby="" v-model="user.email" placeholder="email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="">Tel </label>
                                <input type="number" class="form-control" id="" aria-describedby="" v-model="user.phone" placeholder="Tel">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label">Sexe</label>
                                <br/>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="M" class="selectgroup-input" v-model="user.sexe">
                                        <span class="selectgroup-button">Homme</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="value" value="F" class="selectgroup-input" v-model="user.sexe">
                                        <span class="selectgroup-button">Femme</span>
                                    </label>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-groFonctionup">
                                <label for="">Fonction </label>
                                <input type="text" class="form-control" id="" aria-describedby="" v-model="user.fonction" placeholder="fonction">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="">Adresse </label>
                                <input type="text" class="form-control" v-model="user.adress" placeholder="adresse">
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
                        <div class="col-sm-6"></div>
                    
                    </div>
                    <button type="submit" @click.prevent.save="save" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
        </div>
         
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
        var width = 300; // We will scale the photo width to this
        var height = 300; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var photo = null;
        var startbutton = null;
export default {
    data(){
        return {
            avatarBase64 : null,
            disabledbtn : true,
            url : null
        }
    },
    methods:{
        onChangeFileUpload(){
                const image = this.$refs.file.files[0];
                this.url = URL.createObjectURL(image);
                const reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = (e) => {
                    this.avatarBase64 = e.target.result
                };
            },
        saveAvatar(){
                    this.$store.dispatch('setLoader', true)
                    var form = new FormData()
                    form.append('avatar', this.avatarBase64)
                    form.append('user_id', this.user.id)
                    let resp = fetch( window.location.origin + '/api/user/addmyavatar', {
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
                            this.$store.dispatch('setUser', data.user)
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
        save(){
            this.$store.dispatch('setLoader', true)
            let res = fetch(window.location.origin + '/api/user/update',{
                method : 'post',
                body : JSON.stringify(this.user),
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
                    this.$store.dispatch('setUser', data.user)
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
        }
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        })
    }
    
}
</script>

<style scoped>
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
</style>