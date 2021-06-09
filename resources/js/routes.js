import {store} from './store.js';

import home from './pages/home'
import notFound from './pages/notFound'
import editProfile from './components/profile/editProfile'
import usersList from './components/profile/usersList'
import addUser from './components/profile/addUser'
import editUser from './components/profile/editUser'
import myPasswordChange from './components/profile/myPasswordChange'
import editEmploye from './components/employe/editEmploye'
import addEmploye from './components/employe/addEmploye'
import employesList from './components/employe/employesList'
import Settingssingle from './components/settings/Settingssingle'
import affectationEmploi from './components/employe/affectationEmploi'

import DepartementsList from './components/departements/Departementslist'
import Departementssingle from './components/departements/Departementssingle'
import Departementscreate from './components/departements/Departementscreate'

import ZonesList from './components/zones/Zoneslist'
import Zonessingle from './components/zones/Zonessingle'
import Zonescreate from './components/zones/Zonescreate'

import PortesList from './components/portes/Porteslist'
import Portessingle from './components/portes/Portessingle'
import Portescreate from './components/portes/Portescreate'

import BatimentsList from './components/batiments/Batimentslist'
import Batimentssingle from './components/batiments/Batimentssingle'
import Batimentscreate from './components/batiments/Batimentscreate'

import TimezonesList from './components/timezones/Timezoneslist'
import Timezonessingle from './components/timezones/Timezonessingle'
import Timezonescreate from './components/timezones/Timezonescreate'
import accessAffectations from './components/access/accessAffectations'
import rapportAffectations from './components/access/rapportAffectations'
import historique from './components/access/historique'
import pointage from './components/access/pointage'

const routes =  [

    {path : '/', component : home, name : 'home', props: true, meta: { route: 'home' } },
    {path : '/editprofile', component : editProfile, name : 'editProfile'},
    {path : '/adduser', component : addUser, name : 'addUser', meta: { route: 'user' } },
    {path : '/edituser/:id', component : editUser, name : 'editUser', meta: { route: 'user' } },
    {path : '/users', component : usersList, name : 'usersList', meta: { route: 'user' }},
    {path : '/passwordchange', component : myPasswordChange, name : 'myPasswordChange'},
    {path : '/ajoutemploye', component : addEmploye, name : 'addEmploye', meta: { route: 'employe' }},
    {path : '/editemploye/:id', component : editEmploye, name : 'editEmploye', meta: { route: 'employe' }},
    {path : '/employes', component : employesList, name : 'employesList', meta: { route: 'employe' }},
    {path : '/settings', component : Settingssingle, name : 'settings', meta: { route: 'settings' }, beforeEnter(to, from, next){
            console.log(store.getters.getUser.role=='admin')
            if (store.getters.getUser.role=='admin'){
                next()
            }else{
                alert('Vous ne pouvez pas entrer!')
                next({
                    name: "home" // back to safety route //
                  });
            }
    } },
    {path : '/affectationemploi', component : affectationEmploi, name : 'affectationEmploi', meta: { route: 'employe' }},
    
    
    {path : '/departements', component : DepartementsList, name : 'DepartementsList', meta: { route: 'employe' }},
    {path : '/departements/:id', component : Departementssingle, name : 'Departementssingle', meta: { route: 'employe' }},
    {path : '/createdepartements', component : Departementscreate, name : 'Departementscreate', meta: { route: 'employe' }},
    
    {path : '/zones', component : ZonesList, name : 'ZonesList', meta: { route: 'zones' }},
    {path : '/zones/:id', component : Zonessingle, name : 'Zonessingle', meta: { route: 'zones' }},
    {path : '/createzones', component : Zonescreate, name : 'Zonescreate', meta: { route: 'zones' }},

    {path : '/portes', component : PortesList, name : 'PortesList', meta: { route: 'zones' }},
    {path : '/portes/:id', component : Portessingle, name : 'Portessingle', meta: { route: 'zones' }},
    {path : '/createportes', component : Portescreate, name : 'Portescreate', meta: { route: 'zones' }},
    
    {path : '/batiments', component : BatimentsList, name : 'BatimentsList', meta: { route: 'zones' }},
    {path : '/batiments/:id', component : Batimentssingle, name : 'Batimentssingle', meta: { route: 'zones' }},
    {path : '/createbatiments', component : Batimentscreate, name : 'Batimentscreate', meta: { route: 'zones' }},

    {path : '/timezones', component : TimezonesList, name : 'TimezonesList', meta: { route: 'timezone' }},
    {path : '/timezones/:id', component : Timezonessingle, name : 'Timezonessingle', meta: { route: 'timezone' }},
    {path : '/createtimezones', component : Timezonescreate, name : 'Timezonescreate', meta: { route: 'timezone' }},

    {path : '/affectationsaccess', component : accessAffectations, name : 'accessAffectations', meta: { route: 'timezone' }},
    {path : '/rapportaffectations', component : rapportAffectations, name : 'rapportAffectations', meta: { route: 'timezone' }},
    {path : '/historique', component : historique, name : 'historique', meta: { route: 'historique' }},
    {path : '/pointage', component : pointage, name : 'pointage', meta: { route: 'historique' }},

    {path : '*' , component : notFound, name : '404'}
]

export default routes