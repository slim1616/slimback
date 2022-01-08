<template>
    <div class="edit-question">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" name="obligatoire" type="checkbox" :value="true" v-model="question.obligatoire">
                <span class="form-check-sign">Obligatoire *</span>
            </label>
        </div>
        <div class="mb-1 d-flex justify-content-between align-content-center">
            <h2>Stars</h2>
            <div class="selectgroup selectgroup-secondary selectgroup-pills">
                <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="star" class="selectgroup-input">
                    <span class="selectgroup-button selectgroup-button-icon" :class="{'active-radio': question.typeIcon=='star'}"><i class="fa fa-star"></i></span>
                </label>
            </div>
        </div>
        <div>
                <div>
                    <input type="text" v-model="question.textquestion" placeholder="Question" class="form-control"/>
                </div>
                <ul class="list-choix">
                    <li v-for="quest in question.questions" class="choix-text">
                            <i class="fa-2x" :class="quest.icon" :style="{color: quest.color}"></i>
                            <input type="text" v-model="quest.text" placeholder="Choix" class="form-control" style="margin-left: 5px;padding: 7px 4px;"/>
                    </li>
                </ul>
        </div>
    </div>
</template>

<script>
export default {
    props:{
        question : Object
    },
    data(){
        return {

        }
    },
    methods:{
        typechanged(type){
            console.log(type)
            this.question.questions.map((question,i) => {
                if (type=='star'){
                    question.icon = 'fas fa-star'
                    question.mobicon = 'star'
                    question.color = 'yellow'
                }
                if (type=='face'){
                    if (i==0){
                        question.color = 'red'
                        question.icon = 'far fa-frown'
                        question.mobicon = 'frown-o'
                    }
                    if (i==1){
                        question.color = 'orange'
                        question.icon = 'far fa-meh'
                        question.mobicon = 'meh-o'
                    }
                    if (i==2){
                        question.color = 'green'
                        question.icon = 'far fa-smile'
                        question.mobicon = 'smile-o'
                    }
                }
            })
        },
    },
    mounted(){
        console.log(this.question.typeIcon)
    }
}
</script>