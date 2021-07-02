import {store} from './store.js';
import Questionssingle from './components/Questions/Questions-single'
 import Questionslist from './components/Questions/Questions-list'
 import Questionscreate from './components/Questions/Questions-create'
import Enquetessingle from './components/Enquetes/Enquetes-single'
import Enqueteslist from './components/Enquetes/Enquetes-list'
import Enquetescreate from './components/Enquetes/Enquetes-create'
import singleFront from './components/Enquetes/singleFront'
import afterresponse from './components/Enquetes/afterresponse'
import Emplacementssingle from './components/Emplacements/Emplacements-single'
 import Emplacementslist from './components/Emplacements/Emplacements-list'
 import Emplacementscreate from './components/Emplacements/Emplacements-create'
import home from './pages/home'
import notFound from './pages/notFound'
import editProfile from './components/profile/editProfile'
import usersList from './components/profile/usersList'
import addUser from './components/profile/addUser'
import CompanyUsersList from './components/profile/CompanyUsersList'
import CompanyAddUser from './components/profile/CompanyAddUser'
import editUser from './components/profile/editUser'
import editCompanyUser from './components/profile/editCompanyUser'

import myPasswordChange from './components/profile/myPasswordChange'
import Settingssingle from './components/settings/Settingssingle'
import Formulessingle from './components/Formules/Formules-single'
import singleFormule from './components/Formules/single'
import formulesView from './components/Formules/formules'

import Formuleslist from './components/Formules/Formules-list'
import Formulescreate from './components/Formules/Formules-create'
import Companiessingle from './components/Companies/Companies-single'
import Companieslist from './components/Companies/Companies-list'
import Companiescreate from './components/Companies/Companies-create'
import Abonnementssingle from './components/Abonnements/Abonnements-single'
import Abonnementslist from './components/Abonnements/Abonnements-list'
import Abonnementscreate from './components/Abonnements/Abonnements-create'
import MesEmplacements from './components/Emplacements/MesEmplacements'
import CompanyAbonnements from './components/Abonnements/CompanyAbonnements'


const routes = [

    {path : '/', component : home, name : 'accueil', props: true, meta: { route: 'home' } },
    {path : '/home', component : home, name : 'home', props: true, meta: { route: 'home' } },
    {path : '/editprofile', component : editProfile, name : 'editProfile'},
    {path : '/mesemplacements', component : MesEmplacements, name : 'MesEmplacements', meta: { route: 'menu' } },
    {path : '/companyadduser', component : CompanyAddUser, name : 'CompanyAddUser', meta: { route: 'user' } },
    {path : '/companyusers', component : CompanyUsersList, name : 'CompanyUsersList', meta: { route: 'user' }},
    {path : '/adduser', component : addUser, name : 'addUser', meta: { route: 'user' } },
    {path : '/edituser/:id', component : editUser, name : 'editUser', meta: { route: 'user' } },
    {path : '/editcuser/:id', component : editCompanyUser, name : 'editCompanyUser', meta: { route: 'user' },beforeEnter(to, from, next){

        if (['admin','superadmin'].includes(store.getters.getUser.role)){
            next()
        }else{
            alert('Vous ne pouvez pas entrer!')
            $router.go(-1)
        }
    } },
    {path : '/users', component : usersList, name : 'usersList', meta: { route: 'user' }},
    {path : '/passwordchange', component : myPasswordChange, name : 'myPasswordChange'},
    {path : '/users/:id', component : editUser, name : 'editUser', meta: { route: 'user' },beforeEnter(to, from, next){
        console.log(store.getters.getUser.role=='superadmin')
        if (store.getters.getUser.role=='superadmin'){
            next()
        }else{
            alert('Vous ne pouvez pas entrer!')
            $router.go(-1)
        }
    }  },
    {path : '/settings', component : Settingssingle, name : 'settings', meta: { route: 'settings' },beforeEnter(to, from, next){
        console.log(store.getters.getUser.role=='superadmin')
        if (store.getters.getUser.role=='superadmin'){
            next()
        }else{
            alert('Vous ne pouvez pas entrer!')
            $router.go(-1)
        }
    }},
    {path : '/abonnements/:id', component : Abonnementssingle, name : 'Abonnementssingle', props: true, meta: { route: 'parametres' } },
    {path : '/abonnements', component : Abonnementslist , name : 'Abonnementslist', props: true, meta: { route: 'parametres' } },
    {path : '/mesabonnements', component : CompanyAbonnements , name : 'CompanyAbonnements', props: true, meta: { route: 'parametres' } },
    {path : '/createabonnements', component : Abonnementscreate , name : 'Abonnementscreate', props: true, meta: { route: 'parametres' } },
    {path : '/formules/:id', component : Formulessingle, name : 'Formulessingle', props: true, meta: { route: 'parametres' } },
    {path : '/formule/view/:id', component : singleFormule, name : 'singleFormule', props: true, meta: { route: 'details' } },
    {path : '/formule/view', component : formulesView, name : 'formulesView', props: true, meta: { route: 'details' } },
    
    {path : '/formules', component : Formuleslist , name : 'Formuleslist', props: true, meta: { route: 'parametres' },beforeEnter(to, from, next){
        if (store.getters.getUser.role=='superadmin'){
            next()
        }else{
            alert('Vous ne pouvez pas entrer!')
            $router.go(-1)
        }
    } },
    {path : '/createformules', component : Formulescreate , name : 'Formulescreate', props: true, meta: { route: 'parametres' } },
    {path : '/companies/:id', component : Companiessingle, name : 'Companiessingle', props: true, meta: { route: 'parametres' } },
    {path : '/companies', component : Companieslist , name : 'Companieslist', props: true, meta: { route: 'parametres' }, beforeEnter(to, from, next){
        if (store.getters.getUser.role=='superadmin'){
            next()
        }else{
            alert('Vous ne pouvez pas entrer!')
            $router.go(-1)
        }
    }  },
    {path : '/createcompanies', component : Companiescreate , name : 'Companiescreate', props: true, meta: { route: 'parametres' } },
    {path : '/emplacements/:id', component : Emplacementssingle, name : 'Emplacementssingle', props: true, meta: { route: 'menu' } },
    {path : '/emplacements', component : Emplacementslist , name : 'Emplacementslist', props: true, meta: { route: 'menu' } },
    {path : '/createemplacements', component : Emplacementscreate , name : 'Emplacementscreate', props: true, meta: { route: 'menu' } },
    {path : '/enquetes/:id', component : Enquetessingle, name : 'Enquetessingle', props: true, meta: { route: 'menu' } },
    {path : '/enquetes', component : Enqueteslist , name : 'Enqueteslist', props: true, meta: { route: 'menu' } },
    {path : '/createenquetes', component : Enquetescreate , name : 'Enquetescreate', props: true, meta: { route: 'menu' } },
    {path : '/enquete/view/:id', component : singleFront , name : 'singleFront', props: true, meta: { route: 'front' } },
    {path : '/enquete/result/:id', component : afterresponse , name : 'afterresponse', props: true, meta: { route: 'front' } },
    
    
    {path : '/questions/:id', component : Questionssingle, name : 'Questionssingle', props: true, meta: { route: 'menu' } },
    {path : '/questions', component : Questionslist , name : 'Questionslist', props: true, meta: { route: 'menu' } },
    {path : '/createquestions', component : Questionscreate , name : 'Questionscreate', props: true, meta: { route: 'menu' } },

    {path : '*' , component : notFound, name : '404'}
]

export default routes
 

 

 

 
 
 
 
 
 
 
 
 
 
 