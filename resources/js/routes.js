import {store} from './store.js';

import home from './pages/home'
import notFound from './pages/notFound'

import usersList from './components/profile/usersList'
import addUser from './components/profile/addUser'
import editUser from './components/profile/editUser'
import myPasswordChange from './components/profile/myPasswordChange'

import Settingssingle from './components/settings/Settingssingle'


const routes =  [

    {path : '/', component : home, name : 'home', props: true, meta: { route: 'home' } },
    {path : '/adduser', component : addUser, name : 'addUser', meta: { route: 'user' } },
    {path : '/edituser/:id', component : editUser, name : 'editUser', meta: { route: 'user' } },
    {path : '/users', component : usersList, name : 'usersList', meta: { route: 'user' }},
    {path : '/passwordchange', component : myPasswordChange, name : 'myPasswordChange'},
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

    {path : '*' , component : notFound, name : '404'}
]

export default routes