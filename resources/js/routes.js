import {store} from './store.js';

import home from './pages/home'
import notFound from './pages/notFound'
import editProfile from './components/profile/editProfile'
import usersList from './components/profile/usersList'
import addUser from './components/profile/addUser'
import editUser from './components/profile/editUser'
import myPasswordChange from './components/profile/myPasswordChange'
import Settingssingle from './components/settings/Settingssingle'
import Formulessingle from './components/Formules/Formules-single'
import Formuleslist from './components/Formules/Formules-list'
import Formulescreate from './components/Formules/Formules-create'
import Companiessingle from './components/Companies/Companies-single'
import Companieslist from './components/Companies/Companies-list'
import Companiescreate from './components/Companies/Companies-create'
import Abonnementssingle from './components/Abonnements/Abonnements-single'
import Abonnementslist from './components/Abonnements/Abonnements-list'
import Abonnementscreate from './components/Abonnements/Abonnements-create'

const routes = [

    {path : '/', component : home, name : 'home', props: true, meta: { route: 'home' } },
    {path : '/editprofile', component : editProfile, name : 'editProfile'},
    {path : '/adduser', component : addUser, name : 'addUser', meta: { route: 'user' } },
    {path : '/edituser/:id', component : editUser, name : 'editUser', meta: { route: 'user' } },
    {path : '/users', component : usersList, name : 'usersList', meta: { route: 'user' }},
    {path : '/passwordchange', component : myPasswordChange, name : 'myPasswordChange'},
    {path : '/users/:id', component : editUser, name : 'editUser', meta: { route: 'user' },beforeEnter(to, from, next){
        console.log(store.getters.getUser.role=='superadmin')
        if (store.getters.getUser.role=='superadmin'){
            next()
        }else{
            alert('Vous ne pouvez pas entrer!')
            next({
                name: "home" // back to safety route //
              });
        }
    }  },
    {path : '/settings', component : Settingssingle, name : 'settings', meta: { route: 'settings' }, beforeEnter(to, from, next){
            console.log(store.getters.getUser.role=='superadmin')
            if (store.getters.getUser.role=='superadminadmin'){
                next()
            }else{
                alert('Vous ne pouvez pas entrer!')
                next({
                    name: "home" // back to safety route //
                  });
            }
    } },
    {path : '/abonnements/:id', component : Abonnementssingle, name : 'Abonnementssingle', props: true, meta: { route: 'parametres' } },
    {path : '/abonnements', component : Abonnementslist , name : 'Abonnementslist', props: true, meta: { route: 'parametres' } },
    {path : '/createabonnements', component : Abonnementscreate , name : 'Abonnementscreate', props: true, meta: { route: 'parametres' } },
    {path : '/formules/:id', component : Formulessingle, name : 'Formulessingle', props: true, meta: { route: 'parametres' } },
    {path : '/formules', component : Formuleslist , name : 'Formuleslist', props: true, meta: { route: 'parametres' } },
    {path : '/createformules', component : Formulescreate , name : 'Formulescreate', props: true, meta: { route: 'parametres' } },
    {path : '/companies/:id', component : Companiessingle, name : 'Companiessingle', props: true, meta: { route: 'parametres' } },
    {path : '/companies', component : Companieslist , name : 'Companieslist', props: true, meta: { route: 'parametres' } },
    {path : '/createcompanies', component : Companiescreate , name : 'Companiescreate', props: true, meta: { route: 'parametres' } },
    
    {path : '*' , component : notFound, name : '404'}
]

export default routes
 

 

 

 
 
 
 
 
 
 