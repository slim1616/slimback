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
                    <a href="#">Employées</a>
                </li>
            </ul>
        </div>

            <div class="card">
                <div class="card-header">
                    <div class="header-btns">
                        <div class="card-title">Liste des Employers</div>
                        <router-link :to="{name:'addEmploye'}" class="btn btn-border btn-secondary btn-round">
                                 <i class="fa fa-user-plus"></i> Ajouter
                        </router-link>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover" cellspacing="0" width="100%" id="employes-datatables">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nom & prénom</th>
                                        <th>Fonction</th>
                                        <th>Matricule</th>
                                        <th>Departement</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                            </table>
                    </div>
                </div>
            </div>

    </div>
</template>
<script>

export default {
    data(){
        return {
            employes : []
        }
    },
    methods:{
     effaceEmploye(employe_id){
         this.$store.dispatch('setLoader', true)
         let res = fetch(window.location.origin + '/api/employe/efface',{
             method : 'post',
             body : JSON.stringify({employe_id: employe_id}),
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
                    this.$notification.success("Effacé avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
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
    getEmployes(context){
        let res = fetch(window.location.origin + '/api/employes',{
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
                    this.employe = data.employe
                    this.$notification.success("Ajouté avec succes", {position: 'bottomRight', timer : 5, showCloseIcn : true, infiniteTimer: false });
                    this.$store.dispatch('setLoader', false)
                    this.$router.push({ name: 'editEmploye', params: { id :  data.employe.id} }) 
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
    mounted(){
        let vm = this
        // this.getEmployes()
        // $('#employes-datatables').dataTable();
        // return
        setTimeout(function() {
            $('#employes-datatables').dataTable( {
                "ajax": {
                    "url": window.location.origin + "/api/employes",
                    'type': 'GET',
                    'beforeSend': function (request) {
                        request.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector('meta[name="csrf-token"]').content);
                    },
                    "dataSrc": function ( json ) {
                        // console.log(json)
                            return json.employes.filter(function(item){
                                //   console.log(item)
                                    return item;         
                                    });
                    }
                },
                "columns" : [ 
                        {"data" : "id"},
                        {"data" : "nom"}, 
                        {"data" : "prenom"}, 
                        {"data" : "email"},
                        {"data" : "departement"},
                        {"data" : "id",  render: function(data, type) { return `<div class="action-btns">
                                                                <a href="javascript:;" class="btn btn-link modifier"><i class="fa fa-edit"></i> </a>
                                                                <Button class="btn btn-link effacer"><i class="la flaticon-interface-5 delete"></i> </button>
                                                                </div>`} },
                ],
                language: {
                    url: window.location.origin + '/js/French.json'
                },
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'colvis',
                        className: "btn-sm btn-dark",
                        text: 'Cacher',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        className: "btn-sm btn-info",
                        text: 'Imprimer',
                        key: {
                            key: 'p',
                            altkey: true
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        className: "btn-sm btn-success",
                        text: 'Excel',
                        title: function(){
                        return "Liste des employées"
                    },
                    exportOptions: {
                            columns: ':visible'
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        className: "btn-sm btn-primary",
                        text: 'PDF',
                        title: function(){
                        return "Liste des employées"
                    },
                    exportOptions: {
                            columns: ':visible'
                        },
                    }
                ],
                "lengthMenu": [[100, 50, 25, -1], [100, 50, 25, "Tous"]],         
                responsive: true
            });
            var table = $('#employes-datatables').DataTable();
            $('#employes-datatables tbody').on( 'click', 'a', function () {
                var data = table.row( $(this).parents('tr') ).data();
                vm.$router.push({ name: 'editEmploye', params: { id :  data['id']} }) 
            });
            $('#employes-datatables tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                swal({
                        title: 'Vous êtes sure?',
                        text: "Vous allez effacer un employé!",
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
                        vm.effaceEmploye(data['id'])
                        } else {
                            swal.close();
                        }
                    });
            });
        })
    }
}
</script>

<style>
    .dataTables_length{
        float: left;
    }
    .dt-buttons{
        margin: 15px 0;
    }
</style>

<style scoped>
    .header-btns{
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .action-btns{
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }
</style>
<style>
    .delete{
        color: #ee5860;
    }
</style>
