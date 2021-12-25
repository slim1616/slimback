<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">   
                     <div class="form-group form-floating-label" style="min-width: 200px;">
                        <select class="form-control input-border-bottom" id="selectFloatingLabel" v-model="selectedEmplacement" @change="changeSourceReponse">
                            <option value="*">Tous</option>
                            <option :value="null">Web</option>
                            <option v-for="emplacement in emplacements" :value="emplacement.id">{{emplacement.title}}</option>
                        </select>
                        <label for="selectFloatingLabel" class="placeholder">Emplacements</label>
                    </div>
                    <div class="card-tools">
                        <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                            <li class="nav-item submenu">
                                <a class="nav-link" id="pills-week" :class="{active:selectedTab=='question'}" @click.prevent.stop="selectedTab = 'question'" data-toggle="pill" href="#pills-week" role="tab" :aria-selected="selectedTab=='question'">Questions</a>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" :class="{active:selectedTab=='stats'}" @click.prevent.stop="selectedTab = 'stats'" id="pills-today" data-toggle="pill" href="#pills-today" role="tab" :aria-selected="selectedTab=='stats'">Statistiques</a>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" id="pills-month" :class="{active:selectedTab=='general'}" @click.prevent.stop="selectedTab = 'general'" data-toggle="pill" href="#pills-month" role="tab" :aria-selected="selectedTab=='general'">Général</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <div class="card card-stats card-primary card-round">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="icon-big text-center">
                                            <i class="flaticon-users"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-stats">
                                        <div class="numbers">
                                            <p class="card-category">Reponses</p>
                                            <h4 class="card-title">{{filtredResponses.length}}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!--{{this.responses[this.currentIndex].created_at}}-->
                <template v-if="selectedTab=='question'">
                    <div class="col-sm-12 col-md-12">
                        <ul class="pagination pg-primary">
                            <li class="m-1 page-item" v-for="(response,i) in filtredResponses" @click.prevent.stop="currentIndex = i" :class="{'active':currentIndex == i}">
                                <a href="#" class="page-link">{{i+1}}</a>
                            </li>
                        </ul>
                    </div>
                    <template v-for="question in questions">
                            <div class="question-front">
                                <div>
                                    <h2 class="txt-question">{{question.textquestion}}
                                        <template v-if="question.obligatoire">
                                            <span class="red">*</span>
                                        </template>
                                    </h2>
                                </div>
                                <template v-if="question.question_type=='icons'">
                                    <ul class="align-items-center d-flex justify-content-around">
                                        <li v-for="quest in question.questions">
                                            <div class="align-items-center d-flex flex-column justify-content-center" :class="{'selected-option':isMyResponse(question.id)[0]==quest.id}" >
                                                <i class="fa-2x mb-2" :class="quest.icon" :style="{color: quest.color}"></i>
                                                <p>{{quest.text}}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </template>
                                <template v-if="question.question_type=='choix'">
                                    <ul class="">
                                        <li v-for="quest in question.questions">
                                            <div href="#" class="align-items-center d-flex">
                                                <label :class="[question.typeinput=='checkbox' ? 'form-check-input': 'form-radio-input']" >
                                                    <template v-if="question.typeinput=='radio'">
                                                        <template v-if="isMyResponse(question.id)[0]==quest.id">
                                                            <i class="fas fa-check"></i>
                                                        </template>
                                                    </template>
                                                    <template v-if="question.typeinput=='checkbox'">
                                                        <template v-if="isMyResponse(question.id).includes(quest.id)">
                                                            <i class="fas fa-check"></i>
                                                        </template>
                                                    </template>
                                                    <span :class="[question.typeinput=='checkbox' ? 'form-check-sign': 'form-radio-sign']">{{quest.text}}</span>
                                                </label>
                                            </div>
                                        </li>
                                    </ul>
                                </template>
                            </div>
                    </template>  
                </template>
                <template v-if="selectedTab=='stats'">
                    <survey-stat :responses="filtredResponses" :questions="questions"></survey-stat>
                </template>
                <template v-if="selectedTab=='general'">
                    <template v-if="!loading">
                        <general-stat :dates="dates"></general-stat>
                    </template>
                </template>
            </div>
        </div>
        
    </div>
</template>


<script>
import surveyStat from './surveyStat'
import generalStat from './generalStat'
export default {
    components:{surveyStat, generalStat},
    props:{
        enquete_id : String
    },
    data(){
        return {
            selectedEmplacement : '*',
            selectedTab : 'question',
            responses : [],
            questions : [],
            emplacements : [],
            dates : [],
            currentIndex : 0,
            loading :false
        }
    },
    methods:{
        async changeSourceReponse(){
            this.currentIndex = 0;
            this.$store.dispatch('setLoader',true)
            this.loading = true
                let res = await fetch(window.location.origin + '/api/enquetes/filterreponsesbydates', {
                    method : 'post',
                    body : JSON.stringify({enquete_id:this.enquete_id, selectedEmplacement : this.selectedEmplacement}),
                    headers : {
                        'Content-type' : 'Application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    
                    if (response.status==200) {
                        return response.json();
                    }else if (response.status==401) {
                        //window.location.replace(window.location.href);   
                    }
                    this.$store.dispatch('setLoader',false)
                })
                .then(data => {
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                    this.dates = data.dates
                })
                .catch(err => {
                    console.log(err)
                    this.loading = false
                    this.$store.dispatch('setLoader',false)
                })

        },
        isMyResponse(section_id){
            let resp = []
            this.filtredResponses[this.currentIndex].reponses.forEach(response => {
                if (response.section_id==section_id){
                    resp.push(response.reponse.id)
                }
            })
            if (resp.length==0){
                resp.push(0)
            }
            return resp;
        },
        async getHistorique(){
                this.$store.dispatch('setLoader',true)
                let res = await fetch(window.location.origin + '/api/enquetes/hresponses/' + this.enquete_id, {
                    headers : {
                        'Content-type' : 'Application/json',
                        'X-Requested-With' : 'XMLHttpRequest',
                        'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then((response) => {
                    
                    if (response.status==200) {
                        return response.json();
                    }else if (response.status==401) {
                        //window.location.replace(window.location.href);   
                    }
                    this.$store.dispatch('setLoader',false)
                })
                .then(data => {
                    this.$store.dispatch('setLoader',false)
                    this.questions = data.questions
                    this.responses = data.responses
                    this.emplacements = data.emplacements
                    this.dates = data.dates
                })
                .catch(err => {
                    console.log(err)
                    this.$store.dispatch('setLoader',false)
                })
        }
    },
    computed:{
        filtredResponses(){
            console.log(this.selectedEmplacement)
            if (this.selectedEmplacement!='*'){
                return this.responses.filter(reponse => reponse.emplacement_id==this.selectedEmplacement)
            }else{
                return this.responses
            }
        }
    },
    mounted(){
        this.getHistorique()
    },
}
</script>