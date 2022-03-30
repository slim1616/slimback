<template>
    <div class="row mt--2">
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Statistiques de vos bornes</div>
                    <div class="card-category">Cette semaine</div>
                    <div class="d-flex flex-wrap justify-content-around pb-2 pt-4" v-if="loaded">
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-1"></div>
                            <h6 class="fw-bold mt-3 mb-0">Very Good</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-2"></div>
                            <h6 class="fw-bold mt-3 mb-0">Good</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-3"></div>
                            <h6 class="fw-bold mt-3 mb-0">Bad</h6>
                        </div>
                        <div class="px-2 pb-2 pb-md-0 text-center">
                            <div id="circles-4"></div>
                            <h6 class="fw-bold mt-3 mb-0">Very Bad</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card full-height">
                <div class="card-body">
                    <div class="card-title">Réponses de la semaine</div>
                    <div class="row py-3">
                        <div class="col-md-4 d-flex flex-column justify-content-around" v-if="data">
                            <div>
                                <h6 class="fw-bold text-uppercase text-success op-8">Total good</h6>
                                <h3 class="fw-bold">{{data.totals[1] + data.totals[2]}}</h3>
                            </div>
                            <div>
                                <h6 class="fw-bold text-uppercase text-danger op-8">Total bad</h6>
                                <h3 class="fw-bold">{{data.totals[3] + data.totals[4]}}</h3>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="chart-container">
                                <canvas id="statsemaine"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            stats : [],
            loaded : false,
            data : null
        }
    },
    methods :{
        async getStatsBornes(){
            let res = await fetch(window.location.origin + '/api/bornes/statshomebornes', {
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
                this.loader = false
            })
            .then(data => {
                this.loader = false
                ////console.log(data)
                if (data.status){
                    this.data = data
                    this.loaded = true
                    setTimeout(function() {
                        Circles.create({
                            id:           'circles-1',
                            radius:       50,
                            value:        data.resps[1],
                            maxValue:     100,
                            width:        7,
                            text:         function(value){return value},
                            colors:       ['#eee', '#67d532'],
                            duration:     400,
                            wrpClass:     'circles-wrp',
                            textClass:    'circles-text',
                            styleWrapper: true,
                            styleText:    true
                        })
                        Circles.create({
                            id:           'circles-2',
                            radius:       50,
                            value:        data.resps[2],
                            maxValue:     100,
                            width:        7,
                            text:         function(value){return value},
                            colors:       ['#eee', '#a9d89c'],
                            duration:     400,
                            wrpClass:     'circles-wrp',
                            textClass:    'circles-text',
                            styleWrapper: true,
                            styleText:    true
                        })
                        Circles.create({
                            id:           'circles-3',
                            radius:       50,
                            value:        data.resps[3],
                            maxValue:     100,
                            width:        7,
                            text:         function(value){return value},
                            colors:       ['#eee', '#f19088'],
                            duration:     400,
                            wrpClass:     'circles-wrp',
                            textClass:    'circles-text',
                            styleWrapper: true,
                            styleText:    true
                        })
                        Circles.create({
                            id:           'circles-4',
                            radius:       50,
                            value:        data.resps[4],
                            maxValue:     100,
                            width:        7,
                            text:         function(value){return value},
                            colors:       ['#eee', '#ed473b'],
                            duration:     400,
                            wrpClass:     'circles-wrp',
                            textClass:    'circles-text',
                            styleWrapper: true,
                            styleText:    true
                        })
                    },1000)

                    var ctx = document.getElementById('statsemaine').getContext('2d');
                    var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["L", "M", "Me", "J", "V", "S", "D"],
                            datasets : [{
                                backgroundColor: '#f49c31',
                                data: [data.semaine['lundi'], data.semaine['mardi'], data.semaine['mercredi'], data.semaine['jeudi'], data.semaine['vendredi'], data.semaine['samedi'], data.semaine['dimanche']],
                            }],
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            
                            scales: {
                                xAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    },
                                    gridLines: {
                                        drawTicks: false,
                                        display: false
                                    }
                                }],
                                yAxes: [{
                                    display: false,
                                    scaleShowLabels: false,
                                    ticks: {
                                        beginAtZero:true
                                    },
                                    gridLines: {
                                        drawTicks: false,
                                        display: false
                                    }
                                }]
                            },
                        }
                    });
                }

            })
            .catch(err => {
                ////console.log(err)
                this.loader = false
            })
        },
    },
    mounted(){
        this.getStatsBornes();
    }
}
</script>