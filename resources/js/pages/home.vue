<template>
    <div>
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Tableau de bord</h2>
                        
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <h5 class="text-white op-7 mb-2" style="text-transform: capitalize;font-size: 1.1em;">{{currentDateTime}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row mt--2">
                <div class="col-md-6">
                    <div class="card full-height">
                        <div class="card-body">
                            <div class="card-title">Statistiques de présence</div>
                            <div class="card-category">Derniers 7 jours</div>
                            <div class="d-flex flex-wrap justify-content-around pb-2 pt-4">
                                <div class="px-2 pb-2 pb-md-0 text-center">
                                    <div id="circles-1"></div>
                                    <h6 class="fw-bold mt-3 mb-0">Retards</h6>
                                </div>
                                <div class="px-2 pb-2 pb-md-0 text-center">
                                    <div id="circles-2"></div>
                                    <h6 class="fw-bold mt-3 mb-0">Absents</h6>
                                </div>
                                <div class="px-2 pb-2 pb-md-0 text-center">
                                    <div id="circles-3"></div>
                                    <h6 class="fw-bold mt-3 mb-0">Présents</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card full-height">
                        <div class="card-body">
                            <div class="card-title">Retards de la semaine</div>
                            <div class="row py-3">
                                <div class="col-md-4 d-flex flex-column justify-content-around">
                                    <div>
                                        <h6 class="fw-bold text-uppercase text-success op-8">Total retards</h6>
                                        <h3 class="fw-bold">82</h3>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-uppercase text-danger op-8">Total absences</h6>
                                        <h3 class="fw-bold">8</h3>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div id="chart-container">
                                        <canvas id="absencessemaines"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                        <p class="card-category">Visitors</p>
                                        <h4 class="card-title">1,294</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-info card-round">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-interface-6"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Subscribers</p>
                                        <h4 class="card-title">1303</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-success card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-analytics"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Sales</p>
                                        <h4 class="card-title">$ 1,345</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-secondary card-round">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5">
                                    <div class="icon-big text-center">
                                        <i class="flaticon-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-stats">
                                    <div class="numbers">
                                        <p class="card-category">Order</p>
                                        <h4 class="card-title">576</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">User Statistics</div>
                                <div class="card-tools">
                                    <a href="#" class="btn btn-info btn-border btn-round btn-sm mr-2">
                                        <span class="btn-label">
                                            <i class="fa fa-pencil"></i>
                                        </span>
                                        Export
                                    </a>
                                    <a href="#" class="btn btn-info btn-border btn-round btn-sm">
                                        <span class="btn-label">
                                            <i class="fa fa-print"></i>
                                        </span>
                                        Print
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 375px">
                                <canvas id="abcencesretards"></canvas>
                            </div>
                            <div id="myChartLegend"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary bg-primary-gradient">
                        <div class="card-body">
                            <h4 class="mt-3 b-b1 pb-2 mb-4 fw-bold">Employé en postes</h4>
                            <h1 class="mb-4 fw-bold">17</h1>
                            <h4 class="mt-5 pb-3 mb-0 fw-bold">Départements</h4>
                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between pb-1 pt-1"><small>Production</small> <span>7</span></li>
                                <li class="d-flex justify-content-between pb-1 pt-1"><small>Administration</small> <span>10</span></li>
                                <li class="d-flex justify-content-between pb-1 pt-1"><small>Technique</small> <span>10</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body ">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="flaticon-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Acces</p>
                                        <h4 class="card-title">1294</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="flaticon-interface-6"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Accés</p>
                                        <h4 class="card-title">1303</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="flaticon-graph"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Presences</p>
                                        <h4 class="card-title">1345</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="flaticon-success"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ml-3 ml-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Portes</p>
                                        <h4 class="card-title">6</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <div class="card-title">Résumé des Accés</div>
                                <div class="card-tools">
                                    <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="pill" href="#absenses" role="tab" aria-selected="true">Absents</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#retards" role="tab" aria-selected="false">Retards</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="pill" href="#presents" role="tab" aria-selected="false">Présents</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content mt-2 mb-3" id="pills-tabContent">
                                <div class="tab-pane fade active show" id="absenses" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="card-list">
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Jimmy Denis</div>
                                                    <div class="status">Graphic Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-danger btn-round btn-xs">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Chad</div>
                                                    <div class="status">CEO Zeleaf</div>
                                                </div>
                                                <button class="btn btn-icon btn-danger btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Talha</div>
                                                    <div class="status">Front End Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-danger btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">John Doe</div>
                                                    <div class="status">Back End Developer</div>
                                                </div>
                                                <button class="btn btn-icon btn-danger btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Talha</div>
                                                    <div class="status">Front End Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-danger btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Jimmy Denis</div>
                                                    <div class="status">Graphic Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-danger btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                                <div class="tab-pane fade" id="retards" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="card-list">
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Jimmy Denis</div>
                                                    <div class="status">Graphic Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-warning btn-round btn-xs">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Chad</div>
                                                    <div class="status">CEO Zeleaf</div>
                                                </div>
                                                <button class="btn btn-icon btn-warning btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Talha</div>
                                                    <div class="status">Front End Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-warning btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">John Doe</div>
                                                    <div class="status">Back End Developer</div>
                                                </div>
                                                <button class="btn btn-icon btn-warning btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Talha</div>
                                                    <div class="status">Front End Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-warning btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Jimmy Denis</div>
                                                    <div class="status">Graphic Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-warning btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                                <div class="tab-pane fade" id="presents" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="card-list">
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Jimmy Denis</div>
                                                    <div class="status">Graphic Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-success btn-round btn-xs">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Chad</div>
                                                    <div class="status">CEO Zeleaf</div>
                                                </div>
                                                <button class="btn btn-icon btn-success btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Talha</div>
                                                    <div class="status">Front End Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-success btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">John Doe</div>
                                                    <div class="status">Back End Developer</div>
                                                </div>
                                                <button class="btn btn-icon btn-success btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Talha</div>
                                                    <div class="status">Front End Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-success btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                            <div class="item-list">
                                                <div class="avatar">
                                                    <img :src="user.avatar" alt="..." class="avatar-img rounded-circle">
                                                </div>
                                                <div class="info-user ml-3">
                                                    <div class="username">Jimmy Denis</div>
                                                    <div class="status">Graphic Designer</div>
                                                </div>
                                                <button class="btn btn-icon btn-success btn-round btn-xs">
                                                    <i class="fa fa-user"></i>
                                                </button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                           
                            </div>
                    </div>
                </div>
                
            </div> -->
            
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import { setTimeout } from 'timers';
import Chart from 'chart.js';
import Vue from 'vue'
export default {
    data(){
        return{
            currentDateTime : ''
        }
    },
    computed:{
        ...mapGetters({
            user : 'getUser'
        }),
        
    },
    mounted(){
        moment.locale('fr');

        setInterval(()=>{
            this.currentDateTime = moment().format("dddd DD MMMM YYYY HH:mm:ss")
        },1000)
        var ctx = document.getElementById('absencessemaines').getContext('2d');
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
        var htmlLegendsChart = document.getElementById('abcencesretards').getContext('2d');
        var gradientStroke = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
        gradientStroke.addColorStop(0, '#177dff');
        gradientStroke.addColorStop(1, '#80b6f4');

        var gradientFill = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
        gradientFill.addColorStop(0, "rgba(23, 125, 255, 0.7)");
        gradientFill.addColorStop(1, "rgba(128, 182, 244, 0.3)");

        var gradientStroke2 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
        gradientStroke2.addColorStop(0, '#f3545d');
        gradientStroke2.addColorStop(1, '#ff8990');

        var gradientFill2 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
        gradientFill2.addColorStop(0, "rgba(243, 84, 93, 0.7)");
        gradientFill2.addColorStop(1, "rgba(255, 137, 144, 0.3)");

        var gradientStroke3 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
        gradientStroke3.addColorStop(0, '#fdaf4b');
        gradientStroke3.addColorStop(1, '#ffc478');

        var gradientFill3 = htmlLegendsChart.createLinearGradient(500, 0, 100, 0);
        gradientFill3.addColorStop(0, "rgba(253, 175, 75, 0.7)");
        gradientFill3.addColorStop(1, "rgba(255, 196, 120, 0.3)");

        var myHtmlLegendsChart = new Chart(htmlLegendsChart, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [ {
                    label: "Subscribers",
                    borderColor: gradientStroke2,
                    pointBackgroundColor: gradientStroke2,
                    pointRadius: 0,
                    backgroundColor: gradientFill2,
                    legendColor: '#f3545d',
                    fill: true,
                    borderWidth: 1,
                    data: [154, 184, 175, 203, 210, 231, 240, 278, 252, 312, 320, 374]
                }, {
                    label: "New Visitors",
                    borderColor: gradientStroke3,
                    pointBackgroundColor: gradientStroke3,
                    pointRadius: 0,
                    backgroundColor: gradientFill3,
                    legendColor: '#fdaf4b',
                    fill: true,
                    borderWidth: 1,
                    data: [256, 230, 245, 287, 240, 250, 230, 295, 331, 431, 456, 521]
                }, {
                    label: "Active Users",
                    borderColor: gradientStroke,
                    pointBackgroundColor: gradientStroke,
                    pointRadius: 0,
                    backgroundColor: gradientFill,
                    legendColor: '#177dff',
                    fill: true,
                    borderWidth: 1,
                    data: [542, 480, 430, 550, 530, 453, 380, 434, 568, 610, 700, 900]
                }]
            },
            options : {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    bodySpacing: 4,
                    mode:"nearest",
                    intersect: 0,
                    position:"nearest",
                    xPadding:10,
                    yPadding:10,
                    caretPadding:10
                },
                layout:{
                    padding:{left:15,right:15,top:15,bottom:15}
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "500",
                            beginAtZero: false,
                            maxTicksLimit: 5,
                            padding: 20
                        },
                        gridLines: {
                            drawTicks: false,
                            display: false
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            zeroLineColor: "transparent"
                        },
                        ticks: {
                            padding: 20,
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "500"
                        }
                    }]
                },
                legendCallback: function(chart) {
                    var text = [];
                    text.push('');
                    for (var i = 0; i < chart.data.datasets.length; i++) {
                        text.push('');
                        if (chart.data.datasets[i].label) {
                            text.push(chart.data.datasets[i].label);
                        }
                        text.push('');
                    }
                    text.push('');
                    return text.join('');
                }
            }
        });

        var myLegendContainer = document.getElementById("myChartLegend");

        // generate HTML legend
        myLegendContainer.innerHTML = myHtmlLegendsChart.generateLegend();

        // bind onClick event to all LI-tags of the legend
        var legendItems = myLegendContainer.getElementsByTagName('li');
        for (var i = 0; i < legendItems.length; i += 1) {
            legendItems[i].addEventListener("click", legendClickCallback, false);
        }
        
        setTimeout(function() {
            Circles.create({
                id:           'circles-1',
                radius:       50,
                value:        38,
                maxValue:     100,
                width:        7,
                text:         function(value){return value},
                colors:       ['#eee', '#f49c31'],
                duration:     400,
                wrpClass:     'circles-wrp',
                textClass:    'circles-text',
                styleWrapper: true,
                styleText:    true
            })
            Circles.create({
                id:           'circles-2',
                radius:       50,
                value:        30,
                maxValue:     100,
                width:        7,
                text:         function(value){return value},
                colors:       ['#eee', '#f25961'],
                duration:     400,
                wrpClass:     'circles-wrp',
                textClass:    'circles-text',
                styleWrapper: true,
                styleText:    true
            })
            Circles.create({
                id:           'circles-3',
                radius:       50,
                value:        80,
                maxValue:     100,
                width:        7,
                text:         function(value){return value},
                colors:       ['#eee', '#59ba32'],
                duration:     400,
                wrpClass:     'circles-wrp',
                textClass:    'circles-text',
                styleWrapper: true,
                styleText:    true
            })
        },1000)
    },
    updated(){
        
    }
}


</script>
