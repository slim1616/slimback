<template>
    <div class="edit-question">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" name="obligatoire" type="checkbox" :value="true" v-model="question.obligatoire">
                <span class="form-check-sign">Obligatoire *</span>
            </label>
        </div>
        <div class="mb-1 d-flex justify-content-between align-content-center">
            <h2>Choix</h2>
            <div class="selectgroup">
                <label class="selectgroup-item">
                    <input type="radio" name="question" value="radio" v-model="question.typeinput" class="selectgroup-input" >
                    <span class="selectgroup-button selectgroup-button-icon" :class="{'active-radio': question.typeinput=='radio'}"><i class="fas fa-check"></i></span>
                </label>
                <label class="selectgroup-item">
                    <input type="radio" name="question" value="checkbox" v-model="question.typeinput" class="selectgroup-input" >
                    <span class="selectgroup-button selectgroup-button-icon" :class="{'active-radio': question.typeinput=='checkbox'}"><i class="fas fa-check-double"></i></span>
                </label>
            </div>
        </div>
        <div>
                <div>
                    <input type="text" v-model="question.textquestion" placeholder="Question" class="form-control"/>
                </div>
                <ul class="list-choix">
                    <li v-for="quest in question.questions" class="choix-text">
                            <div class="icon-preview"><i class="icon-close red" @click.prevent.stop="removeQuestion(quest)"></i></div>
                            <input type="text" v-model="quest.text" placeholder="Choix" class="form-control" style="margin-left: 5px;padding: 7px 4px;"/>
                    </li>
                    <button class="btn btn-success btn-round btn-xs" @click.prevent.stop="addQuestion"> <i class="fas fa-plus"></i> Question</button>
                </ul>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        question : Object,
    },
    data(){
        return {

        }
    },
    methods:{
        addQuestion(){
            let max = 0;
            let txtvide = false
            this.question.questions.forEach(q => {
                if (q.id>max){
                    max = q.id
                }
                if (q.text.trim()==''){
                    txtvide = true
                }
            })
            if (!txtvide){
                this.question.questions.push({id : max + 1, text : ''})
            }
        },
        removeQuestion(q){
            this.question.questions = this.question.questions.filter(ques => ques.id!=q.id)
        }
    }
}
</script>