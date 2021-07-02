<template>
    <div>
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
    </div>
</template>
<script>
export default {
    data(){
        return {
            questions : [],
            responses : [],
        }
    },
    methods:{
        isMyResponse(section_id){
            let resp = []
            this.responses.forEach(response => {
                console.log( response )
                if (response.section_id==section_id){
                    resp.push(response.reponse.id)
                }
            })
            if (resp.length==0){
                resp.push(0)
            }
            return resp;
        },
        async getMyResponses(unique){
            this.$store.dispatch('setLoader',true)
                let res = await fetch(window.location.origin + '/api/enquetes/myresponses/' + unique, {
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
                    console.log(data.responses)
                        this.questions = data.questions
                        this.responses = data.responses


                })
                .catch(err => {
                    console.log(err)
                    this.$store.dispatch('setLoader',false)
                })
        }
    },
    mounted(){
        this.getMyResponses(this.$route.params.id)
    }
}
</script>