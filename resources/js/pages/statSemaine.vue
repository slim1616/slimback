<template>
    <div class="col-md-6">
        <div class="card full-height">
            <div class="card-body">
                <div class="card-title">Réponses de la semaine</div>
                <div class="row py-3">
                    <div class="col-md-4 d-flex flex-column justify-content-around">
                        <div>
                            <h6 class="fw-bold text-uppercase text-success op-8">Total good</h6>
                            <h3 class="fw-bold">82</h3>
                        </div>
                        <div>
                            <h6 class="fw-bold text-uppercase text-danger op-8">Total bad</h6>
                            <h3 class="fw-bold">8</h3>
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
</template>

<script>
export default {
    data(){
        return {
            stats : [],
            loaded : false
        }
    },
    methods :{
        async getStatsBornes(){
            let res = await fetch(window.location.origin + '/api/bornes/statshomebornesemaine', {
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
                console.log(data)
                if (data.status){
                    this.loaded = true
                    var ctx = document.getElementById('statsemaine').getContext('2d');
                    var myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ["L", "M", "Me", "J", "V", "S", "D"],
                            datasets : [{
                                backgroundColor: '#f49c31',
                                data: [3, 2, 5, 5, 4, 6, 4],
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
                console.log(err)
                this.loader = false
            })
        },
    },
    mounted(){
        this.getStatsBornes();
    }
}
</script>